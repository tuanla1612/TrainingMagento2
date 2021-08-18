<?php
namespace Magenest\Blog\Block;
use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Config\ScopeConfigInterface;
class ColorSelect extends Template
{
    protected $config;

    public function __construct(
        Template\Context $context,
        ScopeConfigInterface $config,
        array $data=[]
    ){
        parent::__construct($context,$data);
        $this->config = $config;
    }

    public function getColorOption(){
        return json_decode($this->config->getValue('color_picker_section/color_picker/background_color', 
        \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }
}