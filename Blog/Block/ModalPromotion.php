<?php
 
namespace Magenest\Blog\Block;
 
use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Cms\Api\Data\BlockInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
 
class ModalPromotion extends Template
{
    /**
     * @var BlockRepositoryInterface
     */
    private $blockRepository;
 
    /**
     * ModalOverlay constructor.
     *
     * @param BlockRepositoryInterface $blockRepository
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        BlockRepositoryInterface $blockRepository,
        Context $context,
        array $data = []
    ) {
        $this->blockRepository = $blockRepository;
 
        parent::__construct($context, $data);
    }
 
    /**
     * Retrieve modal overlay content
     *
     * @param $identifier
     * @return bool|string
     */
    public function getContent($identifier)
    {
        try {
            /** @var BlockInterface $block */
            $block = $this->blockRepository->getById($identifier);
            $content = $block->getContent();
        } catch (LocalizedException $e) {
            $content = false;
        }
 
        return $content;
    }
}