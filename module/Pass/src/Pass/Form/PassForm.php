<?php
namespace Resident\Form;

use Zend\Form\Form;

class ResidentForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('resident');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'resident_id',
            'type' => 'Hidden',
            'attributes' => array(
            		'id' => 'resident_id',
            ),
        ));
        $this->add(array(
            'name' => 'first_name',
            'type' => 'Text',
            'attributes' => array(
            		'id' => 'first_name',
                ),
            
        ));
        $this->add(array(
            'name' => 'last_name',
            'type' => 'Text',
            'attributes' => array(
            		'id' => 'last_name',
                ),
            
        ));
        $this->add(array(
        		'name' => 'middle_name',
        		'type' => 'Text',
        		
        ));
        $this->add(array(
        		'name' => 'ssno',
        		'type' => 'Text',
        		
        ));
        $this->add(array(
        		'name' => 'register_number',
        		'type' => 'Zend\Form\Element\Text',
                'attributes' => array(
            		'id' => 'register_number',
            ),
        		
        ));
        $this->add(array(
        		'name' => 'dob',
        		'type' => 'Text',
        		
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
}