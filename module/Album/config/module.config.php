<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Album\Controller\Album' => 'Album\Controller\AlbumController'
        )
    ),
    
    'router' => array(
        'routes' => array(
            
            'album' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/album[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Album\Controller\Album',
                        'action' => 'index'
                    )
                )
            ),
            
            'rest-album' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/rest-album[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Album\Controller\RestAlbumController'
                    )
                )
            )
            
        )
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'album' => __DIR__ . '/../view'
        )
    ),
    
    'phlyrestfully' => array(
        
        'resources' => array(
            'Album\Controller\RestAlbumController' => array(
                'listener' => 'Album\Listener\AlbumResourceListener',
                'route_name' => 'rest-album'
            )
        )
    )
);