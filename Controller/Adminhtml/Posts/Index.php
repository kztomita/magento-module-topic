<?php
namespace BitHive\Topic\Controller\Adminhtml\Posts;

class Index extends \Magento\Backend\App\Action
{
    protected $pageFactory;
    protected $postFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \BitHive\Topic\Model\PostFactory $postFactory)
    {
        $this->pageFactory = $pageFactory;
        // PostFactoryクラスはModel名+Factoryで自動生成されるクラス
        $this->postFactory = $postFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        //return $this->dumpCollection();
        return $this->viewTemplate();
    }

    private function dumpCollection()
    {
        $post = $this->postFactory->create();
        $collection = $post->getCollection();
        foreach($collection as $item){
            echo "<pre>";
            print_r($item->getData());
            echo "</pre>";
        }
        exit();
    }

    private function viewTemplate()
    {
        $resultPage = $this->pageFactory->create();

        // <title>をいじる
        $resultPage->getConfig()->getTitle()->prepend((__('Posts')));

        return $resultPage;
    }
}

