<?php
namespace BitHive\Topic\Model\ResourceModel\Post;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'post_id';
    protected $_eventPrefix = 'bithive_topic_post_collection';
    protected $_eventObject = 'post_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\BitHive\Topic\Model\Post::class, \BitHive\Topic\Model\ResourceModel\Post::class);
    }

}
