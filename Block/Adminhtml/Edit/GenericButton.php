<?php
namespace BitHive\Topic\Block\Adminhtml\Edit;

// 参考: app/code/Magento/Cms/Block/Adminhtml/Block/Edit/GenericButton.php

use Magento\Backend\Block\Widget\Context;
use BitHive\Topic\Model\PostFactory;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var PostFactory
     */
    protected $postFactory;

    /**
     * @param Context $context
     * @param PostFactory $postFactory
     */
    public function __construct(
        Context $context,
        PostFactory $postFactory
    ) {
        $this->context = $context;
        $this->postFactory = $postFactory;
    }

    /**
     * Return Post ID
     *
     * @return int|null
     */
    public function getPostId()
    {
        // XXX Cmsと同じようにRepository Patternで行うとよい

        $postId = $this->context->getRequest()->getParam('post_id');

        $post = $this->postFactory->create();
        $post->load($postId);
        if (!$post->getId()) {
            return null;
        }
        return $post->getId();
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
