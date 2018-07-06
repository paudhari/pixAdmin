<?php

//

namespace Subscription\Controller;

use CustomLib\Controller\CustomController;
use Zend\View\Model\ViewModel;
use Zend\Crypt\Password\Bcrypt;
use Zend\View\Model\JsonModel;
use CustomLib\Service\ApiSecurity;
use Subscription\Form\SubscriptionForm;
use Users\Form\AddCreditForm;
use Zend\View\View;
use Zend\Session\Container;
use CustomLib\Service\UserPassword;

/**
 * 
 * @author adminuser
 *
 */
class SubscriptionController extends CustomController {

    protected $_usersTable;

    /**
     * indexAction
     * @return ViewModel
     */
    public function indexAction() {
        return new ViewModel();
    }

    /**
     * addPlanAction
     * @return ViewModel
     */
    public function addPlanAction() {
        $getConfig = $this->getServiceLocator()->get('config');
        $subscriptionTable = $this->getServiceLocator()->get('Subscription\Model\SubscriptionTable');
        $logedInId = $this->getLoggedInUserId();
        $form = new SubscriptionForm();
        $request = $this->getRequest();
       
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
           
            $plan = array();
            $plan['plan_name'] = $data['planName'];
            $plan['no_of_images'] = $data['noOfImages'];
            $plan['price'] = $data['price'];
            $plan['currency'] = 'USD';
            $plan['status'] = '1';
            $plan['created_by'] = $logedInId;
            $plan['created_on'] = time();
            $addPlanId = $subscriptionTable->saveData('add_plan', $plan);
        }
        return new ViewModel(array('form' => $form));
    }

    /**
     * getPlanListAction
     * @return ViewModel
     */
    public function getPlanListAction() {
        $subscriptionTable = $this->getServiceLocator()->get('Subscription\Model\SubscriptionTable');
        $logedInId = $this->getLoggedInUserId();
        $getPlan = $subscriptionTable->getPlanData($logedInId);
        $view = new ViewModel(array('getPlan' => $getPlan,
        ));
        $view->setTerminal(true);
        return $view;
    }

    /**
     * deletePlanDetailsAction
     * @return JsonModel
     */
    public function deletePlanDetailsAction() {
        $subscriptionTable = $this->getServiceLocator()->get('Subscription\Model\SubscriptionTable');
        $request = $this->getRequest();
        $data = $request->getPost()->toArray();
        $newData = array(
            'status' => 2
        );
        $updateStatus = $subscriptionTable->updateData('add_plan', $newData, array('id' => $data['planId']));
        return new JsonModel();
    }
    
    public function editPlanAction() {
     $subscriptionTable = $this->getServiceLocator()->get('Subscription\Model\SubscriptionTable');
     $logedInId = $this->getLoggedInUserId();
     $planId = $this->params('id');
      $form = new SubscriptionForm();
      $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $updateData=array();
            $updateData['plan_name']=$data['planName'];
            $updateData['no_of_images']=$data['noOfImages'];
            $updateData['price']=$data['price'];
            $updateData['currency']='USD';
            $updateData['status']='1';
            $updateData['created_by']=$logedInId;
            $updateData['created_on']=time();
            $updatePlan=$subscriptionTable->updateData('add_plan',$updateData,array('id'=>$data['planId']) );
            return new JsonModel();
        }
        $getPlan=$subscriptionTable->getAllPlanDetails(base64_decode($planId));
       if (!empty($getPlan)) {
            $planData = array(
                'noOfImages' => $getPlan[0]['noOfImages'],
                'price' => $getPlan[0]['price'],
                'planName' =>$getPlan[0]['planName'],
            );
//           
            $form->setData($planData);
        }
         return new ViewModel(array(
            'form' => $form,
            'planId' => base64_decode($planId),
        ));
     
    }

}

?>