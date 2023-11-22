<?php

namespace MagentoModules\DoubleCheckPrice\Console\Command;

use Exception;
use MagentoModules\DoubleCheckPrice\Api\DoubleCheckPriceRepositoryInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class DeleteByIdCommand extends Command
{
    private const ENTITY_ID = 'id';

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;
    /**
     * @var DoubleCheckPriceRepositoryInterface
     */
    private DoubleCheckPriceRepositoryInterface $repository;

    /**
     * @param LoggerInterface                     $logger
     * @param DoubleCheckPriceRepositoryInterface $repository
     */
    public function __construct(
        LoggerInterface $logger,
        DoubleCheckPriceRepositoryInterface $repository
    ) {
        parent::__construct();
        $this->logger = $logger;
        $this->repository = $repository;
    }

    protected function configure()
    {
        $this->setName('delete:price:change')
            ->setDescription('Delete change price requests')
            ->addArgument(
                self::ENTITY_ID,
                null,
                InputArgument::REQUIRED,
                'Price change request id'
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

        if (!$entityId) {
            $output->writeln("<error>No ID provided. Use --id to specify the Price Change Request ID.</error>");
            return Command::FAILURE;
        }

        try {
            $this->repository->deleteById($entityId);
            $output->writeln("<info>Request to change price with id $entityId deleted successfully.</info>");
            return Command::SUCCESS;
        } catch (NoSuchEntityException $exception) {
            $output->writeln("<error>Request not found for ID $entityId.</error>");
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);
            return Command::FAILURE;
        } catch (Exception $exception) {
            $output->writeln("<error>Could not delete DoubleCheckPrice: {$exception->getMessage()}</error>");
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);
            return Command::FAILURE;
        }
    }
}
