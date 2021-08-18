<?php 
namespace Magenest\Blog\Model;
class Blog extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{ 
    const CACHE_TAG = 'magenest_blog';

    protected function _construct()
    {
        $this->_init('Magenest\Blog\Model\ResourceModel\Blog');
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