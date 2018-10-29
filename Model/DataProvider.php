<?php
namespace BitHive\Topic\Model;
 
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use BitHive\Topic\Model\ResourceModel\Post\CollectionFactory;
use BitHive\Topic\Helper\Timezone as TimezoneHelper;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

   /**
     * @var array
     */
    protected $loadedData;

   /**
     * @var TimezoneInterface
     */
    protected $timezone;

   /**
     * @var TimezoneHelper
     */
    protected $timezoneHelper;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param TimezoneInterface $timezone
     * @param TimezoneHelper $timezoneHelper
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        TimezoneInterface $timezone,
        TimezoneHelper $timezoneHelper,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->timezone = $timezone;
        $this->timezoneHelper = $timezoneHelper;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
 
    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $this->loadedData[$model->getId()] = $model->getData();

            if ($this->loadedData[$model->getId()]['date']) {
                // UTC -> JST(設定上のタイムゾーン)
                $this->loadedData[$model->getId()]['date'] = $this->timezoneHelper->convertTz($this->loadedData[$model->getId()]['date'], $this->timezone->getDefaultTimezone(), $this->timezone->getConfigTimezone());
            }
        }

        $data = $this->dataPersistor->get('bithive_topic');
        if (!empty($data)) {
            $post = $this->collection->getNewEmptyItem();
            $post->setData($data);
            $this->loadedData[$post->getId()] = $post->getData();
            $this->dataPersistor->clear('bithive_topic');
        }

        return $this->loadedData;
    }
}
