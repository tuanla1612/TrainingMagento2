<?php
namespace Magenest\Movie\Block;

use Magento\Framework\View\Element\Template;
use \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;

class Index extends Template
{
    private $customerFactory;
    private $productCollectionFactory;
    private $orderCollectionFactory;
    private $invoiceCollectionFactory;
    private $creditmemosCollectionFactory;
    private $fullModuleList;

    public function __construct(
        Template\Context $context,
        CollectionFactory $customerFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Magento\Sales\Model\ResourceModel\Order\Invoice\CollectionFactory $invoiceCollectionFactory,
        \Magento\Sales\Model\ResourceModel\Order\Creditmemo\CollectionFactory $creditmemosCollectionFactory,
        \Magento\Framework\Module\FullModuleList $fullModuleList,
        array $data=[]
    ){
        parent::__construct($context,$data);

        $this->customerFactory = $customerFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->invoiceCollectionFactory = $invoiceCollectionFactory;
        $this->creditmemosCollectionFactory = $creditmemosCollectionFactory;
        $this->fullModuleList = $fullModuleList;
    }

    public function getCustomerNumber(){
        $customerCollection = $this->customerFactory->create();
        return $this->getNumber($customerCollection);
    }

    public function getProductsNumber(){
        $productCollection = $this->productCollectionFactory->create();
        return $this->getNumber($productCollection);
    }

    public function getOrderNumber(){
        $orderCollection = $this->orderCollectionFactory->create();
        return $this->getNumber($orderCollection);
    }

    public function getInvoiceNumber(){
        $invoiceCollection = $this->invoiceCollectionFactory->create();
        return $this->getNumber($invoiceCollection);
    }

    public function getCreditmemosNumber(){
        $creditmemosCollection = $this->creditmemosCollectionFactory->create();
        return $this->getNumber($creditmemosCollection);
    }

    public function getNumber($collection){
        $count = 0;
        foreach($collection as $item){
            $count++;
        }
        return $count;
    }

    public function getModulesList()
    {
        $allModules = $this->fullModuleList->getAll();
        $count = 0;
        foreach($allModules as $item){
            //echo $item["name"]."<br>";
            $count++;
        }
        return $count;
    }

    public function getMagentoModulesList()
    {
        $allModules = $this->fullModuleList->getAll();
        $count = 0;
        foreach($allModules as $item){
            $array = explode("_",$item["name"]);
            if($array[0] == "Magento"){
                $count++;
            }
            //echo $item["name"]."<br>";
        }
        return $count;
    }

    public function getVendorModulesList()
    {
        $allModules = $this->fullModuleList->getAll();
        $count = 0;
        foreach($allModules as $item){
            $array = explode("_",$item["name"]);
            if($array[0] != "Magento"){
                $count++;
            }
            //echo $item["name"]."<br>";
        }
        return $count;
    }
}