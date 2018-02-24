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
                'street' => '123 Main Street',
                'city' => 'Someplace',
                'state' => 'Alabama',
                'zip' => '12345',
                'gender' => 'male',
                'student_num' => 'JD123456',
                'birth_date' => '19700101',
                'status' => 'active',
                'submit' => 'Add Student'
            )
        );

        $this->assertResponseStatusCode(200);

        $this->assertQueryContentRegex('.alert', '/.*Success.*/');
    }

}
