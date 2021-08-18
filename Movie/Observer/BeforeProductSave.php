<?php
namespace Magenest\Movie\Observer;
use Magento\Framework\Event\ObserverInterface;
use \Psr\Log\LoggerInterface;
use \Magento\Framework\App\RequestInterface;
use \Magento\Catalog\Model\ProductFactory;
use \Magento\Framework\Event\Observer;

class BeforeProductSave implements ObserverInterface
{
    protected $request;
    protected $logger;
    protected $productFactory;
    protected $categoryLinkManagementInterface;

    public function __construct(
        LoggerInterface $logger,
        RequestInterface $request,
        ProductFactory $productFactory
    )
    {
        $this->productFactory = $productFactory;
        $this->request = $request;
        $this->logger = $logger;
    }

        public function execute(Observer $observer)
    {
        $data = $this->request->getParams();
        $time = $this->request->getPostValue();
        $id = $data['id'];
//        $product = $observer->getEvent()->getData('product');
        $start = $time['product']['start_course'];
        $end = $time['product']['end_course'];
        $result = $this->productFactory->create()->load($id);
        $result->setData('start_course',$start);
        $result->setData('end_course',$end);
    }
}
