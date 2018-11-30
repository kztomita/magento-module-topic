<?php
namespace BitHive\Topic\Model;

use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

class Post extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'bithive_topic_post';

    protected $_cacheTag = 'bithive_topic_post';

    protected $_eventPrefix = 'bithive_topic_post';

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $timezone;

    public function __construct(
        Context $context,
        Registry $registry,
        TimezoneInterface $timezone
    )
    {
        $this->timezone = $timezone;
        parent::__construct($context, $registry);
    }

    protected function _construct()
    {
        // ResouceModelのクラス名
        $this->_init(\BitHive\Topic\Model\ResourceModel\Post::class);
    }

    // IdentityInterfaceのメソッド
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function beforeSave()
    {
        // 更新時のmodifiedを自動設定させるため
        $this->setData('modified', null);

        return parent::beforeSave();
    }

    // $this->getData('date') で取得される時刻はUTCなので、
    // タイムゾーンを指定して時刻を取得するメソッド
    // nullの場合はconfigに従う。
    public function getConvertedDate($format = 'Y-m-d H:i:s', $tz = null)
    {
        $defaultTz = $this->timezone->getDefaultTimezone(); // 'UTC'
        $configTz = $this->timezone->getConfigTimezone();   // 'Asia/Tokyo' Websiteの設定が参照されるみたい

        $tz = $tz ?: $configTz;

        $date = $this->getData('date');  // default timezone(UTC)での時刻

        $datetime = new \DateTime($date, new \DateTimeZone($defaultTz));

        $datetime->setTimezone(new \DateTimeZone($tz));

        return $datetime->format($format);
    }
}
