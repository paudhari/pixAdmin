<?php //

namespace Order\Controller;

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
class OrderController extends CustomController {

    protected $_usersTable;

   
    public function indexAction() {
        return new ViewModel();
    }
    
      public function getUserListAction(){
         $loginTable = $this->getServiceLocator()->get('Application\Model\UsersTable');
         $request = $this->getRequest();
        $data = $request->getPost()->toArray();
        $resultsUserTypes = $loginTable->getUserOrderList();
        $view = new ViewModel(array('resultsUserTypes' => $resultsUserTypes,'userImages'=>$userImages,
            
                ));
         $view->setTerminal(true);
        return $view;
    }
    
    public function imagesDetailsAction(){ 
        $loginTable = $this->getServiceLocator()->get('Application\Model\UsersTable');
        $userId=$this->params('id');
//        echo "<pre>";print_r(base64_decode($userId));
        $orderId=$this->params('type');
//          echo "<pre>";print_r(base64_decode($orderId));die;
        $config = $this->getServiceLocator()->get("config");
        $sPath = $config["settings"]['S3BUCKET']["TEMPPATH"];
        $s3Url = $config["settings"]['S3BUCKET']['BUCKETURL'];
         $request = $this->getRequest();
        $data = $request->getPost()->toArray(); 
        $userImages = $loginTable->getUserImagesList(base64_decode($userId),  base64_decode($orderId));
        $view = new ViewModel(array('userImages' => $userImages,'s3Url' =>$s3Url));
//         $view->setTerminal(true);
        return $view;
    }

    public function inmatesDetailsAction(){
        $inmateTable = $this->getServiceLocator()->get('Order\Model\InmatesTable');
        $inmateId=$this->params('id');
        $request = $this->getRequest();
        $data = $request->getPost()->toArray();
        $userInmates = $inmateTable->getInmatesIdDetails(base64_decode($inmateId));
        $view = new ViewModel(array('userInmates' => $userInmates));
//         $view->setTerminal(true);
        return $view;
    }
     
    public function downloadAction(){
        $config = $this->getServiceLocator()->get("config");
        $sPath = $config["settings"]['S3BUCKET']["TEMPPATH"];
        $s3Url = $config["settings"]['S3BUCKET']['BUCKETURL'];
        $file = $_GET['file'];
        $file = $s3Url.$file;
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private',false);
        header('Content-Description: File Transfer');
        header("Content-type: image/jpg");
        header("Content-disposition: attachment; filename= ".basename($file)."");
//        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file); 
        exit;
    }
    
}

?>