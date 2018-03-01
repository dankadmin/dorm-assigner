<?php
/**
 * DormController Source Code
 *
 * @category DormAssigner
 * @package DormAssigner\Application\Controller
 * @subpackage DormController
 * @copyright Copyright (c) Daniel King
 * @version $Id$
 * @author Daniel K <danielk@inmotionhosting.com>
 */


namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use PipelinePropel\DormQuery;

/**
 * Dorm Controller
 *
 * Handles details for forms for handling  dorms
 *
 * @category DormAssigner
 * @package DormAssigner\Application\Controller
 * @subpackage DormConjroller
 * @copyright Copyright (c) Daniel King
 * @version $$Id$$
 * @author Daniel K <danielk@inmotionhosting.com>
 */
class DormController extends AbstractActionController
{
   /**
    * Index action
    *
    * View the main dorm page
    *
    * @return ViewModel
    */
    public function indexAction()
    {
        $dorms = DormQuery::create()->find();
        $dorm_array = array();

        foreach ($dorms as $dorm) {
            $dorm_array[$dorm->getId()] = $dorm->getName;
        }

        return new ViewModel(array('dorms' => $dorm_array));
    }

   /**
    * View action
    *
    * View a dorm. Expects 'dormId' to be a valid dorm primary key
    *
    * @return ViewModel
    */
    public function viewAction()
    {
        $dorm_id = $this->params('dormId');
        if (preg_match('/^[0-9]+$/', $dorm_id)) {
            if ($dorm_id < 1) {
                $dorm = DormQuery::create()->findOne();
            } else {
                $dorm = DormQuery::create()->findPK($dorm_id);
            }
        } elseif (preg_match('/^[A-Z]+$/', $dorm_id)) {
            $dorm = DormQuery::create()->findOneByName($dorm_id);
        }

        if ($dorm == NULL) {
            $this->getResponse()->setStatusCode(404);
            return $this->getResponse();
        }


        return new ViewModel(array('dorm' => $dorm));
    }
}
