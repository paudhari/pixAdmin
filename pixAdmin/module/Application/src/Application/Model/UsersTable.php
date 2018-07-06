<?php

namespace Application\Model;

use Zend\Db\Sql\Sql;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Predicate\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Predicate\PredicateSet;
use Zend\Db\Sql\Predicate\Like;
use CustomLib\Model\CustomTable;
use Zend\Db\Sql\Insert;

class UsersTable extends CustomTable
{
    public $table = 'user';
    public $userProfile = 'user_profile';
    public $profileType = 'master_profile_type';
   
    
    /**
     *
     * @param array $data            
     */
    public function userRegister(array $data)
    {
        $this->insert($data);
        return $this->lastInsertValue;
    }
    
    public function getProfileDescription($profileType){
         $sql = new Sql($this->adapter);
        $select = $sql->select(array('t1' => $this->profileType));
        $select->columns(array(
            'profileDescription'=> new Expression('IF(t1.description IS NOT NULL,t1.description,"")'),
            ));
        
         $select->where(array('id' => $profileType));
        $smt = $sql->prepareStatementForSqlObject($select);
        $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
        return $result;
        
        
    }
    
    public function getUserCount($userId){
        $sql = new Sql($this->adapter);
        $select = $sql->select(array('t1' => 'user'));
        $select->columns(array(
            'userId'=> new Expression('count(t1.id)'),
            ));
         $select->where(array('t1.id !=' .$userId));
        $smt = $sql->prepareStatementForSqlObject($select);
        $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
        return $result; 
    }
    
    public function getPlanCount($userId){
        $sql = new Sql($this->adapter);
        $select = $sql->select(array('t1' => 'add_plan'));
        $select->columns(array(
            'planId'=> new Expression('count(t1.id)'),
            ));
         $select->where(array('t1.created_by=' .$userId.' AND t1.status = 1'));
        $smt = $sql->prepareStatementForSqlObject($select);
        $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
        return $result; 
    }
    
    public function getOrderCount($userId){
        $sql = new Sql($this->adapter);
        $select = $sql->select(array('t1' => 'images_order_details'));
        $select->columns(array(
            'orderId'=> new Expression('count(t1.id)'),
            ));
         $select->where(array('t1.user_id !=' .$userId.' AND t1.status = 1'));
        $smt = $sql->prepareStatementForSqlObject($select);
        $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
        return $result; 
    }
    
    
    
    
    
    /**
     * 
     * @param unknown $data
     * @param string $paging
     * @return \Zend\Paginator\Paginator|unknown
     */
//    public function fetchAllExcutive($data = array(), $orderBy = '', $paging = false)
//    {
//        $sql = new Sql($this->adapter);
//        $select = $sql->select(array('usr' => $this->table));
//        $select->columns(array(
//            'userId' => 'id',
//            'userName' => 'username',
//            'email' => new Expression('IF(usr.email IS NOT NULL,usr.email,"")'),
//            'partnerId' => new Expression('IF(usr.partner_id IS NOT NULL,usr.partner_id,"")'),
//            'mobileNumber' => new Expression('IF(usr.mobile_number IS NOT NULL,usr.mobile_number,"")'),
//            'isActive' => new Expression('IF(usr.is_active IS NOT NULL,usr.is_active,"0")'),
//            'usrCategoryId' => new Expression('IF(usr.user_type IS NOT NULL,usr.user_type,"0")'),
//            'usrRoleId' => new Expression('IF(usr.user_role IS NOT NULL,usr.user_role,"0")'),
//            'status'
//        ));
//        
//        $select->join(array('profile' => $this->userProfile), 'profile.user_id = usr.id',
//            array(
//                'firstName' => new Expression('IF(profile.first_name IS NOT NULL,profile.first_name,"")'),
//                'lastName' => new Expression('IF(profile.last_name IS NOT NULL,profile.last_name,"")'),
//                'startDate' => new Expression('IF(profile.start_date IS NOT NULL,profile.start_date,"")'),
//                'profileImage' => new Expression('IF(profile.profile_pic IS NOT NULL,profile.profile_pic,"")'),
//            ),'LEFT');
//        
//        $select->join(array('userType' => 'user_type'), 'userType.type_id = usr.user_type',
//            array(
//                'userTypeName' => new Expression('IF(userType.name IS NOT NULL,userType.name,"")'),
//            ),'LEFT');
//        
//        $select->join(array('stateTable' => 'state_master'), 'stateTable.id = profile.area_of_operation',
//            array(
//                'stateName' => new Expression('IF(stateTable.name IS NOT NULL,stateTable.name,"")'),
//            ),'LEFT');
//        $select->join(array('usrCat' => 'user_type'), 'usrCat.type_id = usr.user_type',
//            array(
//                'usrCategory' => new Expression('IF(usrCat.name IS NOT NULL,usrCat.name,"")'),
//            ),'LEFT');
//        $select->join(array('usrRol' => 'master_roles'), 'usrRol.id = usr.user_role',
//            array(
//                'usrRole' => new Expression('IF(usrRol.role_name IS NOT NULL,usrRol.role_name,"")'),
//            ),'LEFT');
//        
//        
//        $select->where(array('usr.user_type NOT IN(0,2,6)'));
//        $select->where(array('usr.status != 4'));
//        
//        if(isset($data['searchText']) && !empty($data['searchText'])){
//            $select->where(array('(usr.email like "%'.trim($data['searchText']).'%" 
//                or usr.mobile_number like "%'.trim($data['searchText']).'%" or usr.partner_id like "%'.trim($data['searchText']).'%" )'));
//        }
//        if(isset($data['stateId']) && !empty($data['stateId'])){
//            $select->where(array('profile.area_of_operation' => $data['stateId']));
//        }
//        if(isset($data['userTypeId']) && !empty($data['userTypeId'])){
//            $select->where(array('usr.user_type' => $data['userTypeId']));
//        }
//        
//        if (!empty($orderBy)) {
//                $select->order($orderBy);
//            }
//        
////          $smt = $sql->prepareStatementForSqlObject($select);
////         echo '<pre>'; print_r($smt->getSql()); die;
//        if($paging) {
//            $dbAdapter = new DbSelect ( $select, $this->getAdapter () );
//            $paginator = new Paginator ( $dbAdapter );
//            return $paginator;
//        }else {
//            $smt = $sql->prepareStatementForSqlObject($select);
//            $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
//            return $result;
//        }
//    }
//    
//    /**
//     * 
//     * @param number $userId
//     * @return unknown
//     */
//    public function getUserDetailById($userId = 0)
//    {
//        $sql = new Sql($this->adapter);
//        $select = $sql->select(array('usr' => $this->table));
//        $select->columns(array(
//            'fosId' => 'id',
//            'userName' => 'username',
//            'email' => new Expression('IF(usr.email IS NOT NULL,usr.email,"")'),
//            'mobileNumber' => new Expression('IF(usr.mobile_number IS NOT NULL,usr.mobile_number,"")'),
//            'isActive' => new Expression('IF(usr.is_active IS NOT NULL,usr.is_active,"0")'),
//            'usrCategoryId' => new Expression('IF(usr.user_type IS NOT NULL,usr.user_type,"0")'),
//            'usrRoleId' => new Expression('IF(usr.user_role IS NOT NULL,usr.user_role,"0")'),
//            'status'
//        ));
//        
//        $select->join(array('profile' => $this->userProfile), 'profile.user_id = usr.id',
//            array(
//                'firstName' => new Expression('IF(profile.first_name IS NOT NULL,profile.first_name,"")'),
//                'lastName' => new Expression('IF(profile.last_name IS NOT NULL,profile.last_name,"")'),
//                'startDate' => new Expression('IF(profile.start_date IS NOT NULL,profile.start_date,"")'),
//                'profileImage' => new Expression('IF(profile.profile_pic IS NOT NULL,profile.profile_pic,"")'),
//                'aoo' => new Expression('IF(profile.area_of_operation IS NOT NULL,profile.area_of_operation,"")'),
//                'startDate' => new Expression('IF(profile.start_date IS NOT NULL,profile.start_date,"")'),
//            ),'LEFT');
//        
//        $select->join(array('stateTable' => 'state_master'), 'stateTable.id = profile.area_of_operation',
//            array(
//                'stateName' => new Expression('IF(stateTable.name IS NOT NULL,stateTable.name,"")'),
//            ),'LEFT');
//        $select->join(array('usrCat' => 'user_type'), 'usrCat.type_id = usr.user_type',
//            array(
//                'usrCategory' => new Expression('IF(usrCat.name IS NOT NULL,usrCat.name,"")'),
//            ),'LEFT');
//        $select->join(array('usrRol' => 'user_roles'), 'usrRol.id = usr.user_role',
//            array(
//                'usrRole' => new Expression('IF(usrRol.name IS NOT NULL,usrRol.name,"")'),
//            ),'LEFT');
//        $select->where(array('usr.id' => $userId));
//        $select->where(array('usr.status != 4'));
//        $smt = $sql->prepareStatementForSqlObject($select);
//        $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
//        return $result;
//    }
//    
//   /**
//    * 
//    * @return unknown
//    */
//   public function getActiveFos($stateId)
//    {
//        $sql = new Sql($this->adapter);
//        $select = $sql->select(array('usr' => $this->table));
//        $select->columns(array(
//            'activeFos' => new Expression('COUNT(usr.id)'),
//        ));
//        $select->join(array('fosAdd' => $this->userProfile),'fosAdd.user_id = usr.id',
//                array(),'LEFT');
//        $select->where(array('usr.is_active' => 1, 'usr.user_type' =>1, 'usr.status != 4'));
//        $select->where(array('fosAdd.area_of_operation' => $stateId));
//        $smt = $sql->prepareStatementForSqlObject($select);
//        $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
//        return $result;
//    }
//    
//    /**
//     *
//     * @return unknown
//     */
//    public function getTotalRelators($stateId, $ttlType = 0)
//    {
//        $sql = new Sql($this->adapter);
//        $select = $sql->select(array('usr' => $this->table));
//        $select->columns(array(
//            'ttlRtl' => new Expression('COUNT(usr.id)'),
//        ));
//        $select->join(array('retailerAdd' => $this->retailerAddress),'retailerAdd.user_id = usr.id',
//                array(),'LEFT');
//        $select->where(array('usr.user_type' => 2));
//        if($ttlType >0){
//            $select->where(array('usr.is_active' => 1, 'usr.user_type' => 2, 'usr.is_block' => 0));
//        }
//        $select->where(array('usr.status != 4'));
//        $select->where(array('retailerAdd.permanent_state' => $stateId));
//        $smt = $sql->prepareStatementForSqlObject($select);
//        $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
//        return $result;
//    }
    
    /**
     *
     * @return Ambigous <multitype:, multitype:unknown NULL >
     */
    public function getUserTypesList()
    {
        $sql = new Sql($this->getAdapter());
        $select = new Select();
        $select->from(array('t1' => 'user'));
         $select->join(array('t2' => $this->userProfile), 't1.id = t2.user_id',
            array(
                'userId' => new Expression('IF(t2.user_id IS NOT NULL,t2.user_id,"")'),
                'firstName' => new Expression('IF(t2.first_name IS NOT NULL,t2.first_name,"")'),
                'lastName' => new Expression('IF(t2.last_name IS NOT NULL,t2.last_name,"")'),
                'primaryAddress' => new Expression('IF(t2.primary_address IS NOT NULL,t2.primary_address,"")'),
                'secondaryAddress' => new Expression('IF(t2.secondary_address IS NOT NULL,t2.secondary_address,"")'),
                'city' => new Expression('IF(t2.city IS NOT NULL,t2.city,"")'),
                'state' => new Expression('IF(t2.state IS NOT NULL,t2.state,"")'),
                'postalCode' => new Expression('IF(t2.postal_code IS NOT NULL,t2.postal_code,"")'),
                'country' => new Expression('IF(t2.country IS NOT NULL,t2.country,"")'),
                'url' => new Expression('IF(t2.url IS NOT NULL,t2.url,"")'),
                
            ),'LEFT');
        $select->where(array('t1.status !=2 AND t1.user_type !=1'));
//        $select->limit(10);
        $statement = $sql->prepareStatementForSqlObject($select);
        $loginDetails = $this->getResultSetPrototype()->initialize(
            $statement->execute())->toArray();
        return $loginDetails;
    }
    public function getUserOrderTypesList($data)
    {
        $sql = new Sql($this->getAdapter());
        $select = new Select();
        $select->from(array('t1' => 'user'));
         $select->join(array('t2' => $this->userProfile), 't1.id = t2.user_id',
            array(
                'firstName' => new Expression('IF(t2.first_name IS NOT NULL,t2.first_name,"")'),
                'lastName' => new Expression('IF(t2.last_name IS NOT NULL,t2.last_name,"")'),
            ),'LEFT');
         $select->join(array('t3' => 'user_payment_details'),new Expression('t1.id = t3.user_id'),
            array(
                'orderId' => new Expression('IF(t3.id IS NOT NULL,t3.id,"")'),
                'transactionId' => new Expression('IF(t3.transaction_id IS NOT NULL,t3.transaction_id,"")'),
                'amount' => new Expression('IF(t3.amount IS NOT NULL,t3.amount,"")'),
                 'createdOn' => new Expression('IF(t3.created_on IS NOT NULL,t3.created_on,"")'),
            ),'INNER');
         $select->join(array('t4' => 'order_details'),new Expression('t3.order_id = t4.id'),
            array(
                'planId' => new Expression('IF(t4.plan_id IS NOT NULL,t4.plan_id,"")'),
               
            ),'LEFT');
         $select->join(array('t5' => 'add_plan'),new Expression('t4.plan_id = t5.id'),
            array(
                'planName' => new Expression('IF(t5.plan_name IS NOT NULL,t5.plan_name,"")'),
                'noOfImages' => new Expression('IF(t5.	no_of_images IS NOT NULL,t5.	no_of_images,"")'),
                'price' => new Expression('IF(t5.price IS NOT NULL,t5.price,"")'),
                'currency' => new Expression('IF(t5.currency IS NOT NULL,t5.currency,"")'),
               
            ),'LEFT');
        $select->where(array('t3.status !=2 AND t1.user_type !=1'));
        
         if(isset($data['searchText']) && !empty($data['searchText'])){
            $select->where(array('(email like "%'.trim($data['searchText']).'%" 
                or first_name like "%'.trim($data['searchText']).'%" or last_name like "%'.trim($data['searchText']).'%" )'));
        }
        
        
//      $select->group(array('t1.id'));
        $select->order(array('t3.created_on DESC'));
        $statement = $sql->prepareStatementForSqlObject($select);
        $loginDetails = $this->getResultSetPrototype()->initialize(
        $statement->execute())->toArray();
        return $loginDetails;
    }
    
    
     public function getUserOrderList()
    {
        $sql = new Sql($this->getAdapter());
        $select = new Select();
        $select->from(array('t1' => 'user'));
         $select->join(array('t2' => $this->userProfile), 't1.id = t2.user_id',
            array(
                'userId' => new Expression('IF(t2.user_id IS NOT NULL,t2.user_id,"")'),
                'firstName' => new Expression('IF(t2.first_name IS NOT NULL,t2.first_name,"")'),
                'lastName' => new Expression('IF(t2.last_name IS NOT NULL,t2.last_name,"")'),
                'primaryAddress' => new Expression('IF(t2.primary_address IS NOT NULL,t2.primary_address,"")'),
                'secondaryAddress' => new Expression('IF(t2.secondary_address IS NOT NULL,t2.secondary_address,"")'),
                'city' => new Expression('IF(t2.city IS NOT NULL,t2.city,"")'),
                'state' => new Expression('IF(t2.state IS NOT NULL,t2.state,"")'),
                'postalCode' => new Expression('IF(t2.postal_code IS NOT NULL,t2.postal_code,"")'),
                'country' => new Expression('IF(t2.country IS NOT NULL,t2.country,"")'),
                'url' => new Expression('IF(t2.url IS NOT NULL,t2.url,"")'),
            ),'LEFT');
         $select->join(array('t3' => 'images_order_details'),new Expression('t1.id = t3.user_id'),
            array(
                'orderId' => new Expression('IF(t3.id IS NOT NULL,t3.id,"")'),
                'orderNo' => new Expression('IF(t3.order_no IS NOT NULL,t3.order_no,"")'),
                'orderCount' => new Expression('IF(t3.count IS NOT NULL,t3.count,"")'),
                'inmate_id' => new Expression('IF(t3.inmate_id IS NOT NULL,t3.inmate_id,"")'),
                'createdOn' => new Expression('IF(t3.created_on IS NOT NULL,t3.created_on,"")'),
            ),'INNER');

        $select->where(array('t1.status !=2 AND t1.user_type !=1'));
//        $select->group(array('t1.id'));
        $select->order(array('t3.created_on DESC'));
        $statement = $sql->prepareStatementForSqlObject($select);
        $loginDetails = $this->getResultSetPrototype()->initialize(
            $statement->execute())->toArray();
        return $loginDetails;
    }
    
    
    
    
    /**
     * 
     * @param string $userType
     */
//    public function getUserListDropDown($userType='', $stateId='')
//    {
//        $sql = new Sql($this->getAdapter());
//        $select = new Select();
//        $select->from(array('usr' => 'users'));
//        $select->columns(array(
//            'userId' => 'id',
//            'userMobile' => new Expression('IF(usr.mobile_number IS NOT NULL,usr.mobile_number,"")'),
//            'userEmail' => new Expression('IF(usr.email IS NOT NULL,usr.email,"")'),
//        ));
//        
//        $select->join(array('profile' => $this->userProfile), 'profile.user_id = usr.id',
//            array(
//                'firstName' => new Expression('IF(profile.first_name IS NOT NULL,profile.first_name,"")'),
//                'lastName' => new Expression('IF(profile.last_name IS NOT NULL,profile.last_name,"")'),
//            ),'LEFT');
//        
//        $select->where(array('usr.user_type' => $userType,'usr.is_active' => 1));
//        if(!empty($stateId)){
//            $select->where(array('profile.area_of_operation' => $stateId));
//        }
//        $select->where(array('usr.status !=4'));
//        $statement = $sql->prepareStatementForSqlObject($select);
//        //        echo $statement->getSql();die;
//        $userDetails = $this->getResultSetPrototype()->initialize(
//            $statement->execute())->toArray();
//        $usrArr = array();
//        if(!empty($userDetails)){
//            foreach ($userDetails as $val){
//                $usrArr[$val['userId']] = $val['firstName'].' '.$val['lastName']; 
//            }
//        }
//        
//            return $usrArr;
//    }
//    
//    /**
//     * 
//     * @param array $data
//     * @param string $orderBy
//     * @param string $paging
//     * @return \Zend\Paginator\Paginator|unknown
//     */
//    public function fetchAllAttendance($data = array(), $orderBy = '', $paging = false)
//    {
//        $sql = new Sql($this->adapter);
//        $select = $sql->select(array('usr' => 'user_attendance'));
//        $select->columns(array(
//            'userId' => 'user_id',
//            'punchIn' => 'punch_in',
//            'picUrl' => new Expression('IF(usr.pic_url_1 IS NOT NULL,usr.pic_url_1,"")'),
//            'latitude' => new Expression('IF(usr.latitude IS NOT NULL,usr.latitude,"")'),
//            'longitude' => new Expression('IF(usr.longitude IS NOT NULL,usr.longitude,"")'),
//        ));
//        
//        $select->join(array('profile' => $this->userProfile), 'profile.user_id = usr.user_id',
//            array(
//                'firstName' => new Expression('IF(profile.first_name IS NOT NULL,profile.first_name,"")'),
//                'lastName' => new Expression('IF(profile.last_name IS NOT NULL,profile.last_name,"")'),
//            ),'LEFT');
//        $select->join(array('user' => $this->table), 'profile.user_id = user.id',
//            array(
//                'email' => new Expression('IF(user.email IS NOT NULL,user.email,"")'),
//                'mobile' => new Expression('IF(user.mobile_number IS NOT NULL,user.mobile_number,"")'),
//            ),'LEFT');
//        
//        $select->join(array('stateTable' => 'state_master'), 'stateTable.id = profile.area_of_operation',
//            array(
//                'stateName' => new Expression('IF(stateTable.name IS NOT NULL,stateTable.name,"")'),
//            ),'LEFT');
//        
//        
//        
////         $select->where(array('usr.user_type != 2'));
//        $select->where(array('user.status != 4'));
//        
//        if(isset($data['searchText']) && !empty($data['searchText'])){
//            $select->where(array('(user.email like "%'.trim($data['searchText']).'%" or user.mobile_number like "%'.trim($data['searchText']).'%" )'));
//        }
//        if(isset($data['currentDate']) && !empty($data['currentDate'])){
//            $select->where(array('usr.punch_in >= "'.$data['currentDate'].' 00:00:01" AND usr.punch_in <= "'.$data['currentDate'].' 23:58:59"'));
//        } else {
//            
//            $sDate = date("Y-m-d");
//            
//            $select->where(array('date_format(usr.punch_in,"%Y-%m-%d") = "'.$sDate.'"'));
//        }
//        
//        if(isset($data['stateId']) && !empty($data['stateId'])){
//            $select->where(array('profile.area_of_operation' => $data['stateId']));
//        }
//        if (!empty($orderBy)) {
//            $select->order($orderBy);
//        }
////         $smt = $sql->prepareStatementForSqlObject($select);
////         echo '<pre>'; print_r($smt->getSql()); die;
//        $select->group(array('usr.user_id'));
//        $select->order(array('punchIn DESC'));
//        if($paging) {
//            $dbAdapter = new DbSelect ( $select, $this->getAdapter () );
//            $paginator = new Paginator ( $dbAdapter );
//            return $paginator;
//        }else {
//            $smt = $sql->prepareStatementForSqlObject($select);
//            $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
//            return $result;
//        }
//    }
//    
//    /**
//     * Get All Notifications
//     * @param array $data
//     * @return array
//     */
//    public function getUserDevice($userId = 0)
//    {
//        
//        $sql = new Sql($this->getAdapter());
//        $select = new Select();
//        $select->from(array('t1' => 'session'));
//        $select->columns(array(
//            'id' => 'id',
//            'deviceId' => new Expression('IF(t1.device_id IS NOT NULL,t1.device_id,"")'),
//        ));
//
//        $select->where(array("t1.user_id" => $userId));
//        
//        $select->order(array('t1.id desc'));
//        
//        $select->limit(1);
//        $statement = $sql->prepareStatementForSqlObject($select);
////                echo $statement->getSql();die;
//        $loginDetails = $this->getResultSetPrototype()->initialize(
//            $statement->execute())->toArray();
//        return $loginDetails;
//        
//        
//    }
//    
//    /* used to mark log of every notifications like SMS/Email/Push */
//
//    public function insertNotifications($data = array()) {
//        
////        $adapter = $this->tableGateway->getAdapter();
//        $sql = new Sql($this->getAdapter());
//
//       // $sql = new Sql($adapter);
//
//        $strUsers = new Insert('notifications');
//        $strUsers->values($data);
//
//        $selectString = $sql->prepareStatementForSqlObject($strUsers)->execute()->getAffectedRows();
//        $lastInsertValue = $this->tableGateway->getAdapter()->getDriver()->getConnection()->getLastGeneratedValue();
//        return $lastInsertValue;
//    }
    
    public function getUserImagesList($userId,$orderId){
         $sql = new Sql($this->getAdapter());
        $select = new Select();
        $select->from(array('t1' => 'assets'));
         $select->columns(array(
            'Id'=> new Expression('IF(t1.id IS NOT NULL,t1.id,"")'),
            'fileOriginalName'=> new Expression('IF(t1.file_original_name IS NOT NULL,t1.file_original_name,"")'),
            'fileUrl'=> new Expression('IF(t1.url IS NOT NULL,t1.url,"")'),
            'createdBy'=> new Expression('IF(t1.created_by IS NOT NULL,t1.created_by,"")'),
            'createdOn'=> new Expression('IF(t1.created_on IS NOT NULL,t1.created_on,"")'),
            ));
        $select->where(array('t1.created_by='.$userId. ' AND t1.order_id='.$orderId));
         $select->order(array('t1.created_on DESC'));
        $statement = $sql->prepareStatementForSqlObject($select);
//        echo "<pre>";print_r($statement);die;
        $loginDetails = $this->getResultSetPrototype()->initialize(
            $statement->execute())->toArray();
        return $loginDetails;
    }
    
    public function getUserFullDetails($userId){
         $sql = new Sql($this->getAdapter());
        $select = new Select();
        $select->from(array('t1' => 'user'));
         $select->columns(array(
            'Id'=> new Expression('IF(t1.id IS NOT NULL,t1.id,"")'),
            'email'=> new Expression('IF(t1.email IS NOT NULL,t1.email,"")'),
            ));
          $select->join(array('t2' => $this->userProfile), 't1.id = t2.user_id',
            array(
               
                'firstName' => new Expression('IF(t2.first_name IS NOT NULL,t2.first_name,"")'),
                'lastName' => new Expression('IF(t2.last_name IS NOT NULL,t2.last_name,"")'),
                'primaryAddress' => new Expression('IF(t2.primary_address IS NOT NULL,t2.primary_address,"")'),
                'secondaryAddress' => new Expression('IF(t2.secondary_address IS NOT NULL,t2.secondary_address,"")'),
                'city' => new Expression('IF(t2.city IS NOT NULL,t2.city,"")'),
                'state' => new Expression('IF(t2.state IS NOT NULL,t2.state,"")'),
                'postalCode' => new Expression('IF(t2.postal_code IS NOT NULL,t2.postal_code,"")'),
                'country' => new Expression('IF(t2.country IS NOT NULL,t2.country,"")'),
                'url' => new Expression('IF(t2.url IS NOT NULL,t2.url,"")'),
            ),'LEFT');
          $select->join(array('t3' => 'user_billing_details'), 't1.id = t3.user_id',
            array(
                'billingAddressLabel' => new Expression('IF(t3.billing_address_label IS NOT NULL,t3.billing_address_label,"")'),
                'billingAddressPrimary' => new Expression('IF(t3.billing_address_primary IS NOT NULL,t3.billing_address_primary,"")'),
                'billingAddressScondary' => new Expression('IF(t3.billing_address_secondary IS NOT NULL,t3.billing_address_secondary,"")'),
                'billingCity' => new Expression('IF(t2.city IS NOT NULL,t2.city,"")'),
                'billingState' => new Expression('IF(t3.state IS NOT NULL,t3.state,"")'),
                'billingPostalCode' => new Expression('IF(t3.postal_code IS NOT NULL,t3.postal_code,"")'),
                'billingCountry' => new Expression('IF(t3.country IS NOT NULL,t3.country,"")'),
            ),'LEFT');
          $select->join(array('t4' => 'user_security_details'), 't1.id = t4.user_id',
            array(
                'securityPin' => new Expression('IF(t4.security_pin IS NOT NULL,t4.security_pin,"")'),
                'securityPinVerify' => new Expression('IF(t4.security_pin_verify IS NOT NULL,t4.security_pin_verify,"")'),
                'transactionPin' => new Expression('IF(t4.transaction_pin IS NOT NULL,t4.transaction_pin,"")'),
            ),'LEFT');
          $select->join(array('t5' => 'user_recovery_details'), 't1.id = t5.user_id',
            array(
                'secondaryEmail' => new Expression('IF(t5.secondary_email IS NOT NULL,t5.secondary_email,"")'),
                'securityQuestion1' => new Expression('IF(t5.security_question_1 IS NOT NULL,t5.security_question_1,"")'),
                'Answer1' => new Expression('IF(t5.answer_1 IS NOT NULL,t5.answer_1,"")'),
                'securityQuestion2' => new Expression('IF(t5.security_question_2 IS NOT NULL,t5.security_question_2,"")'),
                'Answer2' => new Expression('IF(t5.answer_2 IS NOT NULL,t5.answer_2,"")'),
            ),'LEFT');
        $select->where(array('t1.id='.$userId));
        $statement = $sql->prepareStatementForSqlObject($select);
        $loginDetails = $this->getResultSetPrototype()->initialize(
            $statement->execute())->toArray();
        return $loginDetails; 
    }
    
    public function getPlanDetails($planId){
        $sql = new Sql($this->adapter);
        $select = $sql->select(array('t1' => 'add_plan'));
        $select->columns(array(
            'planName'=> new Expression('IF(t1.plan_name IS NOT NULL,t1.plan_name,"")'),
            'quantity'=> new Expression('IF(t1.no_of_images IS NOT NULL,t1.no_of_images,"")'),
            'price'=> new Expression('IF(t1.price IS NOT NULL,t1.price,"")'),
            'currency'=> new Expression('IF(t1.currency IS NOT NULL,t1.currency,"")'),
            ));
        
        $select->where('id ='.$planId);
        $smt = $sql->prepareStatementForSqlObject($select);
        
        $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
        return $result;
    }
 
    public function getUserPlanDetails($userId){
         $sql = new Sql($this->adapter);
        $select = $sql->select(array('t1' => 'user_purchase_plan'));
        $select->columns(array(
            'id'=> new Expression('IF(t1.id IS NOT NULL,t1.id,"")'),
            'planId'=> new Expression('IF(t1.plan_id IS NOT NULL,t1.plan_id,"")'),
            'createdOn'=> new Expression('IF(t1.created_on IS NOT NULL,t1.created_on,"")'),
           ));
           $select->join(array('t2' => 'add_plan'), 't1.plan_id = t2.id',
            array(
            'planName'=> new Expression('IF(t2.plan_name IS NOT NULL,t2.plan_name,"")'),
            'quantity'=> new Expression('IF(t2.no_of_images IS NOT NULL,t2.no_of_images,"")'),
            'price'=> new Expression('IF(t2.price IS NOT NULL,t2.price,"")'),
            'currency'=> new Expression('IF(t2.currency IS NOT NULL,t2.currency,"")'),
            ),'LEFT');
         $select->order(array('t1.id DESC'));
         $select->where(array('t1.created_by' => $userId));
        $smt = $sql->prepareStatementForSqlObject($select);
        $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
        return $result;
    }
    
     public function getPlansDetails($userId){
        $sql = new sql($this->adapter);
        $select = new select(array('t1' => 'user_purchase_plan'));
         $select->columns(array(
            'planId' => new Expression('IF(t1.id IS NOT NULL,t1.id,"")'),
        ));
         $select->join(array('t2' => 'add_plan'), new Expression('t1.plan_id = t2.id'), array(
            'planName' => new Expression('IF(t2.plan_name IS NOT NULL,t2.plan_name,"")'),
            'noOfImages' => new Expression('IF(t2.no_of_images IS NOT NULL, t2.no_of_images,"")'),
            'price' => new Expression('IF(t2.price IS NOT NULL, t2.price,"")'),
                ), 'LEFT');
         $select->group('t1.id');
        $select->where(array('t1.created_by' => $userId));
        $select->order('t1.created_on DESC');
        $smt = $sql->prepareStatementForSqlObject($select);
        $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
        return $result;
    }
    
     public function getImageCountDetails($userId){
       
         $sql = new sql($this->adapter);
        $select = new select(array('t1' => 'assets'));
        $select->columns(array(
            'imageId' => new Expression('Count(t1.id)'),
        ));
        $select->where(array('t1.created_by'=> $userId));
        $smt = $sql->prepareStatementForSqlObject($select);
        $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
        return $result;
    }
    
    
    
}
