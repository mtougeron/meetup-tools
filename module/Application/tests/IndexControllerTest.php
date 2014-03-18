<?php

namespace Application\tests;

use Application\Module;
use Application\Controller\IndexController;
use Zend\Http\Request as HttpRequest;
use Zend\Mvc\Router\RouteMatch;

class IndexControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Application\Module
     */
    protected $module;

    /**
     * @var Zend\Mvc\MvcEvent
     */
    protected $event;

    protected $serviceManager;

    protected $controller;

    protected $request;

    public function setUp()
    {
        // get application stack configuration
        $configuration = include dirname(dirname(dirname(__DIR__))) . '/config/application.config.php';
        $configuration['module_listener_options']['config_cache_enabled'] = false;

        $application = \Zend\Mvc\Application::init($configuration);
        $this->serviceManager = $application->getServiceManager();
        $this->serviceManager->setAllowOverride(true);
        $this->event = $application->getMvcEvent();
        $this->module = new \Application\Module();
        $this->controller = new IndexController();
        $this->controller->setServiceLocator($this->serviceManager);
    }

    public function tearDown()
    {
        unset(
            $this->serviceManager,
            $this->event,
            $this->module,
            $this->controller,
            $this->request
        );
        \Mockery::close();
    }

    protected function dispatch($action, $params = array())
    {
        $routeMatch = new \Zend\Mvc\Router\RouteMatch(array_merge(array('action' => $action), $params));
        $this->event->setRouteMatch($routeMatch);
        $this->controller->setEvent($this->event);
        $request = ($this->request ? $this->request : new HttpRequest());
        $this->controller->dispatch($request);

        return $this->event->getResult();
    }

}
