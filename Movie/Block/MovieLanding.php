<?php
namespace Magenest\Movie\Block;
use Magento\Framework\View\Element\Template;
class MovieLanding extends Template
{
    private $_movieCollectFactory;
    private $_movieCollection;

    public function __construct(
        Template\Context $context,
        \Magenest\Movie\Model\ResourceModel\Movie\CollectionFactory
    $movieCollectFactory,
        \Magenest\Movie\Model\ResourceModel\Movie\Collection
    $movieCollection,
        array $data=[]
    ){
        parent::__construct($context,$data);

        $this->_movieCollectFactory = $movieCollectFactory;
        $this->_movieCollection = $movieCollection;
    }

    public function getMovies(){
        $movie = $this->_movieCollectFactory->create();
        $movie->joinMovie();
        return $movie;
    }
}