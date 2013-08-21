<?php
namespace Resident;

return array(
    'controllers' => array(
        'invokables' => array(
            'Resident\Controller\Resident' => 'Resident\Controller\ResidentController',
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'resident' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/resident[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Resident\Controller\Resident',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'resident' => __DIR__ . '/../view',
        ),
    ),
    
    'view_helpers' => array(
    		'invokables' => array(
    				'residentViewHelper' => 'Resident\view\helper\Resident_View_Helper',
    				
    		),
    ),
    


    // Doctrine config
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    )

);