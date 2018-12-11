<?php
namespace BitHive\Topic\Controller\Adminhtml\Posts;

class Delete extends \Magento\Backend\App\Action
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
        $resultRedirect = $this->resultRedirectFactory->create();

        $postId = $this->getRequest()->getParam('id');

        if ($postId) {
            try {
                $model = $this->postFactory->create();

                $model->load($postId);
                $model->delete();

                $this->messageManager->addSuccess(__('You deleted the post.'));

                // 一覧ページへ
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // 編集フォームへ戻す
                return $resultRedirect->setPath('*/*/edit', ['id' => $postId]);
            }
        }

        $this->messageManager->addError(__('We can\'t find a record to delete.'));
        // 一覧ページへ
        return $resultRedirect->setPath('*/*/');
    }
}

