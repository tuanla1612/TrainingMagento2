<?php
namespace Magenest\Movie\Block;
use Magento\Framework\View\Element\Template;
class FrontendExercies extends Template
{
    private $_procutCollectFactory;

    public function __construct(
        Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory 
    $productCollectionFactory,
        array $data=[]
    ){
        parent::__construct($context,$data);

        $this->_procutCollectFactory = $productCollectionFactory;
    }

    public function getProducts(){
        $collection = $this->_procutCollectFactory->create();

        $collection->addAttributeToSelect('*')->setOrder('created_at')->setPageSize(5);

        return $collection;
    }
}