<?php
/**
  * States Source Code
  *
  * @category DormAssigner 
  * @package DormAssigner\Application\Classes
  * @subpackage States
  * @copyright Copyright (c) Daniel King
  * @version $Id$
  * @author Daniel K <danielk@inmotionhosting.com>
  */

namespace Application\Classes;

/**
  * US States
  *
  * Standard names of US States which are acceptable values for the application.
  *
  * @category DormAssigner
  * @package DormAssigner\Application\Classes
  * @subpackage States
  * @copyright Copyright (c) Daniel King
  * @version $$Id$$
  * @author Daniel K <danielk@inmotionhosting.com>
  */
class States
{

    /** @var array $_state_list List of all acceptable states. */
    private $_state_list;

    /**
      * Constructor
      *
      * Set the list of available states.
      *
      */
    public function __construct()
    {
        $this->_state_list = array(
            'AL' => 'Alabama',
            'AK' => 'Alaska',
            'AZ' => 'Arizona',
            'AR' => 'Arkansas',
            'CA' => 'California',
            'CO' => 'Colorado',
            'CT' => 'Connecticut',
            'DE' => 'Delaware',
            'FL' => 'Florida',
            'GA' => 'Georgia',
            'HI' => 'Hawaii',
            'ID' => 'Idaho',
            'IL' => 'Illinois',
            'IN' => 'Indiana',
            'IA' => 'Iowa',
            'KS' => 'Kansas',
            'KY' => 'Kentucky',
            'LA' => 'Louisiana',
            'ME' => 'Maine',
            'MD' => 'Maryland',
            'MA' => 'Massachusetts',
            'MI' => 'Michigan',
            'MN' => 'Minnesota',
            'MS' => 'Mississippi',
            'MO' => 'Missouri',
            'MT' => 'Montana',
            'NE' => 'Nebraska',
            'NV' => 'Nevada',
            'NH' => 'New Hampshi',
            'NJ' => 'New Jers',
            'NM' => 'New Mexi',
            'NY' => 'New Yo',
            'NC' => 'North Caroli',
            'ND' => 'North Dako',
            'OH' => 'Ohio',
            'OK' => 'Oklahoma',
            'OR' => 'Oregon',
            'PA' => 'Pennsylvania',
            'RI' => 'Rhode Isla',
            'SC' => 'South Caroli',
            'SD' => 'South Dako',
            'TN' => 'Tennessee',
            'TX' => 'Texas',
            'UT' => 'Utah',
            'VT' => 'Vermont',
            'VA' => 'Virginia',
            'WA' => 'Washington',
            'WV' => 'West Virgin',
            'WI' => 'Wisconsin',
            'WY' => 'Wyoming',
        );
    }

    /**
      * Get states array
      *
      * @return array Returns array which is a list of all acceptable US state names.
      */
    public function getArray()
    {
        return $this->_state_list;
    }
}
