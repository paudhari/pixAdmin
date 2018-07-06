<?php //

namespace Notes\Controller;

use CustomLib\Controller\CustomController;
use Zend\View\Model\ViewModel;
use Zend\Crypt\Password\Bcrypt;
use Zend\View\Model\JsonModel;
use CustomLib\Service\ApiSecurity;
use Notes\Form\NotesForm;
use Users\Form\AddCreditForm;
use Zend\View\View;
use Zend\Session\Container;

use CustomLib\Service\UserPassword;

/**
 * 
 * @author adminuser
 *
 */
class NotesController extends CustomController {

    protected $_usersTable;

   
    public function indexAction() {
        return new ViewModel();
    }
    
    /**
     * AddNoteAction
     */
    public function AddNoteAction(){
        $getConfig = $this->getServiceLocator()->get('config');
        $notesTable = $this->getServiceLocator()->get('Notes\Model\NotesTable');
        $logedInId = $this->getLoggedInUserId();
        $form = new NotesForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
             $note = array();
            $note['note_title'] = 'Note';
            $note['note_description'] = $data['noteDescription'];
            $note['status'] = '1';
            $note['created_by'] = $logedInId;
            $note['created_on'] = time();
            $noteId = $notesTable->saveData('add_note', $note);
             return $this->redirect()->toUrl('/notes/index');
        }
        return new ViewModel(array('form' => $form));
    }
    
   public function getNotesListAction(){
        $notesTable = $this->getServiceLocator()->get('Notes\Model\NotesTable');
        $logedInId = $this->getLoggedInUserId();
        $getNotes = $notesTable->getNotesData($logedInId);
//        echo "<pre>";print_r($getNotes);die;
        $view = new ViewModel(array('getNotes' => $getNotes,
        ));
        $view->setTerminal(true);
        return $view;
   }
    
   public function getNotesDescriptionAction(){
         $notesTable = $this->getServiceLocator()->get('Notes\Model\NotesTable');
          $request = $this->getRequest();
          $data = $request->getPost()->toArray();
           $notesDesc = $notesTable->getNotesDescription($data['noteId']);
           $view = new ViewModel(array('notesDesc' => $notesDesc[0]['noteDescription'],'noteId'=>$data['noteId']));
           $view->setTerminal(true);
           return $view;
   }
   
    public function editNoteAction(){
        $noteId=$this->params('id');
      $notesTable = $this->getServiceLocator()->get('Notes\Model\NotesTable');
        $form = new NotesForm();
          $request = $this->getRequest();
          if ($request->isPost()) {
          $data = $request->getPost()->toArray();
           $updateNote = $notesTable->updateData('add_note', array('note_description'=>$data['noteDescription']), array('id'=>$data['noteId']));
             return new JsonModel();
           }
            $notesDesc = $notesTable->getNotesDescription(base64_decode($noteId));
            if (!empty($notesDesc)) {
            $noteData = array(
                'noteId' => base64_decode($noteId),
                'noteDescription' => $notesDesc[0]['noteDescription'],
            );
            $form->setData($noteData);
        }
      $view= new ViewModel(array(
            'form' => $form,
            'planId' => base64_decode($noteId),
        ));
             $view->setTerminal(true);
           return $view;
    }
    public function deleteNoteAction (){
        $notesTable = $this->getServiceLocator()->get('Notes\Model\NotesTable');
        $request = $this->getRequest();
        $data = $request->getPost()->toArray();
        $newData = array(
            'status' => 2
        );
        $updateStatus = $notesTable->updateData('add_note', $newData, array('id' => $data['noteId']));
        return new JsonModel();
    }

}
?>
