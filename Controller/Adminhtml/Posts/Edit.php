<?php
namespace BitHive\Topic\Controller\Adminhtml\Posts;

// 参考: Magento/Cms/Controller/Adminhtml/Block/Edit.php

class Edit extends \Magento\Backend\App\Action
{
    protected $pageFactory;
    protected $postFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \BitHive\Topic\Model\PostFactory $postFactory)
    {
        $this->pageFactory = $pageFactory;
        $this->postFactory = $postFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $postId = $this->getRequest()->getParam('id');

        $model = $this->postFactory->create();

        if ($postId) {
            $model->load($postId);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This post no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $resultPage = $this->pageFactory->create();

        $resultPage->getConfig()->getTitle()->prepend($postId ? __('Edit') : __('New'));

        return $resultPage;
    }
}

