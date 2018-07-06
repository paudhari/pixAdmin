<?php 
namespace Subscription\Form; 


use Zend\Form\Form; 

class SubscriptionForm extends Form 
{ 
    public function __construct($userId = 0) 
           
    { 
        parent::__construct('subcriptionform'); 
        
        $this->setAttribute('method', 'post'); 
        $this->setAttribute('class', 'form-horizontal');
//        $this->setAttribute('action','');
          
        $this->add(array( 
            'name' => 'userId', 
            'type' => 'Zend\Form\Element\Hidden', 
            'attributes' => array( 
                'id' => 'userId', 
                'value' => $userId, 
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'noOfImages', 
            'type' => 'text', 
            'attributes' => array( 
                'id' => 'noOfImages', 
                'required' => 'required', 
                'class' => 'form-control',
                'autocomplete' => 'off'
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'planName', 
            'type' => 'text', 
            'attributes' => array( 
                'id' => 'planName', 
                'required' => 'required', 
                'class' => 'form-control',
                'autocomplete' => 'off'
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'duration', 
               'type' => 'Zend\Form\Element\Select',
            'attributes' => array( 
                'id' => 'duration', 
                'required' => 'required', 
                'class' => 'form-control',
                'autocomplete' => 'off',
                  'options' => array(
                    '' => ('Select'),
                    '0' => 'One Time',
                    '1' => 'Recurring',
                ),
                'onchange' => 'getDetails(this.value)'
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'price', 
            'type' => 'text', 
            'attributes' => array( 
                'id' => 'price', 
                'required' => 'required', 
                'class' => 'form-control',
                'autocomplete' => 'off'
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'startDate', 
            'type' => 'Zend\Form\Element\text', 
            'attributes' => array( 
                'id' => 'startDate', 
                'required' => 'required', 
                'class' => 'form-control'
            ), 
        )); 
        $this->add(array( 
            'name' => 'endDate', 
            'type' => 'Zend\Form\Element\text', 
            'attributes' => array( 
                'id' => 'endDate', 
                'required' => 'required', 
                'class' => 'form-control'
            ), 
        )); 


     
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Submit',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary',
            ),
        ));
        
        
               
    } 
} 