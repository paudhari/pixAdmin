<?php 
namespace Notes\Form; 


use Zend\Form\Form; 

class NotesForm extends Form 
{ 
    public function __construct($noteId = 0) 
    { 
        parent::__construct('notesform'); 
        
        $this->setAttribute('method', 'post'); 
        $this->setAttribute('class', 'form-horizontal');
//        $this->setAttribute('action','');
          
        $this->add(array( 
            'name' => 'noteId', 
            'type' => 'Zend\Form\Element\Hidden', 
            'attributes' => array( 
                'id' => 'noteId', 
                'value' => $noteId, 
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'noteDescription', 
            'type' => 'textarea', 
            'attributes' => array( 
                'id' => 'noteDescription', 
//                'rows'=>4,
//                'cols'=>50,
                'required' => 'required', 
                'class' => 'form-control',
                'autocomplete' => 'off',
                'style'=>"width: 530px; height: 148px;"
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
