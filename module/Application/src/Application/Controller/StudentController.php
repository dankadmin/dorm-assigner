<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Application\Form\StudentForm;
use PipelinePropel\Student;

class StudentController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function addAction()
    {
        $form = new StudentForm();
        $student = new Student();

        $form->get('submit')->setValue('Add');

        $form->setInputFilter($student->getInputFilter());

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $student->exchangeArray($form->getData());
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
