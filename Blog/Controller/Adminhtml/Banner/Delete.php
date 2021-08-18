<?php

namespace Magenest\Blog\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magenest\Blog\Model\ResourceModel\Blog\CollectionFactory;
use Magenest\Blog\Model\BlogFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Backend\Model\View\Result\RedirectFactory;

class Delete extends Action
{
    private $blogFactory;
    private $filter;
    private $collectionFactory;
    private $resultRedirect;

    public function __construct(
        Action\Context $context,
        BlogFactory $blogFactory,
        Filter $filter,
        CollectionFactory $collectionFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->blogFactory = $blogFactory;
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->resultRedirect = $redirectFactory;
    }

    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
        } catch (\Exception $exception) {
            $this->_redirect('blog/blog/index');
        }

        $total = 0;
        $err = 0;
        foreach ($collection->getItems() as $item) {
            $deleteMovie = $this->blogFactory->create();
            $deleteMovie->load($item->getData('blog_id'));
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
        return $this->resultRedirect->create()->setPath('blog/blog/index');
    }
}