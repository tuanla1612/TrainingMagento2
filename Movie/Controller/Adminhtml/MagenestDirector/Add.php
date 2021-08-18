<?php
namespace Magenest\Movie\Controller\Adminhtml\MagenestDirector;
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
        $resultPage->setActiveMenu('Magenest_Movie::magenestdirector');
        $resultPage->addBreadcrumb(__('MagenestDirector'), __('MagenestDirector'));
        $resultPage->addBreadcrumb(__('Add Director'),__('Add Director'));
        $resultPage->getConfig()->getTitle()->prepend(__('Add Director'));
        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magenest_Movie::magenestdirector');
    }
}