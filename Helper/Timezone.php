<?php
namespace BitHive\Topic\Helper;

class Timezone extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var Magento\Framework\Stdlib\DateTime\TimezoneInterface
    */
    protected $timezone;
 
    /**
    * @param \Magento\Framework\App\Helper\Context $context
    * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface
    */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface
    ) 
    {
        $this->_timezoneInterface = $timezoneInterface;
        parent::__construct($context);
    }

    public function convertTz($dateTime, $fromTz, $toTz)
    {
        $datetime = new \DateTime($dateTime, new \DateTimeZone($fromTz));

        $datetime->setTimezone(new \DateTimeZone($toTz));

        return $datetime->format('Y-m-d H:i:s');
    }
}
