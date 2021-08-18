<?php
namespace Magenest\Movie\Model\Source;

use Magenest\Movie\Model\ResourceModel\Director\CollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;
 
class Director implements OptionSourceInterface
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
 
    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }
 
    public function toOptionArray()
    {
        $options[] = ['label' => '-- Please Select --', 'value' => ''];
        $collection = $this->collectionFactory->create();
 
        foreach ($collection as $category) {
            $options[] = [
                'label' => $category->getName(),
                'value' => $category->getId(),
            ];
        }
 
        return $options;
    }
}