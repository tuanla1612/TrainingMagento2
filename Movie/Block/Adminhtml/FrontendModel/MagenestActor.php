<?php

namespace Magenest\Movie\Block\Adminhtml\FrontendModel;

class MagenestActor extends \Magento\Config\Block\System\Config\Form\Field
{   
    private $_actorCollection;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magenest\Movie\Model\ResourceModel\Actor\Collection $actorCollection,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_actorCollection = $actorCollection;
    }

    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element) {
        $value = $this->_actorCollection->count();
        $element->setReadonly(true);
        $html = $element->getElementHtml();
        $html .= '<script type="text/javascript">
        require(["jquery"], function($) {
            $(document).ready(function(e) {
                $("#'.$element->getHtmlId().'").val('.$value.');
            });
        });
        </script>';
        return $html;
    }
}