<?php

namespace ApplicationTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class StudentControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../../../../../config/application.config.php'
        );
        parent::setUp();
    }

    public function testAddStudentPageCanBeAccessed()
    {
        $this->dispatch('/student/add');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\Controller\Student');
        $this->assertControllerClass('StudentController');
        $this->assertMatchedRouteName('addStudent');
        $this->assertQueryContentRegex('.panel-title', '/Add a New Student/');
    }

    public function testCanSubmitNewStudentWithName()
    {
        $this->dispatch(
            '/student/add',
            'POST',
            array(
                'id' => '',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'submit' => 'Add Student'
            )
        );

        $this->assertResponseStatusCode(200);

        $this->assertQueryContentRegex('.alert', '/.*Success.*/');
    }

}
