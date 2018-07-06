<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use CustomLib\Controller\CustomController;
use Zend\Crypt\Password\Bcrypt;
use Zend\Session\Container;
use CustomLib\Service\ApiSecurity;
use Zend\View\Model\JsonModel;

class IndexController extends CustomController
{
 /**
     * (non-PHPdoc)
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function indexAction()
    {
        return new ViewModel();
    }
    
    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function loginAction()
    {
        $timeZone = '';
        $request = $this->getRequest();
        if($request->isPost()){
            $data = $request->getPost()->toArray();
           
            $userTable = $this->getServiceLocator()->get('Application\Model\UsersTable');
            $config = $this->getServiceLocator()->get('config');
            $commonSalt = $config['settings']['COMMON_SALT'];
           
            $details = $userTable->getData('user', array('where' => array('email' => $data['email'])));
           
            if(!empty($details) && ($details[0]['user_type'] ==1)
              ){
             $secure = new ApiSecurity();
            $passwordCheck = $secure->authenticatUser($data['password'], $details[0]['password'], $commonSalt, $details[0]['algo']);
            if($passwordCheck){
                $session = new Container('User');
                $session->offsetSet('userId', $details[0]['id']);
                $session->offsetSet('userName', $details[0]['username']);
                return $this->redirect()->toUrl('/application/index/dashboard');
        } } }
        $view = new ViewModel();
        $view->setTerminal(true);
        return $view;  
    }
    
    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function dashboardAction()
    {
         $userId = $this->getLoggedInUserId();
        $userTable = $this->getServiceLocator()->get('Application\Model\UsersTable');
        $userCount = $userTable->getUserCount($userId);
        $subscriptionPlan = $userTable->getPlanCount($userId);
        $orderDetails = $userTable->getOrderCount($userId);
//        echo "<pre>";print_r($orderDetails);die;
        return new ViewModel(array('userId'=>$userCount[0]['userId'], 'subscriptionPlan'=>$subscriptionPlan[0]['planId'],'orderDetails'=>$orderDetails[0]['orderId']));
    }
    
    
    
    /**
     * 
     * @return Ambigous <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>
     */
    public function logoutAction()
    {
        $session = new Container('User');
        $session->getManager()->destroy();
        return $this->redirect()->toUrl('/application/index/login');
    }
    
    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function userlistAction()
    {
        return new ViewModel();
    }
    
    /**
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function getDashboardDataAction()
    {
        $userId = $this->getLoggedInUserId();
        $userTable = $this->getServiceLocator()->get('Application\Model\UsersTable');
        $result = $userTable->getActiveFos($stateId);
        $totalRel = $userTable->getTotalRelators($stateId);
        $actRel = $userTable->getTotalRelators($stateId,'1');
        return new JsonModel(array(
            'status' => 0,
            'activeFos' => isset($result[0]['activeFos']) ? $result[0]['activeFos'] : 0,
            'ttlRtl' => isset($totalRel[0]['ttlRtl']) ? $totalRel[0]['ttlRtl'] :0,
            'ttlActRel' => isset($actRel[0]['ttlRtl']) ? $actRel[0]['ttlRtl'] :0
        ));
    }
    
    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function uploadLogoAction()
    {
        return new ViewModel();
    }
    
    /**
     * 
     * @return \Zend\View\Model\JsonModel
     */
//    public function imageUploadAction()
//    {
//        $request = $this->getRequest();
//        $files = $request->getFiles()->toArray();
//        $data = $request->getPost()->toArray();
//        $width = 0;
//        $height = 0;
//        $config = $this->getServiceLocator()->get("config");
//        $destination = $config["settings"]['S3BUCKET']["TEMPPATH"];
//        $s3Url = $config["settings"]['S3BUCKET']['BUCKETURL'];
//        $adapter = new \Zend\File\Transfer\Adapter\Http();
//        $adapter->setDestination($destination);
//        if ($adapter->receive()) {
//            foreach ($files as $fileKey => $fileData) {
//                
//                $fileExt = explode('.', $fileData['name']);
//            $currentFileName = $destination . "/" . $fileData['name'];
//            $neoFileName = uniqid('logo_') . "." . end($fileExt);
//            $newFileName = $destination . "/" . $neoFileName;
////             move_uploaded_file($currentFileName, $newFileName);
////            echo '<pre>'; print_r($fileData);  die('df');
//            $retslt = system('mv "' . $currentFileName . '" "' . $newFileName . '"');
//                $centerImage = $this->centerImage($destination, $neoFileName);
//                $resizeImage340 = $this->reSizeImage($destination, $centerImage, 600, 340);
//        
//                $status = $this->putIntoS3Bucket($destination . '340_'.$resizeImage340, $resizeImage340);
//                $status = $this->putIntoS3Bucket($newFileName, $neoFileName);
//                if ($status) {
//                    unlink($newFileName);
//                }
//            }
//        } else {
//            print_r($adapter->getErrors());
//        }
//        
//        return new JsonModel(array(
//            'url' => $s3Url . $neoFileName,
//            'realImage' => $neoFileName . "####" . $resizeImage340,
//            'width' => $width,
//            'height' => $height
//        ));
//    }
    
    /**
     * 
     * @param array $data
     */
//    private function _getStateList($data = array()){
//        $loginTable = $this->getServiceLocator()->get('Retailers\Model\RetailersTable');
//        $results = $loginTable->getData('state_master',array('where' => array('country_id' => 95, 'status' =>0)));
//        $dropDown = array();
//        $dropDown[''] = '- Select State -';
//        foreach ($results as $val){
//            if(!empty($val['name'])){
//                $dropDown[$val['id']] = $val['name'];
//            }
//        }
//        return $dropDown;
//    }
    
}
