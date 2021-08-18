<?php
namespace Magenest\Blog\Block;
use Magento\Framework\View\Element\Template;
class BlogLanding extends Template
{
    private $_blogCollectFactory;
    private $_blogCollection;

    public function __construct(
        Template\Context $context,
        \Magenest\Blog\Model\ResourceModel\Blog\CollectionFactory
    $blogCollectFactory,
        \Magenest\Blog\Model\ResourceModel\Blog\Collection
    $blogCollection,
        array $data=[]
    ){
        parent::__construct($context,$data);

        $this->_blogCollectFactory = $blogCollectFactory;
        $this->_blogCollection = $blogCollection;
    }

    public function getBlogWithAuthor(){
        $blog = $this->_blogCollectFactory->create();
        // echo $blog->joinBlogWithAuthor();
        // die();
        $blog->joinBlogWithAuthor();
        return $blog;
    }
}