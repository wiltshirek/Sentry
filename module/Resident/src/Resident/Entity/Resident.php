<?php

namespace Resident\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface; 

/**
 * A music resident.
 *
 * @ORM\Entity
 * @ORM\Table(name="resident")
 * @property string $artist
 * @property string $title
 * @property int $id
 */
class Resident implements InputFilterAwareInterface 
{
    protected $inputFilter;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $resident_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $last_name;

    /**
     * @ORM\Column(type="string")
     */
    protected $first_name;
    /**
     * @ORM\Column(type="string")
     */
    protected $middle_name;
    /**
     * @ORM\Column(type="string")
     */
    protected $ssno;
    /**
     * @ORM\Column(type="string")
     */
    protected $register_number;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $dob;

    /**
     * Magic getter to expose protected properties.
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property) 
    {
        return $this->$property;
    }

    /**
     * Magic setter to save protected properties.
     *
     * @param string $property
     * @param mixed $value
     */
    public function __set($property, $value) 
    {
        $this->$property = $value;
    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy() 
    {
        return get_object_vars($this);
    }

    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function populate($data = array()) 
    {
        $this->id = $data['resident_id'];
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
        $this->middle_name = $data['middle_name'];
        $this->ssno = $data['ssno'];
        $this->register_number = $data['register_number'];
        $this->dob = $data['dob'];
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'       => 'resident_id',
                'required'   => true,
                'filters' => array(
                    array('name'    => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'first_name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 255,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'last_name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 255,
                        ),
                    ),
                ),
            )));
            $inputFilter->add($factory->createInput(array(
            		'name'     => 'middle_name',
            		'required' => true,
            		'filters'  => array(
            				array('name' => 'StripTags'),
            				array('name' => 'StringTrim'),
            		),
            		'validators' => array(
            				array(
            						'name'    => 'StringLength',
            						'options' => array(
            								'encoding' => 'UTF-8',
            								'min'      => 1,
            								'max'      => 255,
            						),
            				),
            		),
            )));
            $inputFilter->add($factory->createInput(array(
            		'name'     => 'register_number',
            		'required' => true,
            		'filters'  => array(
            				array('name' => 'StripTags'),
            				array('name' => 'StringTrim'),
            		),
            		'validators' => array(
            				array(
            						'name'    => 'Digits',
            				),
            		),
            )));
            $inputFilter->add($factory->createInput(array(
            		'name'     => 'ssno',
            		'required' => true,
            		'filters'  => array(
            				array('name' => 'StripTags'),
            				array('name' => 'StringTrim'),
            		),
            		'validators' => array(
            				array(
            						'name'    => 'StringLength',
            						'options' => array(
            								'encoding' => 'UTF-8',
            								'min'      => 1,
            								'max'      => 255,
            						),
            				),
            		),
            )));
            
            $inputFilter->add($factory->createInput(array(
            		'name'     => 'dob',
            		'required' => false,
            		'filters'  => array(
            				array('name' => 'StripTags'),
            				
            		),
            		'validators' => array(
            				array(
            						'name'    => 'StringLength',
            						'options' => array(
            								
            						),
            				),
            		),
            )));

            $this->inputFilter = $inputFilter;        
        }

        return $this->inputFilter;
    } 
}
