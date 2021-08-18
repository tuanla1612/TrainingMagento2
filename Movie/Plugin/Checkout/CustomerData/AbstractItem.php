<?php
namespace Magenest\Movie\Plugin\Checkout\CustomerData;

use Magento\Checkout\Model\Session;
use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Helper\Product;

class AbstractItem
{
    protected $product;
    protected $productRepository;
    /**
     * AbstractItem constructor.
     *
     * @param Session $session
     */

    
    public function __construct(
        Session $session,
        ProductRepository $productRepository,
        Product $product
    ) {
        $this->session = $session;
        $this->productRepository = $productRepository;
        $this->product = $product;
    }

    /**
     * Add Your Custom Attribute to frontend storage (CustomerData)
     *
     * @param $subject
     * @param $item
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function aroundGetItemData($subject, $proceed, $item)
    {
        $result = $proceed($item);
        if(isset($result["product_type"]) && $result["product_type"] == "configurable"){
            $result["product_name"] = $result["product_sku"];

            $product = $this->productRepository->get($result["product_sku"]);                        

            $url = $this->product->getThumbnailUrl($product);
            $result["product_image"]["src"] = $url;
        }

        return $result;
    }
}