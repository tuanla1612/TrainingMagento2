<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\Movie\Block\Account;

use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Model\CustomerFactory;

/**
 * Dashboard Customer Info
 *
 * @api
 * @since 100.0.2
 */
class EditExtraField extends Template
{
    /**
     * @var CurrentCustomer
     */
    protected $currentCustomer;

    protected $customerFactory;

    /**
     * Constructor
     *
     * @param Context $context
     * @param CurrentCustomer $currentCustomer
     * @param SubscriberFactory $subscriberFactory
     * @param View $helperView
     * @param array $data
     */
    public function __construct(
        Context $context,
        CurrentCustomer $currentCustomer,
        CustomerFactory $customerFactory,
        array $data = []
    ) {
        $this->currentCustomer = $currentCustomer;
        $this->customerFactory = $customerFactory;
        parent::__construct($context, $data);
    }

    public function getCustomer()
    {
        try {
            return $this->currentCustomer->getCustomer();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    public function getPhoneNumber()
    {
        $id = $this->getCustomer()->getId();
        $customer = $this->customerFactory->create()->load($id);
        $value = $customer->getData('phone_number');
        return $value;
    }

    /**
     * @inheritdoc
     */
    protected function _toHtml()
    {
        return $this->currentCustomer->getCustomerId() ? parent::_toHtml() : '';
    }

    
}
