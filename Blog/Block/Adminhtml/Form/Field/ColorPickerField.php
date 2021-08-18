<?php
namespace Magenest\Blog\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Magenest\Blog\Block\Adminhtml\Form\Field\ColorCodeColumn;
use Magento\Ui\Component\Form\Element\ColorPicker;

/**
 * Class ColorPickerField
 */
class ColorPickerField extends AbstractFieldArray
{
    /**
     * @var ColorCodeColumn
     */
    private $colorCodeRenderer;

    //Override
    public function addColumn($name, $params)
    {
        $this->_columns[$name] = [
            'label' => $this->_getParam($params, 'label', 'Column'),
            'size' => $this->_getParam($params, 'size', false),
            'style' => $this->_getParam($params, 'style'),
            'class' => $this->_getParam($params, 'class'),
            'renderer' => false,
        ];
        if (!empty($params['renderer'])
            && $params['renderer'] instanceof \Magento\Framework\View\Element\AbstractBlock
        ) {
            $this->_columns[$name]['renderer'] = $params['renderer'];
            if(isset($params['class'])){
                $this->_columns[$name]['class'] = $params['class'];
            }
        }
    }

    /**
     * Prepare rendering the new field by adding all the needed columns
     */
    protected function _prepareToRender()
    {
        $this->addColumn('color', ['label' => __('Color'), 'class' => 'required-entry']);
        $this->addColumn('color_code', [
            'label' => __('Color code'),
            'class' => 'required-entry',
            'renderer' => $this->getColorCodeRenderer(),
        ]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    // /**
    //  * Prepare existing row data object
    //  *
    //  * @param DataObject $row
    //  * @throws LocalizedException
    //  */
    // protected function _prepareArrayRow(DataObject $row): void
    // {
        
    // }

    /**
     * @return ColorCodeColumn
     * @throws LocalizedException
     */
    private function getColorCodeRenderer()
    {
        if (!$this->colorCodeRenderer) {
            $this->colorCodeRenderer = $this->getLayout()->createBlock(
                ColorCodeColumn::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->colorCodeRenderer;
    }
}
