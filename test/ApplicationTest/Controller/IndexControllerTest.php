<?php

namespace ApplicationTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class IndexControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../../../config/application.config.php'
        );
        parent::setUp();
    }

    public function testHomePageCanBeAccessed()
    {
        $this->dispatch('/');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\Controller\Index');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('home');
        $this->assertQueryContentRegex('.jumbotron', '/.*Dorm Assigner.*/');
    }

    public function testHomePageHasNavigationToMainPages()
    {
        $this->dispatch('/');
        $this->assertResponseStatusCode(200);
        $this->assertQueryContentContains('ul.nav a', 'Home');
        $this->assertQueryContentContains('ul.nav a', 'Add Student');
    }

}
