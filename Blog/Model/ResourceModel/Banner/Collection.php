<?php 
namespace Magenest\Blog\Model\ResourceModel\Banner;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Magenest\Blog\Model\Banner', 'Magenest\Blog\Model\ResourceModel\Banner');
	}

}