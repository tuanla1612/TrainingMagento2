<?php 
namespace Magenest\Movie\Model\ResourceModel\Movie;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Magenest\Movie\Model\Movie', 'Magenest\Movie\Model\ResourceModel\Movie');
	}

	public function joinMovie(){
        $actorTable = $this->getTable('magenest_actor');
        $actormovieTable = $this->getTable('magenest_movie_actor');
        $directorTable = $this->getTable('magenest_director');
        $result = $this
        ->addFieldToSelect('name','movie')
        ->addFieldToSelect('description')
        ->addFieldToSelect('rating')
		->addFieldToSelect('movie_id','id')
        ->join($directorTable, 
        'main_table.director_id='.$directorTable.'.director_id',
        ['director' => 'name'])
        ->join($actormovieTable,
        'main_table.movie_id='.$actormovieTable.'.movie_id',
        null)
        ->join($actorTable,
        $actorTable.'.actor_id='.$actormovieTable.'.actor_id',
        ['actor' => 'name']);
        return $result->getSelect();
    }
}