<?php
namespace Magenest\Movie\Plugin\Catalog;
use Magento\Catalog\Model\Product;
class ProductAround
{
    public function afterGetName($interceptedInput)
    {
        return "Test";
    }
}