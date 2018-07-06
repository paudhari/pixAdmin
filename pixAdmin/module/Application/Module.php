<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Application\Model\UsersTable;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $eventManager->attach('render', array($this, 'setLayoutTitle'));
    }

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
    
      public function setLayoutTitle($e)
    {
//        $matches    = $e->getRouteMatch();
//        $routeName = $matches->getMatchedRouteName();
//        $action     = $matches->getParam('action');
//        $controller = $matches->getParam('controller');
//        $module     = __NAMESPACE__;
        $siteName   = 'PrizPix Admin';

        // Getting the view helper manager from the application service manager
        $viewHelperManager = $e->getApplication()->getServiceManager()->get('viewHelperManager');
        
        // Getting the headTitle helper from the view helper manager
        $headTitleHelper = $viewHelperManager->get('headTitle');
//        echo "<pre>"; print_r($headTitleHelper);die;
        // Setting a separator string for segments
//        $headTitleHelper->setSeparator(' | ');

        // Setting the action, controller, module and site name as title segments
//        $headTitleHelper->append($action);
//        $headTitleHelper->append($controller);
//        $headTitleHelper->append($module);
//        if($routeName == 'adviseMe' || $routeName == 'topList' || $routeName == 'map' || $routeName == 'home')
//        {
            $headTitleHelper->set($siteName);
//        }
//        elseif($routeName == 'club')
//        {
//            $club = $matches->getParam('clubname');
//            $club = explode('_', $club);
//            $club = implode(' ', $club);
//            $headTitleHelper->set($club);
////            $headTitleHelper->append($siteName);
//        }
//        elseif($routeName == 'events')
//        {
//            $event  = $matches->getParam('eventname');
//            $event = explode('_', $event);
//            $event = implode(' ', $event);
//            $headTitleHelper->set($event);
////            $headTitleHelper->append($siteName);
//        }
//        elseif($routeName == 'dj')
//        {
//            $dj = $matches->getParam('djname');
//            $dj = explode('_', $dj);
//            $dj = implode(' ', $dj);
//            $headTitleHelper->set($dj);
////            $headTitleHelper->append($siteName);
//        }
    }

    
    
    
}
