<?php

namespace Album\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Album\Model\AlbumTable;
use Zend\EventManager\EventManagerInterface;
use PhlyRestfully\ResourceEvent;
use PhlyRestfully\Exception\DomainException;
use Album\Model\Album;
use PhlyRestfully\Exception\CreationException;


class AlbumResourceListener extends AbstractListenerAggregate
{

    protected $persistence;


    public function __construct(AlbumTable $persistence)
    {
        $this->persistence = $persistence;
    }


    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach('create', array(
            $this,
            'onCreate'
        ));
        
        $this->listeners[] = $events->attach('update', array(
            $this,
            'onUpdate'
        ));
        
        $this->listeners[] = $events->attach('fetch', array(
            $this,
            'onFetch'
        ));
        
        $this->listeners[] = $events->attach('fetchAll', array(
            $this,
            'onFetchAll'
        ));
        
        $this->listeners[] = $events->attach('delete', array(
            $this,
            'onDelete'
        ));
    }


    public function onCreate(ResourceEvent $e)
    {
        $data = $e->getParam('data');
        
        $album = new Album();
        $album->artist = $data->artist;
        $album->title = $data->title;
        
        $album = $this->persistence->saveAlbum($album);
        if (! $album) {
            throw new CreationException();
        }
        return $album;
    }


    public function onUpdate(ResourceEvent $e)
    {
        $id = $e->getParam('id');
        $data = $e->getParam('data');
        
        $album = new Album();
        $album->id = $id;
        $album->artist = $data->artist;
        $album->title = $data->title;

        $album = $this->persistence->saveAlbum($album);
        return $album;
    }


    public function onFetch(ResourceEvent $e)
    {
        $id = $e->getParam('id');
        $album = $this->persistence->getAlbum($id);
        if (! $album) {
            throw new DomainException('Album not found', 404);
        }
        return $album;
    }


    public function onFetchAll(ResourceEvent $e)
    {
        return $this->persistence->fetchAll();
    }


    public function onDelete(ResourceEvent $e)
    {
        $id = $e->getParam('id');
        $this->persistence->deleteAlbum($id);
        return true;
    }
}