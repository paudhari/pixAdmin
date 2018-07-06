<?php
namespace Users;

use Application\Model\UsersTable;
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
                'Application\Model\UsersTable' => function ($serviceManager)
                {
                    $dbAdapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
                    $table = new UsersTable($dbAdapter);
                    return $table;
                }
            )
        );
    }
}
