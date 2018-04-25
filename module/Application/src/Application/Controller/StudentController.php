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
use Application\Form\AssignmentForm;

use Application\Classes\Model\DormStudentQuery;
use Application\Classes\DormRoomQuery;
use Application\Classes\DormRoomException;

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
        $this->_dorm_room_query = new DormRoomQuery();
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
                $student = $this->_student_query->newStudent();

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
                    'id' => $student_id,
                ));
            } else {
                return new ViewModel(array(
                    'form' => $form,
                    'messages' => $form->getMessages(),
                    'id' => $student_id,
                ));
            }
        }

        return new ViewModel(array(
            'form' => $form,
            'id' => $student_id,
        ));
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

   /**
    * assignAction
    *
    * Edit Student by ID
    *
    * @return ViewModel
    */
    public function assignAction()
    {
        $student_id = $this->params('studentId');
        $student = $this->_student_query->findById($student_id);

        if ($student == NULL) {
            $this->getResponse()->setStatusCode(404);
            return $this->getResponse();
        }

        $student_form = new StudentForm();

        $student_form->setData($student->getArrayCopy());


        $rooms = $this->_dorm_room_query->findUnoccupied($student->getGender());
        $room_list = array('none' => 'None');
        foreach ($rooms as $room) {
            $room_list[$room->getRoom()->getId()] = $room->getRoomName();
        }
        $form = new AssignmentForm($room_list);
        $form->get('submit')->setValue('Assign Student');

        $dorm_room = $this->_dorm_room_query->findByStudent($student->getStudent());

        if ($dorm_room == NULL) {
            $form->setData(array(
                'room_id' => 'none',
            ));
        } else {
            $form->setData(array(
                'room_id' => $dorm_room->getRoom()->getId(),
            ));
        }

        $form->setIsUpdate();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            $student_name = $student->getFullName();

            if ($form->isValid()) {
                $data = $form->getData();

                if ($data['room_id'] == 'none') {
                    if ($dorm_room != NULL) {
                        $dorm_room->unassignDormStudent($student);
                        $message = "Success: Unassigned '$student_name'.";
                    } else {
                        $message = "Success: '$student_name' is not assigned.";
                    }


                    return new ViewModel(array(
                        'student_form' => $student_form,
                        'assignment_form' => $form,
                        'id' => $student_id,
                        'success' => $message,
                    ));
                }

                $new_dorm_room = $this->_dorm_room_query->findByRoomId($data['room_id']);
                try {
                    $result = $new_dorm_room->assignDormStudent($student);
                } catch (DormRoomException $e) {
                    $code = $e->getCode();
                    return new ViewModel(array(
                        'student_form' => $student_form,
                        'assignment_form' => $form,
                        'id' => $student_id,
                        'messages' => array('room_id' => array($e->getMessage())),
                    ));
                }

                if (!$result) {
                    return new ViewModel(array(
                        'student_form' => $student_form,
                        'assignment_form' => $form,
                        'id' => $student_id,
                        'messages' => array('room_id', array("Assignment failed.")),
                    ));
                }


                $message = "Success: Assigned '$student_name' to '{$new_dorm_room->getRoomName()}'.";

                return new ViewModel(array(
                    'student_form' => $student_form,
                    'assignment_form' => $form,
                    'id' => $student_id,
                    'success' => $message,
                ));
            } else {
                return new ViewModel(array(
                    'student_form' => $student_form,
                    'assignment_form' => $form,
                    'id' => $student_id,
                    'messages' => $form->getMessages()
                ));
            }
        }

        return new ViewModel(array(
            'student_form' => $student_form,
            'assignment_form' => $form,
            'id' => $student_id,
        ));
    }

}
