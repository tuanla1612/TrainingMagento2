<?php

namespace Magenest\Movie\Controller\Adminhtml\MagenestMovie;

use Magento\Backend\App\Action;
use Magenest\Movie\Model\ResourceModel\Movie\CollectionFactory;
use Magenest\Movie\Model\MovieFactory;
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
        MovieFactory $movieFactory,
        Filter $filter,
        CollectionFactory $collectionFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->movieFactory = $movieFactory;
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->resultRedirect = $redirectFactory;
    }

    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
        } catch (\Exception $exception) {
            $this->_redirect('movie/magenestmovie/index');
        }

        $total = 0;
        $err = 0;
        foreach ($collection->getItems() as $item) {
            $deleteMovie = $this->movieFactory->create();
            $deleteMovie->load($item->getData('movie_id'));
            try {
                $deleteMovie->delete();
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
        return $this->resultRedirect->create()->setPath('movie/magenestmovie/index');
    }
}