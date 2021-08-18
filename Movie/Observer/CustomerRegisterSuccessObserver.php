<?php
namespace Magenest\Movie\Observer;

use Magento\Framework\Event\ObserverInterface;
use \Psr\Log\LoggerInterface;
use \Magento\Framework\Event\Observer;
use Magento\Customer\Api\CustomerRepositoryInterface;
use \Magento\Framework\App\RequestInterface;
use Magento\Customer\Model\CustomerFactory;

class CustomerRegisterSuccessObserver implements ObserverInterface
{
    /** @var \Psr\Log\LoggerInterface $logger */
    protected $logger;
    protected $customerRepository;
    protected $customerFactory;
    protected $request;

    public function __construct(
        LoggerInterface $logger,
        CustomerRepositoryInterface $customerRepository,
        CustomerFactory $customerFactory,
        RequestInterface $request
    ){
        $this->logger = $logger;
        $this->customerRepository = $customerRepository;
        $this->request = $request;
        $this->customerFactory = $customerFactory;
    }

    public function execute(Observer $observer)
    {
        $customer = $observer->getEvent()->getData('customer');
        $customer->setFirstName("Magenest");
        $this->customerRepository->save($customer);
        $this->logger->debug($customer->getFirstName());
        $this->logger->debug($customer->getId());
    }
}