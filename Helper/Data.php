<?php

namespace MagentoModules\DoubleCheckPrice\Helper;

use Exception;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Area;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\User\Model\User;
use Psr\Log\LoggerInterface;
use Magento\User\Model\UserFactory;
use Magento\Framework\Locale\FormatInterface;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Backend\Model\Auth\Session as AdminSession;

class Data extends AbstractHelper
{
    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;
    /**
     * @var TransportBuilder
     */
    private TransportBuilder $transportBuilder;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;
    /**
     * @var UserFactory
     */
    private UserFactory $userFactory;
    /**
     * @var EventManager
     */
    private EventManager $eventManager;
    /**
     * @var FormatInterface
     */
    private FormatInterface $localeFormat;
    /**
     * @var AdminSession
     */
    private AdminSession $adminSession;

    /**
     * @param StoreManagerInterface $storeManager
     * @param TransportBuilder      $transportBuilder
     * @param ScopeConfigInterface  $scopeConfig
     * @param LoggerInterface       $logger
     * @param UserFactory           $userFactory
     * @param EventManager          $eventManager
     * @param FormatInterface       $localeFormat
     * @param AdminSession          $adminSession
     * @param Context               $context
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        TransportBuilder $transportBuilder,
        ScopeConfigInterface $scopeConfig,
        LoggerInterface $logger,
        UserFactory $userFactory,
        EventManager $eventManager,
        FormatInterface $localeFormat,
        AdminSession $adminSession,
        Context $context
    ) {
        $this->storeManager = $storeManager;
        $this->transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
        $this->logger = $logger;
        $this->userFactory = $userFactory;
        $this->eventManager = $eventManager;
        $this->localeFormat = $localeFormat;
        $this->adminSession = $adminSession;
        parent::__construct($context);
    }

    /**
     * @return int|null
     */
    public function getLoggedUserId() : ?int
    {
        if ($this->adminSession->isLoggedIn()) {
            return $this->adminSession->getUser()->getId();
        }
        return null;
    }

    /**
     * @param  string $eventName
     * @param  array  $data
     * @return void
     */
    public function dispatchEvent(string $eventName, array $data = []) : void
    {
        $this->eventManager->dispatch($eventName, $data);
    }

    /**
     * @param  float $price
     * @return string
     */
    public function formatPrice(float $price): string
    {
        $priceFormat = $this->localeFormat->getPriceFormat();
        return number_format($price, $priceFormat['precision'], $priceFormat['decimalSymbol'], $priceFormat['groupSymbol']);
    }

    /**
     * @param  int $userId
     * @return User|null
     */
    public function getUserById(int $userId): ?User
    {
        try {
            $user = $this->userFactory->create()->load($userId);
            return $user->getId() ? $user : null;
        } catch(NoSuchEntityException|Exception $e){
            $this->logger->error($e->getMessage());
            return null;
        }
    }

    /**
     * @param  string      $path
     * @param  string      $scopeType
     * @param  string|null $scopeCode
     * @return mixed
     */
    public function getConfigValue(string $path, string $scopeType = ScopeInterface::SCOPE_STORE, string $scopeCode = null): mixed
    {
        try{
            return $this->scopeConfig->getValue($path, $scopeType, $scopeCode);
        }catch (Exception $e){
            $this->logger->error($e->getMessage());
        }
        return null;
    }

    /**
     * @return bool
     */
    public function isEmailNotificationEnabled(): bool
    {
        return $this->getConfigValue('mail_settings/mail_settings/mail_sender');
    }

    /**
     * @param array  $templateVars
     * @param string $mailSender
     * @param string $recipient
     * @param string $mailTemplate
     */
    public function sendMail(array $templateVars, string $mailSender, string $recipient, string $mailTemplate) : void
    {

        try {
            $store = $this->storeManager->getStore();

            if (!$store || !$templateVars || !$mailSender || !$recipient || !$mailTemplate) {
                throw new Exception("Missing parameters.");
            }

            $storeId = $this->storeManager->getStore()->getId();

            $storeScope = ScopeInterface::SCOPE_STORE;
            $templateOptions = [
                'area' => Area::AREA_ADMINHTML,
                'store' => $storeId
            ];
            $transport = $this->transportBuilder->setTemplateIdentifier($mailTemplate)
                ->setTemplateOptions($templateOptions)
                ->setTemplateVars($templateVars)
                ->setFromByScope($mailSender, $storeScope)
                ->addTo($recipient)
                ->getTransport();
            $transport->sendMessage();
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
