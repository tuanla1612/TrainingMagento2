<?php
namespace Magenest\Movie\Observer;
use Magento\Framework\Event\ObserverInterface;
use \Psr\Log\LoggerInterface;
use \Magento\Framework\App\RequestInterface;
use \Magento\Catalog\Model\ProductFactory;
use \Magento\Framework\Event\Observer;
use \Magento\Catalog\Api\CategoryLinkManagementInterface;

class AfterProductSave implements ObserverInterface
{
    protected $request;
    protected $logger;
    protected $productFactory;
    protected $categoryLinkManagementInterface;

    public function __construct(
        LoggerInterface $logger,
        RequestInterface $request,
        ProductFactory $productFactory,
        CategoryLinkManagementInterface $categoryLinkManagementInterface
    )
    {
        $this->productFactory = $productFactory;
        $this->request = $request;
        $this->logger = $logger;
        $this->categoryLinkManagementInterface = $categoryLinkManagementInterface;
    }

    public function execute(Observer $observer)
    {
        $data = $this->request->getParams();
        $id = $data['id'];
        $product = $this->productFactory->create()->load($id);
        $categoryId = [42];
        $categoryIds = array_unique(
            array_merge(
                $product->getCategoryIds(),
                $categoryId
            )
        );
        $this->categoryLinkManagementInterface->assignProductToCategories(
            $product->getSku(),
            $categoryIds
        );
    }
    
}
