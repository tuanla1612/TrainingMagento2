<?php

namespace Magenest\Blog\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magenest\Blog\Model\BannerFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\Serialize\Serializer\Json;


class Save extends Action
{
    private $resultRedirect;
    private $bannerFactory;
    private $serialize;
    public function __construct(
        Action\Context $context,
        Json $serialize,
        BannerFactory $bannerFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->bannerFactory = $bannerFactory;
        $this->serialize = $serialize;
        $this->resultRedirect = $redirectFactory;
    }

    public function execute()
    {

        $data = $this->getRequest()->getPostValue();
        // var_dump($data);
        // die();
        if(!$data){
            $this->getMessageManager()->addErrorMessage(__('Fail'));
            $this->_redirect('blog/banner');
        }
        if (isset($data['images'])) {
            $data['images'] = $this->serialize->serialize($data['images']);
            //$model->setData($data);
        }
        $newData = [
            'name' => $data['name'],
            'title' => $data['title'],
            'link' => $data['link'],
            'add_text' => $data['add_text'],
            'images' => $data['images']


        ];
        $banner = $this->bannerFactory->create();

        if($banner){
            $banner->setData($newData);

            if (isset($data['id'])) {
                $banner->setId($data['id']);
                try{
                    $banner->save();
                    $this->getMessageManager()->addSuccessMessage(__('Save banner successfully'));
                    return $this->resultRedirectFactory->create()->setPath('blog/banner/index');
                }catch(\Exception $e){
                    $this->getMessageManager()->addErrorMessage(__('Save banner failed.'));
                    return $this->resultRedirect->create()->setPath('blog/banner/index');
                }
            }
            else{
                try{
                    $banner->addData($newData);
                    $banner->save();
                    $this->getMessageManager()->addSuccessMessage(__('Save banner successfully'));
                    return $this->resultRedirect->create()->setPath('blog/banner/index');
                }catch (\Exception $e){
                    $this->getMessageManager()->addErrorMessage(__('Save banner failed.'));
                    return $this->resultRedirect->create()->setPath('blog/banner/index');
                }
            }


        }


    }
}