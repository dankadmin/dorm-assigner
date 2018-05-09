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
use Application\Classes\DormRoomQuery;


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
    /** @var DormRoomQuery $_dorm_room_query Class to return dorm rooms. */
    private $_dorm_room_query;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_dorm_room_query = new DormRoomQuery();
    }

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
            $dorm_array[$dorm->getId()] = $dorm->getName();
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


        $floor_list = array();

        $floors = \PipelinePropel\FloorQuery::create()
            ->filterByDorm($dorm)
            ->find();

        foreach ($floors as $floor) {
            $unit_list = array();
            $units = \PipelinePropel\UnitQuery::create()
                ->filterByFloor($floor)
                ->find();

            foreach($units as $unit) {
                $dorm_room_list = array();
                $gender = "unoccupied";

                $rooms = \PipelinePropel\RoomQuery::create()
                    ->filterByUnit($unit)
                    ->find();

                foreach($rooms as $room) {
                    $dorm_room = $this->_dorm_room_query->findByRoom($room);
                    $dorm_gender = $dorm_room->getGender();

                    if ($dorm_gender != NULL) {
                        $gender = $dorm_gender;
                    }
                    array_push($dorm_room_list, $dorm_room);
                }

                $unit_list[$unit->getName()] = array(
                    'gender' => $gender,
                    'rooms' => $dorm_room_list
                );
            }

            $floor_list[$floor->getName()] = $unit_list;
        }

        return new ViewModel(array(
            'dorm' => $dorm,
            'floors' => $floor_list,
        ));
    }
}
