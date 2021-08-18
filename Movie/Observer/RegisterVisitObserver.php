<?php
namespace Magenest\Movie\Observer;

use Magento\Framework\Event\ObserverInterface;
use \Psr\Log\LoggerInterface;
use \Magento\Framework\Event\Observer;

class RegisterVisitObserver implements ObserverInterface
{
    /** @var \Psr\Log\LoggerInterface $logger */
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    public function execute(Observer $observer)
    {
        //$this->logger->debug('Registered');
        $product = $observer->getProduct();
        $category = $observer->getCategory();
        $this->logger->debug(print_r($product->debug(), true));
        $this->logger->debug(print_r($category->debug(), true));
    }
}