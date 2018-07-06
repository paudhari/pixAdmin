<?php 
namespace Users\Form; 


use Zend\Form\Form; 

class UserForm extends Form 
{ 
    public function __construct($userId = 0) 
    { 
        parent::__construct('userform'); 
        
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
            'name' => 'FirstName', 
            'type' => 'text', 
            'attributes' => array( 
                'id' => 'FirstName', 
                'placeholder' => 'enter first name', 
                'required' => 'required', 
                'class' => 'form-control',
                'autocomplete' => 'off'
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'LastName', 
            'type' => 'text', 
            'attributes' => array( 
                'id' => 'LastName', 
                'placeholder' => 'enter last name', 
                'required' => 'required', 
                'class' => 'form-control',
                'autocomplete' => 'off'
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'UserName', 
            'type' => 'text', 
            'attributes' => array( 
                'id' => 'UserName', 
                'placeholder' => 'enter user name', 
                'required' => 'required', 
                'class' => 'form-control',
                'autocomplete' => 'off'
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'Mobile', 
            'type' => 'Zend\Form\Element\text', 
            'attributes' => array( 
                'id' => 'Mobile', 
                'placeholder' => 'enter mobile', 
                'required' => 'required', 
                'class' => 'form-control'
            ), 
        )); 


        $this->add(array(
            'name' => 'Email',
            'type' => 'Zend\Form\Element\Email',
            'attributes' => array(
                'id' => 'Email',
                'placeholder' => 'enter email',
                'required' => 'required',
                'class' => 'form-control',
                'autocomplete' => 'off'
            ),
        ));
        $this->add(array(
            'name' => 'gender',
            'type' => 'Zend\Form\Element\text',
            'attributes' => array(
                'id' => 'gender',
                'placeholder' => 'select gender',
                'required' => 'required',
                'class' => 'form-control',
                'autocomplete' => 'off'
            ),
        ));
        $this->add(array(
            'name' => 'DOB',
            'type' => 'Zend\Form\Element\text',
            'attributes' => array(
                'id' => 'DOB',
                'placeholder' => 'enter dob',
                'required' => 'required',
                'class' => 'form-control',
                'autocomplete' => 'off'
            ),
        ));
        $this->add(array(
            'name' => 'occupation',
            'type' => 'Zend\Form\Element\text',
            'attributes' => array(
                'id' => 'occupation',
                'placeholder' => 'enter dob',
                'required' => 'required',
                'class' => 'form-control',
                'autocomplete' => 'off'
            ),
        ));
        $this->add(array(
            'name' => 'Yourbio',
            'type' => 'Zend\Form\Element\text',
            'attributes' => array(
                'id' => 'Yourbio',
                'placeholder' => 'enter dob',
                'required' => 'required',
                'class' => 'form-control',
                'autocomplete' => 'off'
            ),
        ));
        $this->add(array(
            'name' => 'hometown',
            'type' => 'Zend\Form\Element\text',
            'attributes' => array(
                'id' => 'hometown',
                'placeholder' => 'enter dob',
                'required' => 'required',
                'class' => 'form-control',
                'autocomplete' => 'off'
            ),
        ));
        
        
        $this->add(array( 
            'name' => 'password', 
            'type' => 'password', 
            'attributes' => array( 
                'id' => 'password', 
                'placeholder' => 'enter password', 
                'required' => 'required', 
                'class' => 'form-control'
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'confirmPassword', 
            'type' => 'password', 
            'attributes' => array( 
                'id' => 'confirmPassword', 
                'placeholder' => 'confirm password', 
                'required' => 'required', 
                'class' => 'form-control'
            ), 
        )); 
        
        $this->add(array(
            'name' => 'Company',
            'type' => 'Zend\Form\Element\text',
            'attributes' => array(
                'id' => 'Company',
                'placeholder' => 'enter company',
                'required' => 'required',
//                'onchange' => 'getUserRoles(this.value)',
                'class' => 'form-control',
            ),
        ));
        
        $this->add(array(
            'name' => 'Role',
            'type' => 'Zend\Form\Element\text',
            'attributes' => array(
                'id' => 'Role',
                'placeholder' => 'enter role',
                'required' => 'required',
//                'disabled' => 'disabled',
                'class' => 'form-control',
            ),
        ));
        $this->add(array(
            'name' => 'address',
            'type' => 'Zend\Form\Element\text',
            'attributes' => array(
                'id' => 'address',
                'placeholder' => 'enter address',
                'required' => 'required',
//                'disabled' => 'disabled',
                'class' => 'form-control',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
                'class' => 'btn green',
            ),
        ));
        
        
               
    } 
} 