<?php
namespace Magenest\Movie\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class VnRegion extends AbstractSource
{
    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        if (null === $this->_options) {
            $this->_options=[
                                ['label' => __('Mien Bac'), 'value' => 1],
                                ['label' => __('Mien Trung'), 'value' => 0],
                                ['label' => __('Mien Nam'), 'value' => 2]
                            ];
        }
        return $this->_options;
    }
}