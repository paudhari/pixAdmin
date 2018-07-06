<?php
namespace Notes;

use Notes\Model\NotesTable;
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
                'Notes\Model\NotesTable' => function ($serviceManager)
                {
                    $dbAdapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
                    $table = new NotesTable($dbAdapter);
                    return $table;
                }
            )
        );
    }
}
