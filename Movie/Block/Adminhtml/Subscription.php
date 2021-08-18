<?php
namespace Magenest\Movie\Block\Adminhtml;
class Subscription extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'Magenest_Movie';
        $this->_controller = 'adminhtml_subscription';
        parent::_construct();
    }
}