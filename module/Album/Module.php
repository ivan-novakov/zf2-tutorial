<?php

namespace Album;

use Album\Model\AlbumTable;
use Album\Listener\AlbumResourceListener;


class Module
{


    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php'
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }


    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Album\Model\AlbumTable' => function ($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new AlbumTable($dbAdapter);
                    return $table;
                },
                'Album\Listener\AlbumResourceListener' => function ($sm)
                {
                    $persistence = $sm->get('Album\Model\AlbumTable');
                    $listener = new AlbumResourceListener($persistence);
                    return $listener;
                }
            )
        );
    }


    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}