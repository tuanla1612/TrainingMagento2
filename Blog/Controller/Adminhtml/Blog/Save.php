<?php

namespace Magenest\Blog\Controller\Adminhtml\Blog;

use Magento\Framework\GraphQl\Exception;
use Magento\Backend\App\Action;
use Magenest\Blog\Model\BlogFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;
use \Magento\UrlRewrite\Model\UrlRewriteFactory;
use Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollectionFactory;
use \Magento\Framework\UrlInterface;

class Save extends Action
{
    private $resultRedirect;
    private $blogFactory;
    private $urlRewriteFactory;
    private $urlInterface;
    private $urlRewriteCollectionFactory;

    public function __construct(
        Action\Context $context,
        BlogFactory $blogFactory,
        RedirectFactory $redirectFactory,
        UrlRewriteFactory $urlRewriteFactory,
        UrlInterface $urlInterface,
        UrlRewriteCollectionFactory $urlRewriteCollectionFactory
    )
    {
        parent::__construct($context);
        $this->blogFactory = $blogFactory;
        $this->resultRedirect = $redirectFactory;
        $this->urlRewriteFactory = $urlRewriteFactory;
        $this->urlInterface = $urlInterface;
        $this->urlRewriteCollectionFactory = $urlRewriteCollectionFactory;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data["blog_id"]) ? $data["blog_id"] : null;

        if(!isset($data["title"])){
            $this->_redirect('blog/blog/index');
        }

        $newData = [
            'title' => $data["title"],
            'content' => $data["content"],
            'description' => $data["description"],
            'url_rewrite' => $data["url_rewrite"],
            'status' => $data["status"],
            'author_id' => $data["author_id"]
        ];

        $blog = $this->blogFactory->create();
        if($id){
            $blog->load($id);
            $url_rewrite = $blog->getData('url_rewrite');
        }
        
        try {
            $blog->addData($newData);
            if(!isset($url_rewrite) || $url_rewrite == ""){
                $blog->save();
                if(!isset($data["url_rewrite"]) || $data["url_rewrite"] == ""){
                    $this->messageManager->addSuccess(__('Save blog with new url_rewrite.'));
                }else{
                    $tmp = $this->urlRewriteCollectionFactory->create()->getColumnValues('request_path');

                    if(!in_array($data["url_rewrite"],$tmp, true)){
                        $urlRewriteModel = $this->urlRewriteFactory->create();
                        /* set current store id */
                        $urlRewriteModel->setStoreId(1);
                        /* this url is not created by system so set as 0 */
                        $urlRewriteModel->setIsSystem(0);
                        /* unique identifier - set random unique value to id path */
                        $urlRewriteModel->setIdPath(rand(1, 100000));
                        /* set actual url path to target path field */
                        if($id){
                            $target = "/blog/view/id/".$id;
                        }else{
                            $new_id = $blog->getId();
                            $target = "/blog/view/id/".$new_id;
                        }   
                        $urlRewriteModel->setTargetPath($target);
                        /* set requested path which you want to create */
                        $urlRewriteModel->setRequestPath($data["url_rewrite"]);
                        /* set current store id */
                        $urlRewriteModel->save();
                        $this->messageManager->addSuccess(__('Save blog and new url_rewrite rule.'));
                    }else{
                        $this->messageManager->addSuccess(__('Save blog but no url_rewrite rule created.'));
                    }   
                }        
            }else{
                $this->messageManager->addError(__('Already exist blog url_rewrite.'));
            }
            return $this->resultRedirect->create()->setPath('blog/blog/index');
        } catch (\Exception $e) {
            return $this->resultRedirect->create()->setPath('blog/blog/add');
        }
    }
}