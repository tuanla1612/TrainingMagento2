<?php
namespace Magenest\Movie\Controller\Adminhtml\MagenestMovie;
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
        $resultPage->setActiveMenu('Magenest_Movie::magenestmovie');
        $resultPage->addBreadcrumb(__('MagenestMovie'), __('MagenestMovie'));
        $resultPage->addBreadcrumb(__('Add Movies'),__('Add Movies'));
        $resultPage->getConfig()->getTitle()->prepend(__('Add Movies'));
        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magenest_Movie::magenestmovie');
    }
}