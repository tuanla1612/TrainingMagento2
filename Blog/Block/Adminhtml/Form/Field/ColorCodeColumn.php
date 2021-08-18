<?php
namespace Magenest\Blog\Block\Adminhtml\Form\Field;

use \Magento\Config\Block\System\Config\Form\Field;
use \Magento\Framework\Data\Form\Element\AbstractElement;
use \Magento\Backend\Block\Template\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;

class ColorCodeColumn extends Field
{
    protected $_template = 'Magenest_Blog::color_picker_field.phtml';

    protected $scopeConfig;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        array $data = []
        ) {
            $this->scopeConfig = $scopeConfig;
            parent::__construct($context, $data);
        }
    
    public function render(AbstractElement $element){
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    public function getElementId(AbstractElement $element){
        return $this->getLayout()->getParentName('groups[color_picker][fields][background_color][value][][color_code]');
    }

    public function getColor(){
        return $this->scopeConfig->getValue('color_picker_section/color_picker/background_color', 
        \Magento\Store\Model\ScopeInterface::SCOPE_STORE);    
    }
}