<?php
namespace Magenest\Movie\Controller\Index;

use \Magento\Framework\App\Action\Action;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;

class Event extends Action {

    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute() {
        $resultPage = $this->resultPageFactory->create();
        $parameters = [
            'product' => $this->_objectManager->create('Magento\Catalog\Model\Product')->load(50),
            'category' => $this->_objectManager->create('Magento\Catalog\Model\Product')->load(10),
        ];
        $this->_eventManager->dispatch('movie_register_visit',$parameters);
        return $resultPage;
    }
}