<?php

namespace Test\Factory;

use Faker;

class StudentDataFactory
{
    private $_faker;
    private $_data;

    public function __construct(Faker\Generator $faker)
    {
        $this->_faker = $faker;
        $this->_data = array();
    }

    private function set_from_values($values, $field)
    {
        if (isset($values[$field])) {
            $this->_data[$field] = $values[$field];
            return true;
        }
        
        return false;
    }

    public function create($values=array())
    {
        
        if (!$this->set_from_values($values, 'gender')) {
            $this->_data['gender'] = (rand() % 2) ? "male": "female";
        }

        if (!$this->set_from_values($values, 'first_name')) {
            $this->_data['first_name'] = $this->_faker->firstName($this->_data['gender']);
        }

        if (!$this->set_from_values($values, 'last_name')) {
            $this->_data['last_name'] = $this->_faker->lastName;
        }

        if (!$this->set_from_values($values, 'address_1')) {
            $this->_data['address_1'] = $this->_faker->streetAddress;
        }

        if (!$this->set_from_values($values, 'city')) {
            $this->_data['city'] = $this->_faker->city;
        }

        if (!$this->set_from_values($values, 'state')) {
            $this->_data['state'] = $this->_faker->stateAbbr;
        }

        if (!$this->set_from_values($values, 'zip')) {

            preg_match('/^([0-9]{5})/', $this->_faker->postcode, $zip_matches);

            $this->_data['zip'] = $zip_matches[1];
        }

        if (!$this->set_from_values($values, 'student_num')) {
            $this->_data['student_num'] = '';
            
            $this->_data['student_num'] .= substr($this->_data['first_name'], 0, 1);
            $this->_data['student_num'] .= substr($this->_data['last_name'], 0, 1);
            $this->_data['student_num'] = strtoupper($this->_data['student_num']);

            for ($digit = 1; $digit <= 6; $digit++) {
                $this->_data['student_num'] .= $this->_faker->randomDigitNotNull;
            }
            //$this->_data['student_num'] = 'JD123459';
        }

        if (!$this->set_from_values($values, 'birth_date')) {
            $this->_data['birth_date'] = $this->_faker->date();
        }

        if (!$this->set_from_values($values, 'phone_number')) {
            $phone_matches = array();

            preg_match(
                '/^1?([0-9]{10})/',
                preg_replace('/[^0-9]/', '', $this->_faker->phoneNumber),
                $phone_matches
            );

            $this->_data['phone_number'] = $phone_matches[1];
        }

        if (!$this->set_from_values($values, 'status')) {
            $this->_data['status'] = 'active';
        }

        return $this->_data;
    }
}
