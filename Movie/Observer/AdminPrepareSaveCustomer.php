<?php
namespace Magenest\Movie\Observer;

use Magento\Framework\Event\ObserverInterface;
use \Psr\Log\LoggerInterface;
use \Magento\Framework\Event\Observer;

use function PHPUnit\Framework\isEmpty;

class AdminPrepareSaveCustomer implements ObserverInterface
{
    /** @var \Psr\Log\LoggerInterface $logger */
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        $data = $observer->getData('customer');
        if($data->getData('phone_number')){
            $phone = $data->getData('phone_number');
            $phone = $this->checkPhone($phone);
            $data = $data->setData('phone_number',$phone);
            $observer->setData('customer',$data);
        }else{
            $phone = $data->getCustomAttribute('phone_number')->getValue();
            $phone = $this->checkPhone($phone);
            $custom = $data->getCustomAttribute('phone_number')->setData('value',$phone);
            $data->setData('custom_attributes',$custom);
            $observer->setData($data);
        }
    }

    protected function checkPhone($phone){
        if(strlen($phone) >10 || $phone == ""){
            $phone="000000000";
        }else{
            $tmp = substr($phone,0,1);
            if($tmp != "0"){
                $tmp = substr($phone,0,3);
                if($tmp != "+84"){
                    $phone="000000000";
                }else{
                    $phone = substr_replace($phone,"0",0,3);
                }
            }
        }
        return $phone;
    }
}