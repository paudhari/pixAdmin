<?php 
return array(
    'controllers' => array(
        'invokables' => array(
            'Users\Controller\Index' => 'Users\Controller\IndexController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'users' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/users[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            
            

        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'users' => __DIR__ . '/../view',
        ),
    ),
);
?>