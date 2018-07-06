<?php
namespace Order;

use Order\Model\OrderTable;
use Order\Model\InmatesTable;
class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Order\Model\OrderTable' => function ($serviceManager)
                {
                    $dbAdapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
                    $table = new OrderTable($dbAdapter);
                    return $table;
                },
                'Order\Model\InmatesTable' => function ($serviceManager)
                {
                    $dbAdapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
                    $table = new InmatesTable($dbAdapter);
                    return $table;
                }
            )
        );
    }
}
