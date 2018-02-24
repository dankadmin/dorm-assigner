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
			'Alabama' => 'Alabama',
			'Alaska' => 'Alaska',
			'Arizona' => 'Arizona',
			'Arkansas' => 'Arkansas',
			'California' => 'California',
			'Colorado' => 'Colorado',
			'Connecticut' => 'Connecticut',
			'Delaware' => 'Delaware',
			'Florida' => 'Florida',
			'Georgia' => 'Georgia',
			'Hawaii' => 'Hawaii',
			'Idaho' => 'Idaho',
			'Illinois' => 'Illinois',
			'Indiana' => 'Indiana',
			'Iowa' => 'Iowa',
			'Kansas' => 'Kansas',
			'Kentucky' => 'Kentucky',
			'Louisiana' => 'Louisiana',
			'Maine' => 'Maine',
			'Maryland' => 'Maryland',
			'Massachusetts' => 'Massachusetts',
			'Michigan' => 'Michigan',
			'Minnesota' => 'Minnesota',
			'Mississippi' => 'Mississippi',
			'Missouri' => 'Missouri',
			'Montana' => 'Montana',
			'Nebraska' => 'Nebraska',
			'Nevada' => 'Nevada',
			'New Hampshire' => 'New Hampshire',
			'New Jersey' => 'New Jersey',
			'New Mexico' => 'New Mexico',
			'New York' => 'New York',
			'North Carolina' => 'North Carolina',
			'North Dakota' => 'North Dakota',
			'Ohio' => 'Ohio',
			'Oklahoma' => 'Oklahoma',
			'Oregon' => 'Oregon',
			'Pennsylvania' => 'Pennsylvania',
			'Rhode Island' => 'Rhode Island',
			'South Carolina' => 'South Carolina',
			'South Dakota' => 'South Dakota',
			'Tennessee' => 'Tennessee',
			'Texas' => 'Texas',
			'Utah' => 'Utah',
			'Vermont' => 'Vermont',
			'Virginia' => 'Virginia',
			'Washington' => 'Washington',
			'West Virginia' => 'West Virginia',
			'Wisconsin' => 'Wisconsin',
			'Wyoming' => 'Wyoming',
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
