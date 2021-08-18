<?php 
namespace Magenest\Blog\Model;
class Banner extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{ 
    const CACHE_TAG = 'magenest_banner';

    protected function _construct()
    {
        $this->_init('Magenest\Blog\Model\ResourceModel\Banner');
    }

    public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}
}