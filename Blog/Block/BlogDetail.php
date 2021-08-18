<?php
namespace Magenest\Blog\Block;
use Magento\Framework\View\Element\Template;
class BlogDetail extends Template
{
    private $_blogCollectFactory;
    private $_blogCollection;
    private $_urlInterface;

    public function __construct(
        Template\Context $context,
        \Magenest\Blog\Model\ResourceModel\Blog\CollectionFactory
    $blogCollectFactory,
        \Magenest\Blog\Model\ResourceModel\Blog\Collection
    $blogCollection,
        \Magento\Framework\UrlInterface $urlInterface,
        array $data=[]
    ){
        parent::__construct($context,$data);

        $this->_blogCollectFactory = $blogCollectFactory;
        $this->_blogCollection = $blogCollection;
        $this->_urlInterface = $urlInterface;
    }

    public function getBlogWithAuthorById(){
        $blog = $this->_blogCollectFactory->create();
        $tmp = explode("/",$this->_urlInterface->getCurrentUrl());
        //print_r($tmp);
        // echo $blog->joinBlogWithAuthor();
        // die();
        $blog->joinBlogWithAuthorById($tmp[count($tmp) - 1]);
        return $blog;
    }
}