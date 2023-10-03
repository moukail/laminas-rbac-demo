<?php

namespace User;

use Application\Entity\Role;
use Application\Entity\User;
use Application\Service\MyRbac;
use Application\Service\RbacService;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\Mvc\ModuleRouteListener;
use Laminas\Mvc\MvcEvent;
use Login\Controller\IndexController;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_ROUTE, [$this, 'checkPermissions'], -100);
        $eventManager->getSharedManager()->attach(__NAMESPACE__, 'dispatch', [$this, 'layout'], 100);

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function checkPermissions(MvcEvent $e)
    {
        $serviceManager = $e->getApplication()->getServiceManager();

        $routeMatch = $e->getRouteMatch();
        $routeName = $routeMatch->getMatchedRouteName();

        $authenticationService = $serviceManager->get('doctrine.authenticationservice.orm_default');
        $rbacService = $serviceManager->get(RbacService::class);

        /** @var User $user */
        $user = $authenticationService->getIdentity();
        $role = $user?->getRole();

        $roleName = $role?->getName() ?? Role::ROLE_GUEST;

        if (!$rbacService->isGranted($roleName, $routeName)){
            $routeMatch->setParam('controller', IndexController::class);
            $routeMatch->setParam('action', 'login');
            $e->getResponse()->setStatusCode(403);
        }
    }

    public function layout(MvcEvent $e)
    {
        $controller = $e->getTarget();
        $controllerClass = get_class($controller);
        $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
        $config = $e->getApplication()->getServiceManager()->get('config');
        if (isset($config['module_layouts'][$moduleNamespace])) {
            $controller->layout($config['module_layouts'][$moduleNamespace]);
        }
        $controller->layout('layout/layout.phtml');
    }
}