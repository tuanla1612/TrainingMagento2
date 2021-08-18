<?php
namespace Magenest\Movie\Observer;

use Magento\Framework\Event\ObserverInterface;
use \Psr\Log\LoggerInterface;
use \Magento\Framework\Event\Observer;
use \Magento\Sales\Api\OrderRepositoryInterface;
use \Magento\Sales\Model\Service\InvoiceService;
use \Magento\Sales\Model\OrderFactory;
use Magento\Framework\DB\Transaction;

class Invoices implements ObserverInterface
{
    /** @var \Psr\Log\LoggerInterface $logger */
    protected $logger;
    private $orderInterface;
    private $invoiceService;
    private $orderFactory;
    private $transaction;

    public function __construct(
        LoggerInterface $logger,
        OrderRepositoryInterface $orderInterface,
        InvoiceService $invoiceService,
        OrderFactory $orderFactory,
        Transaction $transaction

    ){
        $this->logger = $logger;
        $this->orderInterface = $orderInterface;
        $this->invoiceService = $invoiceService;
        $this->orderFactory = $orderFactory;
        $this->transaction = $transaction;
    }
    
    public function execute(Observer $observer)
    {
        $orderIds = $observer->getEvent()->getOrderIds();
        echo $orderId = $orderIds[0]; 
        $order = $this->orderInterface->get($orderIds[0]);
        echo $order->getBaseGrandTotal();
        if($order->getBaseGrandTotal() == 0){
            $order_update = $this->orderFactory->create()->load($orderIds[0])->setStatus('processing');

            $invoice = $this->invoiceService->prepareInvoice($order_update);
            $invoice->register();
            $invoice->save();
            $transactionSave = $this->transaction->addObject(
                $invoice
            )->addObject(
                $invoice->getOrder()
            );
            $transactionSave->save();
        };
    }
}