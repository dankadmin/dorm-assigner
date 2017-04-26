<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function testViewAction() {
        $view = new ViewModel();

        $view->message = "This is a test message";
        return $view;
    }

    public function findAction() {
        $students = \PipelinePropel\StudentQuery::create()
            ->filterByLastName('Joseph')
            ->find();
        var_dump($students);exit;
    }

    public function findOneAction() {
        $students = \PipelinePropel\StudentQuery::create()
            ->filterByLastName('Joseph')
            ->findOne();
        var_dump($students);exit;
    }

    public function insertAction() {
        $names = ['James', 'Colbert','Robert','William','Brady','Smith','Grant','Jefferson','Washington','Monroe','Allen','Ryan','Joseph'];

        $firstName  = $names[array_rand($names)];
        $lastName   = $names[array_rand($names)];
        $studentNum = $firstName[0] . $lastName[0] . mt_rand(100000,999999); 

        $birthDate = mt_rand(1950,2000) . '-' . mt_rand(1,12) . '-' . mt_rand(0,28);
        $student = new \PipelinePropel\Student();
        $student->setFirstName($firstName)
            ->setLastName($lastName)
            ->setGender('male')
            ->setStudentNum($studentNum)
            ->setBirthDate($birthDate)
            ->save();

        var_dump($student);exit;
    }
}
