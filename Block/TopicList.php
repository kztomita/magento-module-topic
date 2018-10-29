<?php
namespace BitHive\Topic\Block;

class TopicList extends \Magento\Framework\View\Element\Template implements \Magento\Framework\DataObject\IdentityInterface
{
    protected $postFactory;
    protected $timezone;
    protected $timezoneHelper;

    /**
     * Post Collection
     *
     * @var AbstractCollection
     */
    protected $postCollection;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \BitHive\Topic\Model\PostFactory $postFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
        \BitHive\Topic\Helper\Timezone $timezoneHelper
    ) {
        $this->postFactory = $postFactory;
        $this->timezone = $timezone;
        $this->timezoneHelper = $timezoneHelper;
        parent::__construct($context);
    }

    public function getPostCollection()
    {
        $collection = $this->postFactory->create()->getCollection()
#                    ->addFieldToFilter('post_id', 5)
                    ->setPageSize(5)
                    ->setOrder('date', 'DESC');

        return $collection;
    }

    private function _getPostCollection()
    {
        if ($this->postCollection === null) {
            $collection = $this->postFactory->create()->getCollection()
#                        ->addFieldToFilter('post_id', 5)
                        ->setPageSize(5)
                        ->setOrder('date', 'DESC');
            $this->postCollection = $collection;
        }

        return $this->postCollection;
    }

    // トピック更新時に自動でキャッシュをクリアさせるために実装。
    //
    // ブロック内に表示するPostモデルのIdentitiesの一覧を返すことで、
    // 関連Postモデル更新時に本ブロックを含むページのfull page cacheが
    // クリアされる。
    // キャッシュの更新が不要ならIdentityInterfaceは実装しなくてよい。
    //
    // 参考: app/code/Magento/Catalog/Block/Product/ListProduct.php
    public function getIdentities()
    {
        $identities = [];

        foreach ($this->_getPostCollection() as $item) {
            $identities = array_merge($identities, $item->getIdentities());
        }

        return $identities;
    }
}
