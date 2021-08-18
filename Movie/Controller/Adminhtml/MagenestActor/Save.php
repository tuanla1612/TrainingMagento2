<?php

namespace Magenest\Movie\Controller\Adminhtml\MagenestActor;

use Magento\Framework\GraphQl\Exception;
use Magento\Backend\App\Action;
use Magenest\Movie\Model\ActorFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;

class Save extends Action
{
    private $resultRedirect;
    private $actorFactory;

    public function __construct(
        Action\Context $context,
        ActorFactory $actorFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->actorFactory = $actorFactory;
        $this->resultRedirect = $redirectFactory;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data["actor_id"]) ? $data["actor_id"] : null;

        if(!isset($data["name"])){
            $this->_redirect('movie/magenestactor/index');
        }

        $newData = [
            'name' => $data['name'],
        ];

        $actor = $this->actorFactory->create();
        if($id){
            $actor->load($id);
        }

        try {
            $actor->addData($newData);
            $actor->save();
            return $this->resultRedirect->create()->setPath('movie/magenestactor/index');
        } catch (\Exception $e) {
            return $this->resultRedirect->create()->setPath('movie/magenestactor/add');
        }
        
    }
}