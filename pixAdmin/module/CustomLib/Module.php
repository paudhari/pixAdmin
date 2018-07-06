<?php
namespace CustomLib;

use CustomLib\Service\FlashMessage;
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
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }
    
    /**
     * Get view helper configurations
     *
     * @return array
     */
    public function getViewHelperConfig() {
        return array (
            'factories' => array (
                'flashMessage' => function ($serviceManager) {
                    $locator = $serviceManager->getServiceLocator ();
                    $flashmessenger = $serviceManager->getServiceLocator ()
                    ->get ( 'ControllerPluginManager' )->get ( 'flashmessenger' );
                    $message = new FlashMessage($locator->get('Request'));
                    $message->setFlashMessenger ( $flashmessenger );
                    return $message;
                }
            ),
        );
    }
}
