<?php

namespace Magenest\Movie\Controller\Adminhtml\MagenestDirector;

use Magento\Backend\App\Action;
use Magenest\Movie\Model\DirectorFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;

class Save extends Action
{
    private $resultRedirect;
    private $movieFactory;

    public function __construct(
        Action\Context $context,
        DirectorFactory $directorFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->directorFactory = $directorFactory;
        $this->resultRedirect = $redirectFactory;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data["director_id"]) ? $data["director_id"] : null;

        if(!isset($data["name"])){
            $this->_redirect('movie/magenestdirector/index');
        }

        $newData = [
            'name' => $data['name'],
        ];

        $director = $this->directorFactory->create();
        if($id){
            $director->load($id);
        }
        
        try {
            $director->addData($newData);
            $director->save();
            return $this->resultRedirect->create()->setPath('movie/magenestdirector/index');
        } catch (\Exception $e) {
            return $this->resultRedirect->create()->setPath('movie/magenestdirector/add');
        }
    }
}