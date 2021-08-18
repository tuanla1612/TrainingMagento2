<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\Movie\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;
use Magento\Backend\Model\View\Result\RedirectFactory;

/**
 * Class ProductActions for Listing Columns
 *
 * @api
 * @since 100.0.2
 */
class OddEven extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;
    protected $redirectFactory;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        RedirectFactory $redirectFactory,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->redirectFactory = $redirectFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $html = "<div>";
                try {
                    if(($item[$this->getData('name')]%2) != 1){
                        $html .= "<button disabled class=\"grid-severity-notice\">Even</button>";
                    }else if(($item[$this->getData('name')]%2) == 1){
                        $html .= "<button disabled class=\"grid-severity-major\">Odd</button>";
                    }else{
                        $html .= "Error";
                    }
                } catch (\Exception $e) {
                    return $this->redirectFactory->create()->setPath('sales/order');
                }
                
                $item[$this->getData('name')] = $html;
            }
        }

        return $dataSource;
    }
}
