<?php

namespace MagentoModules\DoubleCheckPrice\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Magento\Framework\Exception\NoSuchEntityException;
use MagentoModules\DoubleCheckPrice\Model\Repository\DoubleCheckPriceRepositoryFactory;
use MagentoModules\DoubleCheckPrice\Helper\Data as HelperData;

class EditPriceChangeCommand extends Command
{
    private const ENTITY_ID = 'id';
    private const NEW_PRICE = 'new_price';

    private DoubleCheckPriceRepositoryFactory $repositoryFactory;
    private HelperData $helper;

    public function __construct(
        DoubleCheckPriceRepositoryFactory $repositoryFactory,
        HelperData $helperData
    ) {
        parent::__construct();
        $this->repositoryFactory = $repositoryFactory;
        $this->helper = $helperData;
    }

    protected function configure()
    {
        $this->setName('edit:price:change')
            ->setDescription('Edit change price requests')
            ->addArgument(
                self::ENTITY_ID,
                InputArgument::REQUIRED,
                'Price change request id'
            )
            ->addArgument(
                self::NEW_PRICE,
                InputArgument::REQUIRED,
                'New Price'
            );
    }

    /**
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return int
     */
    final protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $entityId = $input->getArgument(self::ENTITY_ID);
        $newPrice = $input->getArgument(self::NEW_PRICE);

        $repository = $this->repositoryFactory->create();

        try {
            $repository->editPrice($entityId, $this->helper->formatPrice($newPrice));
            $output->writeln("<info>Request to change price with id $entityId edited successfully.</info>");
            return Command::SUCCESS;
        } catch (NoSuchEntityException $exception) {
            $output->writeln("<error>Request not found for ID $entityId.</error>");
            return Command::FAILURE;
        } catch (\Exception $exception) {
            $output->writeln("<error>Error occurred: {$exception->getMessage()}</error>");
            return Command::FAILURE;
        }
    }
}
