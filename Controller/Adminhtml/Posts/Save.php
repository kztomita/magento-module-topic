<?php
namespace BitHive\Topic\Controller\Adminhtml\Posts;

class Save extends \Magento\Backend\App\Action
{
    protected $pageFactory;
    protected $postFactory;
    protected $dataPersistor;
    protected $timezone;
    protected $timezoneHelper;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
        \BitHive\Topic\Model\PostFactory $postFactory,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
        \BitHive\Topic\Helper\Timezone $timezoneHelper
    )
	{
		$this->pageFactory = $pageFactory;
		$this->postFactory = $postFactory;
        $this->dataPersistor = $dataPersistor;
        $this->timezone = $timezone;
        $this->timezoneHelper = $timezoneHelper;
		return parent::__construct($context);
	}

	public function execute()
    {
        $this->dataPersistor->clear('bithive_topic');

        $data = $this->getRequest()->getPostValue();

        $resultRedirect = $this->resultRedirectFactory->create();

        // validation
        $error = 0;
        if ($data['date']) {
            if (strtotime($data['date']) === false) {
                $this->messageManager->addErrorMessage( __('Date is invalid') );
                $error++;
            }
        }
        if ($error) {
            $this->dataPersistor->set('bithive_topic', $data);
            if (isset($data['post_id'])) {
                return $resultRedirect->setPath('*/*/edit', ['id' => $data['post_id']]);
            } else {
                return $resultRedirect->setPath('*/*/new');
            }
        }

        // システムのtimezone(UTC)に変換
        if ($data['date']) {
            $data['date'] = $this->timezoneHelper->convertTz($data['date'], $this->timezone->getConfigTimezone(), $this->timezone->getDefaultTimezone());
        }

        $model = $this->postFactory->create();

        $model->setData($data);

        $model->save();

        $this->messageManager->addSuccess( __('Saved.') );

        $this->_redirect('*/*/');
    }
}

