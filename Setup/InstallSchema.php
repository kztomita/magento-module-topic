<?php
namespace BitHive\Topic\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
	{
		$installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('bithive_topic_post')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('bithive_topic_post')
            )
                   ->addColumn(
                       'post_id',
                       \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                       null,
                       [
                           'identity' => true,
                           'nullable' => false,
                           'primary'  => true,
                           'unsigned' => true,
                       ],
                       'Post ID'
                   )
                   ->addColumn(
                       'message',
                       \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                       255,
                       ['nullable => false'],
                       'Post Message'
                   )
                   ->addColumn(
                       'date',
                       \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                       null,
                       ['nullable => false'],
                       'Date'
                   )
                   ->addColumn(
                       'created',
                       \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                       null,
                       ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                       'Created Time'
                   )
                   ->addColumn(
                       'modified',
                       \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                       null,
                       ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                       'Modified Time'
                   )
                   ->addIndex(
                       $installer->getIdxName('bithive_topic_post', ['date']),
                       ['date']
                   )
                   ->setComment('News Table');
			$installer->getConnection()->createTable($table);
		}
		$installer->endSetup();
	}
}
