<?php
namespace Magenest\Movie\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use \Magento\Customer\Model\ResourceModel\Group\Collection;
 
class CustomerGroup implements OptionSourceInterface
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
 
    public function __construct(
        Collection $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }
 
    public function toOptionArray()
    {
        $options[] = ['label' => '-- Please Select --', 'value' => ''];
        $collection = $this->collectionFactory->toOptionArray();
 
        // foreach ($collection as $customerGroup) {
        //     $options[] = [
        //         'label' => $customerGroup->getName(),
        //         'value' => $customerGroup->getId(),
        //     ];
        // }
 
        return $collection;
    }
}