<?php 
namespace Magenest\Blog\Model\ResourceModel\Blog;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Magenest\Blog\Model\Blog', 'Magenest\Blog\Model\ResourceModel\Blog');
	}

	public function joinBlogWithAuthor(){
        $authorTable = $this->getTable('admin_user');
        $result = $this
        ->addFieldToSelect('title')
        ->addFieldToSelect('description')
        ->addFieldToSelect('content')
		->addFieldToSelect('url_rewrite')
        ->addFieldToSelect('status')
        ->addFieldToSelect('create_at')
        ->addFieldToSelect('update_at')
        ->addFieldToSelect('author_id')
        ->join($authorTable,
        'main_table.author_id='.$authorTable.'.user_id',
        ['firstname' => 'firstname', 'lastname' => 'lastname', 'email' => 'email']);
        return $result->getSelect();
    }

    public function joinBlogWithAuthorById($id){
        $authorTable = $this->getTable('admin_user');
        $result = $this
        ->addFieldToSelect('title')
        ->addFieldToSelect('description')
        ->addFieldToSelect('content')
		->addFieldToSelect('url_rewrite')
        ->addFieldToSelect('status')
        ->addFieldToSelect('create_at')
        ->addFieldToSelect('update_at')
        ->addFieldToSelect('author_id')
        ->addFieldToFilter('blog_id', $id)
        ->join($authorTable,
        'main_table.author_id='.$authorTable.'.user_id',
        ['firstname' => 'firstname', 'lastname' => 'lastname', 'email' => 'email']);
        return $result->getSelect();
    }
}