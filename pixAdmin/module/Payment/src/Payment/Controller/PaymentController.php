<?php //

namespace Payment\Controller;

use CustomLib\Controller\CustomController;
use Zend\View\Model\ViewModel;
use Zend\Crypt\Password\Bcrypt;
use Zend\View\Model\JsonModel;
use CustomLib\Service\ApiSecurity;
use Payment\Form\PaymentForm;
use Users\Form\AddCreditForm;
use Zend\View\View;
use Zend\Session\Container;

use CustomLib\Service\UserPassword;

/**
 * 
 * @author adminuser
 *
 */
class PaymentController extends CustomController {

    protected $_usersTable;

   
    public function indexAction() {
        return new ViewModel();
    }
    
      public function getPaymentListAction(){ 
         $loginTable = $this->getServiceLocator()->get('Application\Model\UsersTable');
         $request = $this->getRequest();
         $data = $request->getPost()->toArray();
//         echo "<pre>";print_r()
         $resultsUserTypes = $loginTable->getUserOrderTypesList($data);
//         echo "<pre>";print_r($resultsUserTypes);die;
         $view = new ViewModel(array('resultsUserTypes' => $resultsUserTypes,'userImages'=>$userImages,
            
                ));
         $view->setTerminal(true);
        return $view;
    }
//  
    public function getPlanDescriptionAction(){
       $loginTable = $this->getServiceLocator()->get('Application\Model\UsersTable');
         $request = $this->getRequest();
         $data = $request->getPost()->toArray(); 
//         echo "<pre>";print_r($data);die;
          $planDetails = $loginTable->getPlanDetails($data['planId']);
          $view = new ViewModel(array('planDetails'=> $planDetails,'planId'=>$data['planId']
               ));
         $view->setTerminal(true);
        return $view;
    }
    
    public function blockTransactionAction(){
        $loginTable = $this->getServiceLocator()->get('Application\Model\UsersTable');
        $request = $this->getRequest();
        $data = $request->getPost()->toArray();
        $newData = array(
            'status' => 2
        );
        $updateStatus = $loginTable->updateData('order_details', $newData, array('id' => $data['orderId']));
        $updateStatus = $loginTable->updateData('user_payment_details', $newData, array('order_id' => $data['orderId']));
        return new JsonModel();
    }
    
}

?>
