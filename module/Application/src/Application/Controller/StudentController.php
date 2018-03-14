<?php
/**
 * StudentController Source Code
 *
 * @category DormAssigner
 * @package DormAssigner\Application\Controller
 * @subpackage StudentController
 * @copyright Copyright (c) Daniel King
 * @version $Id$
 * @author Daniel K <danielk@inmotionhosting.com>
 */


namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\StudentForm;

use Application\Classes\Model\DormStudentQuery;

use PipelinePropel\Student;
use PipelinePropel\ContactInfo;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Student Controller
 *
 * Handles details for forms for updating and creating students
 *
 * @category DormAssigner
 * @package DormAssigner\Application\Controller
 * @subpackage StudentConjroller
 * @copyright Copyright (c) Daniel King
 * @version $$Id$$
 * @author Daniel K <danielk@inmotionhosting.com>
 */
class StudentController extends AbstractActionController
{
    /** @var Application\Classes\Model\DormStudentQuery $_student_query Model to hold student information. */
    private $_student_query;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_student_query = new DormStudentQuery();
    }

   /**
    * Index action
    *
    * View the main student page
    *
    * @return ViewModel
    */
    public function indexAction()
    {
        $dorm_students = $this->_student_query->fetchAll();

        $students = array();

        foreach ($dorm_students as $student) {
            array_push($students, $student->getArrayCopy());
        }

        return new ViewModel(array('students' => $students));
    }

   /**
    * Add action
    *
    * Add a student
    *
    * @return ViewModel
    */
    public function addAction()
    {
        $form = new StudentForm();
        $form->get('submit')->setValue('Add Student');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $student = $this->_student_query->new();

                $data = $form->getData();

                $student->exchangeArray($data);
                $student->save();

                $student_name = $student->getFullName();

                $message = "Success: Received data for '$student_name'.";

                return new ViewModel(array(
                    'form' => $form,
                    'success' => $message,
                ));
            } else {
                return new ViewModel(array(
                    'form' => $form,
                    'messages' => $form->getMessages()
                ));
            }
        }

        return new ViewModel(array('form' => $form));
    }

   /**
    * editAction
    *
    * Edit Student by ID
    *
    * @param string $student_id ID, which is the primary key for the Student table
    *
    * @return ViewModel
    */
    public function editAction()
    {
        $student_id = $this->params('studentId');
        $student = $this->_student_query->findById($student_id);

        if ($student == NULL) {
            $this->getResponse()->setStatusCode(404);
            return $this->getResponse();
        }

        $form = new StudentForm();
        $form->get('submit')->setValue('Update Student');
        $form->setIsUpdate();

        $form->setData($student->getArrayCopy());

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();

                $student->exchangeArray($data);
                $student->save();

                $student_name = $student->getFullName();

                $message = "Success: Updated data for '$student_name'.";

                return new ViewModel(array(
                    'form' => $form,
                    'success' => $message,
                ));
            } else {
                return new ViewModel(array(
                    'form' => $form,
                    'messages' => $form->getMessages()
                ));
            }
        }

        return new ViewModel(array('form' => $form));
    }

   /**
    * viewAction
    *
    * View Student by ID
    *
    * @param string $student_id ID, which is the primary key for the Student table
    *
    * @return ViewModel
    */
    public function viewAction()
    {
        $student_id = $this->params('studentId');
        $student = $this->_student_query->findById($student_id);

        if ($student == NULL) {
            $this->getResponse()->setStatusCode(404);
            return $this->getResponse();
        }

        $form = new StudentForm();

        $form->setData($student->getArrayCopy());

        return new ViewModel(array('form' => $form, 'id' => $student_id));
    }

   /**
    * deleteAction
    *
    * Delete Student by ID
    *
    * @param string $student_id ID, which is the primary key for the Student table
    *
    * @return ViewModel
    */
    public function deleteAction()
    {
        $student_id = $this->params('studentId');
        $student = $this->_student_query->findById($student_id);

        if ($student == NULL) {
            $this->getResponse()->setStatusCode(404);
            return $this->getResponse();
        }

        $form = new StudentForm();

        $form->setData($student->getArrayCopy());

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost('delete') == 'Yes, Delete') {
                $student->setStatus('inactive');
                $student->save();

                $student_name = $student->getFullName();

                $message = "Removed record for '$student_name'.";

                return new ViewModel(array(
                    'form' => $form,
                    'id' => $student_id,
                    'success' => $message,
                ));
            }
        }

        return new ViewModel(array('form' => $form, 'id' => $student_id));
    }
}
