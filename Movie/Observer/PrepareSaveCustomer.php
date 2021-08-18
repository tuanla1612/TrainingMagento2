<?php
namespace Magenest\Movie\Observer;

use Magento\Framework\Event\ObserverInterface;
use \Psr\Log\LoggerInterface;
use \Magento\Framework\Event\Observer;
use \Magento\Framework\App\RequestInterface;

use function PHPUnit\Framework\isEmpty;

class PrepareSaveCustomer implements ObserverInterface
{
    /** @var \Psr\Log\LoggerInterface $logger */
    protected $logger;
    protected $request;

    public function __construct(LoggerInterface $logger,RequestInterface $request)
    {
        $this->logger = $logger;
        $this->request = $request;
    }

    
    public function execute(Observer $observer)
    {
        $param = $this->request->getParams();
        if(isset($param['phone_number'])){
            $phone = $this->checkPhone($param['phone_number']);
            $data = $observer->getData('customer');
            $data->setData('phone_number',$phone);
            $observer->setData('customer',$data);
        }else if(isset($param['telephone'])){
            $phone = $this->checkPhone($param['telephone']);
            $param['telephone'] = $phone;
            $data = $observer->getData('customer_address');
            $data->setData('phone_number',$phone);
            $observer->setData('customer_address',$data);
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