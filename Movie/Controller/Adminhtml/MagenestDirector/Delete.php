<?php

namespace Magenest\Movie\Controller\Adminhtml\MagenestDirector;

use Magento\Backend\App\Action;
use Magenest\Movie\Model\ResourceModel\Director\CollectionFactory;
use Magenest\Movie\Model\DirectorFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Backend\Model\View\Result\RedirectFactory;

class Delete extends Action
{
    private $movieFactory;
    private $filter;
    private $collectionFactory;
    private $resultRedirect;

    public function __construct(
        Action\Context $context,
        DirectorFactory $directorFactory,
        Filter $filter,
        CollectionFactory $collectionFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->directorFactory = $directorFactory;
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->resultRedirect = $redirectFactory;
    }

    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
        } catch (\Exception $exception) {
            $this->_redirect('movie/magenestdirector/index');
        }
        
        $total = 0;
        $err = 0;
        foreach ($collection->getItems() as $item) {
            $deleteDirector = $this->directorFactory->create();
            $deleteDirector->load($item->getData('director_id'));
            try {
                $deleteDirector->delete();
                $total++;
            } catch (\Exception $exception) {
                $err++;
            }
        }

        if ($total) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $total)
            );
        }

        if ($err) {
            $this->messageManager->addErrorMessage(
                __(
                    'A total of %1 record(s) haven\'t been deleted. Please see server logs for more details.',
                    $err
                )
            );
        }
        return $this->resultRedirect->create()->setPath('movie/magenestdirector/index');
    }
}