<?php 
return array(
    'controllers' => array(
        'invokables' => array(
            'Subscription\Controller\Subscription' => 'Subscription\Controller\SubscriptionController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'subscription' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/subscription[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Subscription\Controller\Subscription',
                        'action' => 'index',
                    ),
                ),
            ),
            
            

        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'Subscription' => __DIR__ . '/../view',
        ),
    ),
);
?>
