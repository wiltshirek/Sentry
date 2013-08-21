<?php
namespace Pass;

return array(
    'controllers' => array(
        'invokables' => array(
            'Pass\Controller\Pass' => 'Pass\Controller\PassController',
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'pass' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/pass[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Pass\Controller\Pass',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'pass' => __DIR__ . '/../view',
        ),
    ),
    
    'view_helpers' => array(
    		'invokables' => array(
    				'passViewHelper' => 'Pass\view\helper\Pass_View_Helper',
    				
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