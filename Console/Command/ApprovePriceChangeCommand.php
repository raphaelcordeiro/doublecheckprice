<?php

namespace MagentoModules\DoubleCheckPrice\Console\Command;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Magento\Framework\Exception\NoSuchEntityException;
use MagentoModules\DoubleCheckPrice\Model\Repository\DoubleCheckPriceRepositoryFactory;
use MagentoModules\DoubleCheckPrice\Helper\Data as HelperData;

class ApprovePriceChangeCommand extends Command
{
    const ENTITY_ID = 'id';
    /**
     * @var DoubleCheckPriceRepositoryFactory
     */
    private DoubleCheckPriceRepositoryFactory $repository;
    /**
     * @var HelperData
     */
    private HelperData $helper;

    /**
     * @param DoubleCheckPriceRepositoryFactory $repositoryFactory
     * @param HelperData                        $helperData
     */
    public function __construct(
        DoubleCheckPriceRepositoryFactory $repositoryFactory,
        HelperData $helperData
    ) {
        parent::__construct();
        $this->repository = $repositoryFactory;
        $this->helper = $helperData;
    }

    protected function configure()
    {
        $this->setName('approve:price:change')
            ->setDescription('Command to approve price changes')
            ->addArgument(
                self::ENTITY_ID,
                InputArgument::REQUIRED,
                'Price change request id'
            );
    }


    /**
     * CLI command description.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    final protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $entityId = $input->getArgument(self::ENTITY_ID);
        $repository = $this->repository->create();
        try {
            $repository->approve($entityId);
            $output->writeln('<info>Price change request approved.</info>');
            $this->helper->dispatchEvent('price_change_approved', ['id' => $entityId]);
            return Command::SUCCESS;
        } catch (NoSuchEntityException $e) {
            $output->writeln('<error>Price change request not found.</error>');
            return Command::FAILURE;
        } catch (Exception $e) {
            $output->writeln('<error>Something went wrong.</error>');
            return Command::FAILURE;
        }
    }
}
