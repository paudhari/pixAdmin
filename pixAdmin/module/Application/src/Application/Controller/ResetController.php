<?php
namespace Application\Controller;

use CustomLib\Controller\CustomController;
use Zend\View\Model\ViewModel;
use CustomLib\Service\ApiSecurity;

/**
 * 
 * @author
 *
 */
class ResetController extends CustomController
{
    
    
    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function changePasswordAction()
    {
        
        $error = 0;
        $currentDate = gmDate('Y-m-d H:i:s');
    
        $key = filter_input(INPUT_GET, 'key');
        $hash = filter_input(INPUT_GET, 'hash');
        $unqId = filter_input(INPUT_GET, 'unq');
    
        $myhash = sha1($key.'512scdfret7rde');
//                echo $myhash.'==='.$hash.'--'.$unqId;die;
        if($myhash == $hash)
        {
            $key = base64_decode($key);
            $key = explode(".", $key);
    
            $time = gmdate('Y-m-d H:i:s',$key[1]);
    
            if($time > $currentDate)
            {
                $view = new ViewModel(array(
                    'unqId' => $unqId,
                ));
                $view->setTerminal(true);
                return $view;
            }
            else
            {
                $error = '1';
                $this->flashMessenger()->clearMessages();
                $this->flashMessenger()->addErrorMessage($this->translate("This link expired, please try again."));
            }
        }
        else
        {
            $error = '1';
            $this->flashMessenger()->clearMessages();
            $this->flashMessenger()->addErrorMessage($this->translate("This link corrupted, please try again."));
        }
        $view = new ViewModel(array('error' => $error));
        $view->setTerminal(true);
        return $view;
    }
    
    /**
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function resetPasswordAction()
    {
        $userTable = $this->getServiceLocator()->get('Application\Model\UsersTable');
        $error = array();
        $request = $this->getRequest();
        if($request->isPost())
        {
            
            $data = $request->getPost()->toArray();
            $userId = base64_decode($data['unqId']);
            $config = $this->getServiceLocator()->get('config');
            $secure = new ApiSecurity();
            $key = $secure->generateKey()->getSalt();
            $commonSalt = $config['settings']['COMMON_SALT'];
            
//     echo '<pre>'; print_r($userId); die;
            if($data['new-passwd'] == $data['cnfrm-passwd'])
            {
                $password = $data['new-passwd'];
                $data['salt'] = 'xxx';
                $data['algo'] = 'firstPwdAlgo';
                $data['password'] = $secure->firstPwdAlgo($password, $commonSalt);
                
                $arrData = array();
                $arrData['password'] = $data['password'];
                $userTable->updateData('users', $arrData, array('id' => $userId));
                $this->flashMessenger()->clearMessages();
                $this->flashMessenger()->addSuccessMessage("Password updated successfully.");
            }else{
                $this->flashMessenger()->clearMessages();
                $this->flashMessenger()->addErrorMessage("password mismatch, please enter again");
            }
        }
        $view = new ViewModel(array('error' => $error));
        $view->setTerminal(true);
        return $view;
    }
}
