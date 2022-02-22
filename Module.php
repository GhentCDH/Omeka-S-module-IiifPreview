<?php declare(strict_types=1);

namespace IiifPreview;

if (!class_exists(\Generic\AbstractModule::class)) {
    require file_exists(dirname(__DIR__) . '/Generic/AbstractModule.php')
        ? dirname(__DIR__) . '/Generic/AbstractModule.php'
        : __DIR__ . '/src/Generic/AbstractModule.php';
}

use Generic\AbstractModule;
use Laminas\EventManager\Event;
use Laminas\EventManager\SharedEventManagerInterface;
use Laminas\View\Renderer\RendererInterface;

class Module extends AbstractModule
{
    const NAMESPACE = __NAMESPACE__;

    protected $dependencies = ['IiifServer'];

    public function attachListeners(SharedEventManagerInterface $sharedEventManager): void
    {
        $sharedEventManager->attach(
            'Omeka\Controller\Admin\Item',
            'view.show.after',
            [$this, 'handleViewShowAfterItem']
        );

        $sharedEventManager->attach(
            'Omeka\Controller\Admin\ItemSet',
            'view.show.after',
            [$this, 'handleViewShowAfterItemSet']
        );

        // register css/js
        $sharedEventManager->attach(
            'Omeka\Controller\Admin\Item',
            'view.layout',
            array($this, 'adminAssets')
        );
        $sharedEventManager->attach(
            'Omeka\Controller\Admin\ItemSet',
            'view.layout',
            array($this, 'adminAssets')
        );
        $sharedEventManager->attach(
            'Omeka\Controller\Admin\Media',
            'view.layout',
            array($this, 'adminAssets')
        );
    }

    public function adminAssets(Event $e)
    {
        $view = $e->getTarget();
        if ($view instanceof RendererInterface) {
            $view->headLink()->appendStylesheet($view->assetUrl('css/style.css', 'IiifPreview'));
        }
    }

    public function handleViewShowAfterItem(Event $event): void
    {
        $view = $event->getTarget();
        echo $view->IiifPreview($view->item);
    }

    public function handleViewShowAfterItemSet(Event $event): void
    {
        $view = $event->getTarget();
        echo $view->IiifPreview($view->itemSet);
    }

}
