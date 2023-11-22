<?php

namespace MagentoModules\DoubleCheckPrice\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use MagentoModules\DoubleCheckPrice\Model\ResourceModel\DoubleCheckPriceModel\DoubleCheckPriceCollectionFactory as DoubleCheckPriceCollectionFactory;
use MagentoModules\DoubleCheckPrice\Helper\Data as DataHelper;

class ListPendingPricesApprovalsCommand extends Command
{
    private DoubleCheckPriceCollectionFactory $collectionFactory;
    /**
     * @var DataHelper
     */
    private DataHelper $dataHelper;

    /**
     * @param DoubleCheckPriceCollectionFactory $collectionFactory
     * @param DataHelper                        $dataHelper
     */
    public function __construct(
        DoubleCheckPriceCollectionFactory $collectionFactory,
        DataHelper $dataHelper
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->dataHelper = $dataHelper;
        parent::__construct();
    }

    /**
     * @return void
     */
    final protected function configure(): void
    {
        $this->setName('pending:prices:approvals')
            ->setDescription('List Pending Prices Approvals');
    }

    final protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('status', ['eq' => 0]);
        if($collection->getSize()) {
            $output->writeln('No pending prices approvals found.');
            return Command::SUCCESS;
        }
        $table = new Table($output);
        $table->setHeaders(['ID', 'Attribute', 'Product SKU', 'Requester','Old Price', 'New Price', 'Request Date']);

        foreach ($collection as $item) {
            $user = $this->dataHelper->getUserById($item->getUserId());
            $userName = $user ? $user->getName() : 'N/A';

            $table->addRow(
                [
                $item->getId(),
                $item->getAttribute(),
                $item->getSku(),
                $userName,
                $item->getOldPrice(),
                $item->getNewPrice(),
                $item->getCreatedAt()
                ]
            );
        }

        $table->render();
        return Command::SUCCESS;
    }
}
