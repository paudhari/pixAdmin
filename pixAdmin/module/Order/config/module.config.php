<?php 
return array(
    'controllers' => array(
        'invokables' => array(
            'Order\Controller\Order' => 'Order\Controller\OrderController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'order' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/order[/:action][/:id][/:type]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Order\Controller\Order',
                        'action' => 'index',
                    ),
                ),
            ),
            
            

        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'order' => __DIR__ . '/../view',
        ),
    ),
);
?>
