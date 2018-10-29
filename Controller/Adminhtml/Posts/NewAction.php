<?php
namespace BitHive\Topic\Controller\Adminhtml\Posts;

class NewAction extends \Magento\Backend\App\Action
{
    protected $resultForwardFactory;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory)
	{
		$this->resultForwardFactory = $resultForwardFactory;
		return parent::__construct($context);
	}

	public function execute()
    {
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}

