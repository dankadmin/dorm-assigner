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
   /**
    * Index action
    *
    * View the main student page
    *
    * @return ViewModel
    */
    public function indexAction()
    {
        return new ViewModel();
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
                $student_name = $request->getPost('first_name') . " " . $request->getPost('last_name');
                return new ViewModel(array(
                    'form' => $form,
                    'success' => "Successful request to create $student_name"
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
}
