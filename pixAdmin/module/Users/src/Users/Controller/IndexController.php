<?php //

namespace Users\Controller;

use CustomLib\Controller\CustomController;
use Zend\View\Model\ViewModel;
use Zend\Crypt\Password\Bcrypt;
use Zend\View\Model\JsonModel;
use CustomLib\Service\ApiSecurity;
use Users\Form\UserForm;
use Users\Form\AddCreditForm;
use Zend\View\View;
use Zend\Session\Container;

use CustomLib\Service\UserPassword;

/**
 * 
 * @author adminuser
 *
 */
class IndexController extends CustomController {

    protected $_usersTable;

    /**
     * (non-PHPdoc)
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function indexAction() {
        return new ViewModel(array(
                ));
    }

    public function getUserListAction(){
         $loginTable = $this->getServiceLocator()->get('Application\Model\UsersTable');
         $request = $this->getRequest();
        $data = $request->getPost()->toArray();
        $resultsUserTypes = $loginTable->getUserTypesList();
       
        $view = new ViewModel(array('resultsUserTypes' => $resultsUserTypes,
            
                ));
         $view->setTerminal(true);
        return $view;
    }
    
    public function imagesDetailsAction(){ 
        $loginTable = $this->getServiceLocator()->get('Application\Model\UsersTable');
        $userId=$this->params('id');
        $config = $this->getServiceLocator()->get("config");
        $sPath = $config["settings"]['S3BUCKET']["TEMPPATH"];
        $s3Url = $config["settings"]['S3BUCKET']['BUCKETURL'];
         $request = $this->getRequest();
        $data = $request->getPost()->toArray(); 
        $userImages = $loginTable->getUserImagesList(base64_decode($userId));
       
        $view = new ViewModel(array('userImages' => $userImages,'s3Url' =>$s3Url));
//         $view->setTerminal(true);
        return $view;
    }
    
    public function blockUserAction(){
               $loginTable = $this->getServiceLocator()->get('Application\Model\UsersTable');
//               $userId = $this->params('id');
               $request = $this->getRequest();
               $data = $request->getPost()->toArray(); 
               
                $newData = array(
                 'status' => 2
                );
                $updateStatus = $loginTable->updateData('user', $newData, array('id' => $data['userId']));
                return new JsonModel();
                }
           
     public function userMoreDetailsAction(){
        $loginTable = $this->getServiceLocator()->get('Application\Model\UsersTable');
        $userId = $this->params('id');
        $request = $this->getRequest();
        $data = $request->getPost()->toArray(); 
        $userDetails = $loginTable->getUserFullDetails(base64_decode($userId));
        $userPlanDetails = $loginTable->getUserPlanDetails(base64_decode($userId));
         $userPlan = $loginTable->getPlansDetails(base64_decode($userId));
        foreach($userPlan as $k =>$v){
         $count += $v['noOfImages'];
         }
        $assetsDetails = $loginTable->getImageCountDetails(base64_decode($userId));
        $totalImageCount=$count-$assetsDetails[0]['imageId'];
//        echo "<pre>";print_r($userPlanDetails);die;
        
        $view = new ViewModel(array('userDetails'=>$userDetails,'userPlanDetails'=>$userPlanDetails,'totalImageCount'=>$totalImageCount));
        return $view;
        }   
           
}

?>