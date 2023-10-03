<?php

declare(strict_types=1);

namespace Application;

use Application\Command\DoctrineFixturesLoadCommand;
use Laminas\EventManager\EventInterface;
use Laminas\ModuleManager\ModuleManagerInterface;
use Laminas\Mvc\ModuleRouteListener;
use Laminas\Mvc\MvcEvent;

class Module
{
    public function init(ModuleManagerInterface $manager)
    {
        $events = $manager->getEventManager()->getSharedManager();

        // Attach to helper set event and load the entity manager helper.
        $events->attach('doctrine', 'loadCli.post', [$this, 'doctrineCommands']);
    }

    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;
    }

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->getSharedManager()->attach(__NAMESPACE__, 'dispatch', [$this, 'layout'], 100);

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function doctrineCommands(EventInterface $e)
    {
        /* @var $cli \Symfony\Component\Console\Application */

        $sm = $e->getParam('ServiceManager');
        $entityManager = $sm->get('doctrine.entitymanager.orm_default');

        $cli = $e->getTarget();
        $cli->add(new DoctrineFixturesLoadCommand($entityManager));
    }

    public function layout(MvcEvent $e)
    {
        $controller      = $e->getTarget();
        $controllerClass = get_class($controller);
        $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
        $config          = $e->getApplication()->getServiceManager()->get('config');
        if (isset($config['module_layouts'][$moduleNamespace])) {
            $controller->layout($config['module_layouts'][$moduleNamespace]);
        }
        $controller->layout('layout/application.phtml');
    }
}
