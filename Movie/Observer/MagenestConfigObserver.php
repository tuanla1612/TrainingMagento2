<?php
namespace Magenest\Movie\Observer;

use Magento\Framework\Event\ObserverInterface;
use \Psr\Log\LoggerInterface;
use \Magento\Framework\Event\Observer;
use Magento\Framework\App\Config\Storage\WriterInterface;
use \Magento\Framework\App\Config\ScopeConfigInterface;
use \Magento\Framework\App\Cache\TypeListInterface;

class MagenestConfigObserver implements ObserverInterface
{
    /** @var \Psr\Log\LoggerInterface $logger */
    protected $logger;

    public function __construct(
        LoggerInterface $logger,
        ScopeConfigInterface $scopeConfig,
        WriterInterface $configWriter,
        TypeListInterface $cacheTypeList
    ){
        $this->logger = $logger;
        $this->_scopeConfig = $scopeConfig;
        $this->configWriter = $configWriter;
        $this->_cacheTypeList = $cacheTypeList;
    }
    public function execute(Observer $observer)
    {
        $textField = $observer->getEvent()->getData('changed_paths');
        if(isset($textField["0"])){
            $value = $this->_scopeConfig->getValue($textField["0"]);
            if($value == "Ping"){
                $value = "Pong";
            }
            $this->configWriter->delete($textField["0"]);
            $this->configWriter->save($textField["0"], $value);
            // $types = array('config','layout','block_html','collections','reflection','db_ddl','eav','config_integration','config_integration_api','full_page','translate','config_webservice');
            // foreach ($types as $type) {
            //     $this->_cacheTypeList->cleanType($type);
            // }
        }
        
        return $this;
    }
}