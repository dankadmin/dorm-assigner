<?php

namespace ApplicationTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Application\Classes\Model\DormStudentQuery;

class StudentControllerTest extends AbstractHttpControllerTestCase
{
    /** @var Application\Classes\Model\DormStudentQuery $_student_query Model to hold student information. */
    private $_student_query;

    public function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../../../config/application.config.php'
        );
        parent::setUp();

        $this->_student_query = new DormStudentQuery();
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


    public function testCanSubmitNewStudent()
    {
        $student_num = 'JD123457';
        $this->dispatch(
            '/student/add',
            'POST',
            array(
                'id' => '',
                'first_name' => 'John Jr.',
                'last_name' => 'Doe',
                'address_1' => '123 Main Street',
                'city' => 'Someplace',
                'state' => 'AL',
                'zip' => '12345',
                'gender' => 'male',
                'student_num' => $student_num,
                'birth_date' => '1970-01-01',
                'phone_number' => '7575551234',
                'status' => 'active',
                'submit' => 'Add Student'
            )
        );

        $this->assertResponseStatusCode(200);

        $this->assertQueryContentRegex('.alert', '/.*Success.*./');

        $student = $this->_student_query->findByStudentNum($student_num);
        $student->hardDelete();
    }

    public function testDuplicateStudentIdFailsWithMessage()
    {
        $student_num = 'JD123459';


        $data = array(
            'id' => '',
            'first_name' => 'John III',
            'last_name' => 'Doe',
            'address_1' => '123 Main Street',
            'city' => 'Someplace',
            'state' => 'Alabama',
            'zip' => '12345',
            'gender' => 'male',
            'student_num' => $student_num,
            'birth_date' => '1970-01-01',
            'phone_number' => '7575551234',
            'status' => 'active',
        );  

        $student = $this->_student_query->newStudent();
        $student->exchangeArray($data);
        $student->save();


        $this->dispatch(
            '/student/add',
            'POST',
            array(
                'id' => '',
                'first_name' => 'John Jr.',
                'last_name' => 'Doe',
                'address_1' => '123 Main Street',
                'city' => 'Someplace',
                'state' => 'AL',
                'zip' => '12345',
                'gender' => 'male',
                'student_num' => $student_num,
                'birth_date' => '1970-01-01',
                'phone_number' => '7575551234',
                'status' => 'active',
                'submit' => 'Add Student'
            )
        );

        $this->assertResponseStatusCode(200);

        $this->assertQueryContentRegex('.alert', '/.*Student ID: Student already exists with number.*./');

        $student->hardDelete();
    }

}
