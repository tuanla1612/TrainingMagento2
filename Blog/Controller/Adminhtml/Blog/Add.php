<?php
namespace Magenest\Blog\Controller\Adminhtml\Blog;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
class Add extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;
    public function __construct(
    Context $context,
    PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magenest_Blog::blog');
        $resultPage->addBreadcrumb(__('MagenestBlog'), __('MagenestBlog'));
        $resultPage->addBreadcrumb(__('Add Blog'),__('Add Blog'));
        $resultPage->getConfig()->getTitle()->prepend(__('Add Blog'));
        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magenest_Blog::blog');
    }
}