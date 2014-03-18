<?php

namespace ApplicationTest;

use Application\Module;

class ModuleTest extends \PHPUnit_Framework_TestCase
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

    }

    public function tearDown()
    {
        unset(
            $this->serviceManager,
            $this->event,
            $this->module
        );
        \Mockery::close();
    }
}
