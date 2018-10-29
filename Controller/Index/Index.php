<?php
namespace BitHive\Topic\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
	protected $pageFactory;
	protected $postFactory;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
        \BitHive\Topic\Model\PostFactory $postFactory)
	{
		$this->pageFactory = $pageFactory;
		$this->postFactory = $postFactory;
		return parent::__construct($context);
	}

	public function execute()
	{
        // データの取得はBlockで行う
/*
        $collection = $this->postFactory->create()->getCollection()
#                    ->addFieldToFilter('post_id', 5)
                    ->setPageSize(5)
                    ->setOrder('date', 'DESC');

        foreach($collection as $item){
            echo "<pre>";
            print_r($item->getData());
            echo "</pre>";
        }
        exit;
*/
        return $this->pageFactory->create();
	}
}

