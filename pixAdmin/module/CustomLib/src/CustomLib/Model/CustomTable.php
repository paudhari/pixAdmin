<?php

/**
 * Description of CustomTable
 *
 * @author adminuser
 */

namespace CustomLib\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Expression;

/**
 * Extends in other model class
 *
 * @category Admin
 * @package Model
 *         
 */
class CustomTable extends AbstractTableGateway implements
ServiceLocatorAwareInterface {

    protected $_serviceLocator;

    /**
     * Set $_serviceLocator
     *
     * @access pubic
     * @param ServiceLocatorInterface $serviceLocator
     *            // ServiceLocatorInterface instance
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->_serviceLocator = $serviceLocator;
    }

    /**
     * Get $_serviceLocator
     *
     * @access pubic
     * @return \Zend\ServiceManager\ServiceLocatorAwareInterface
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
     */
    public function getServiceLocator() {
        return $this->_serviceLocator;
    }

    /**
     * Constructor
     *
     * @access pubic
     * @param Adapter $adapter
     *            // Adapter instance
     */
    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->initialize();
    }

    /**
     * Magic Method __Call
     *
     * @access pubic
     * @param <string> $method
     *            // Method name
     * @param <array> $arguments
     *            // Arguments
     * @return <mixed>
     */
    public function __call($method, $arguments) {
        if (preg_match('/^findAllBy/', $method)) {
            $criteria = substr($method, 9);

            /*
             * $criteria =
             * strtolower($this->getServiceLocator()->get('Service\Utility')
             * ->fromCamelCase($criteria));
             */
            $criteria = strtolower($criteria);

            $criteriaArr = explode('_and_', $criteria);

            $num = 0;

            $conditions = array();

            foreach ($criteriaArr as $val) {
                $conditions[$val] = (string) $arguments[$num];
                $num++;
            }

            return $this->select($conditions)->toArray();
        }

        parent::__call($method, $arguments);
    }

    /**
     *
     * @param string $table
     * @param unknown $data
     */
    public function getData($mytable = '', $data = array()) {
        try {
            $sql = new Sql($this->adapter);
            $select = $sql->select($mytable);
            if (!empty($data['where'])) {
                $select->where($data['where']);
            }
            if (!empty($data['limit'])) {
                $select->limit($data['limit'][0])->offset((!empty($data['limit'][1])) ? $data['limit'][1] : 0);
            }
            if (!empty($data['order'])) {
                $select->order($data['order']);
            }

            $smt = $sql->prepareStatementForSqlObject($select);
            $result = $this->resultSetPrototype->initialize($smt->execute())
                    ->toArray();
            return $result;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return array();
        }
    }

    /**
     *
     * @param string $table
     * @param unknown $data
     */
    public function getDataCount($mytable = '', $data = array()) {
        try {
            $sql = new Sql($this->adapter);
            $select = $sql->select($mytable);
            $select->columns(array(
                'count' => new Expression('COUNT(id)')
            ));
            if (!empty($data['where'])) {
                $select->where($data['where']);
            }
            if (!empty($data['limit'])) {
                $select->limit($data['limit'][0])->offset((!empty($data['limit'][1])) ? $data['limit'][1] : 0);
            }
            if (!empty($data['order'])) {
                $select->order($data['order']);
            }

//             $select->group(array('id'));

            $smt = $sql->prepareStatementForSqlObject($select);
            $result = $this->resultSetPrototype->initialize($smt->execute())
                    ->toArray();
            return $result;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return array();
        }
    }

    /**
     *
     * @param string $myTable
     * @param unknown $data
     */
    public function saveData($mytable = '', $data = array()) {
        try {
            $sql = new Sql($this->adapter);
            $insert = $sql->insert($mytable);
            $insert->values($data);
            $smt = $sql->prepareStatementForSqlObject($insert);
            $this->resultSetPrototype->initialize($smt->execute());
            return $this->adapter->getDriver()->getLastGeneratedValue();
        } catch (\Exception $e) {
            echo $e->getMessage();
            return 0;
        }
    }

    /**
     *
     * @param string $myTable
     * @param unknown $data
     */
    public function updateData($mytable = '', $data = array(), $where = array()) {
        try {
            $sql = new Sql($this->adapter);
            $update = $sql->update($mytable);
            $update->set($data);
            $update->where($where);
            $smt = $sql->prepareStatementForSqlObject($update);
//               echo "<pre>";print_r($smt);die;
            $this->resultSetPrototype->initialize($smt->execute());
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     *
     * @param string $myTable
     * @param unknown $data
     */
    public function deleteData($mytable = '', $where = array()) {
        try {
            $sql = new Sql($this->adapter);
            $delete = $sql->delete($mytable);
            $delete->where($where);
            $smt = $sql->prepareStatementForSqlObject($delete);
            $this->resultSetPrototype->initialize($smt->execute());
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /*
     * function to get Count of liked post 
     */

    public function getLikedPostCount($from, $to) {
        $sql = new Sql($this->adapter);
        $select = $sql->select(array(
            't1' => 'likes'
        ));
        $select->columns(array(
            'count' => new Expression('COUNT(id)')
        ));
        $select->where(array(" t1.status=1 and date(t1.created_on)>= date('" . $from . "') and date(t1.created_on)<=date('" . $to . "')"));
        $select->order(array(
            't1.id DESC'
        ));
        $smt = $sql->prepareStatementForSqlObject($select);
        $result = $this->resultSetPrototype->initialize($smt->execute())
                ->toArray();
        return $result;
    }

    /*
     * function to get Count of liked post 
     */

    public function getDisLikedPostCount($from, $to) {
        $sql = new Sql($this->adapter);
        $select = $sql->select(array(
            't1' => 'likes'
        ));
        $select->columns(array(
            'count' => new Expression('COUNT(id)')
        ));
        $select->where(array(" t1.status=2 and date(t1.created_on)>= date('" . $from . "') and date(t1.created_on)<=date('" . $to . "')"));
        $select->order(array(
            't1.id DESC'
        ));
        $smt = $sql->prepareStatementForSqlObject($select);
        $result = $this->resultSetPrototype->initialize($smt->execute())
                ->toArray();
        return $result;
    }

    /*
     * get Total artist list
     */

    public function getTotalArtist($from, $to) {
        $sql = new Sql($this->adapter);
        $select = $sql->select(array(
            't1' => 'users'
        ));
        $select->columns(array(
            'count' => new Expression('COUNT(id)')
        ));
        $select->where(array("t1.user_type=3 and date(t1.created_on)>= date('" . $from . "') and date(t1.created_on)<=date('" . $to . "')"));

        $select->order(array(
            't1.id DESC'
        ));
        $smt = $sql->prepareStatementForSqlObject($select);
        $result = $this->resultSetPrototype->initialize($smt->execute())
                ->toArray();
        return $result;
    }

    /*
     * get Total Post list
     */

    public function getTotalPost($from, $to) {
        $sql = new Sql($this->adapter);
        $select = $sql->select(array(
            't1' => 'post'
        ));
        $select->columns(array(
            'count' => new Expression('COUNT(id)')
        ));
        $select->where(array("date(t1.created_on)>= date('" . $from . "') and date(t1.created_on)<=date('" . $to . "')"));
        $smt = $sql->prepareStatementForSqlObject($select);
        $result = $this->resultSetPrototype->initialize($smt->execute())
                ->toArray();
        return $result;
    }

    /*
     * function to get Count of liked post 
     */

    public function fncGetDropDown($arrData = array()) {
        $sql = new Sql($this->adapter);
        $select = $sql->select(array('t1' => 'code_master_values'));
        $select->columns(array(
            'codeId' => 'id',
            'name' => 'name',
        ));
        
        $select->join(array('cm' => 'code_master'), 'cm.id = t1.code_master_id',
            array(
                'codeMaster' => new Expression('IF(cm.name IS NOT NULL,cm.name,"")'),
            ),'LEFT');
        
        $select->where(array('t1.status =0',
            'cm.id'=>$arrData["codeMaster"]
            ));
        $select->order(array('t1.id ASC'));
        
        $smt = $sql->prepareStatementForSqlObject($select);
//        echo $smt->getSql();die;
        $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
        $resultArr = array();
        $resultArr[''] = '';
        if(!empty($result)){
            foreach ($result as $key => $val){
                   $resultArr[$val['codeId']] = $val['name'];
            }
             
        }
        return $resultArr;
    }
    
    /**
     * 
     * @return multitype:string unknown
     */
    public function getModuleDropDown()
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select(array('t1' => 'modules'));
        $select->columns(array(
            'moduleId' => 'id',
            'name' => 'name',
        ));
        
        $select->where(array('t1.status = 0'));
        $select->order(array('t1.name ASC'));
        
        $smt = $sql->prepareStatementForSqlObject($select);
        $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
        $resultArr = array();
        $resultArr[''] = '';
        if(!empty($result)){
            foreach ($result as $key => $val){
                $resultArr[$val['moduleId']] = $val['name'];
            }
             
        }
        return $resultArr;
    }
    
    /**
     * Get Packaging Count
     * @return array
     */
    public function getPackagingCount()
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select(array('t1' => 'order_manifest'));
        $select->columns(array(
            'packagingCount' => new Expression('COUNT(t1.id)')
        ));
        
        $select->where('t1.status IN(9,11)');
        
        $smt = $sql->prepareStatementForSqlObject($select);
        $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
        return $result;
    }
    
    /**
     * Get Dispatch Count
     * @return array
     */
    public function getDispatchCount()
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select(array('t1' => 'order_manifest'));
        $select->columns(array(
            'dispatchCount' => new Expression('COUNT(t1.id)')
        ));
        
        $select->where('t1.status IN(12,13)');
        
        $smt = $sql->prepareStatementForSqlObject($select);
        $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
        return $result;
    }
    
    /**
     * Call A Procedure
     * @param string $procedureName
     * @param array $data
     * @return string
     */
    public function callProcedure($procedureName = '', $data = array())
    {
        try {
            $sql = new Sql($this->adapter);
            
            $stmt = $this->adapter->createStatement();
            $stmt->prepare("CALL ".$procedureName." ('".$data['challanId']."','".$data['productId']."','".$data['userId']."','".$data['stateId']."');");
            $result = $this->getResultSetPrototype()->initialize($stmt->execute());
            
            // Retrieve output parameter
            $stmt2 = $this->getAdapter()->createStatement();
            $stmt2->prepare("SELECT @out AS returnCode");
            $result1 = $stmt2->execute();
            $output = $result1->current();
            return $output;
        } 
        catch (\Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    /**
     * Get Dispatch Count
     * @return array
     */
    public function getTodayOrderCount($today='')
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select(array('t1' => 'order_manifest'));
        $select->columns(array(
            'orderHeaderCount' => new Expression('COUNT(t1.id)')
        ));
    
//         $select->where('t1.status = 1');
        if(!empty($today)){
            $select->where('t1.status = 1');
            $select->where('t1.created_on >="'.$today.'"');
        }else{
            $select->where('t1.status IN(1,7)');
        }
        $smt = $sql->prepareStatementForSqlObject($select);
//         echo '<pre>'; print_r($smt->getSql()); die;
        $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
        return $result;
    }
    
    /**
     * 
     * @param string $today
     * @return unknown
     */
    public function getRetunedOrderCount($today='')
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select(array('t1' => 'order_manifest'));
        $select->columns(array(
            'orderHeaderCount' => new Expression('COUNT(t1.id)')
        ));
    
        //         $select->where('t1.status = 1');
        if(!empty($today)){
            $select->where('t1.created_on >="'.$today.'"');
        }
        $select->where('t1.status IN(22,20)');
        
        $smt = $sql->prepareStatementForSqlObject($select);
        //         echo '<pre>'; print_r($smt->getSql()); die;
        $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
        return $result;
    }
    
    /**
     * 
     * @param string $today
     * @return unknown
     */
    public function getOFDOrderCount($today='')
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select(array('t1' => 'order_manifest'));
        $select->columns(array(
            'orderHeaderCount' => new Expression('COUNT(t1.id)')
        ));
    
        //         $select->where('t1.status = 1');
        if(!empty($today)){
            $select->where('t1.created_on >="'.$today.'"');
        }
        $select->where('t1.status IN(14,15,16)');
    
        $smt = $sql->prepareStatementForSqlObject($select);
        //         echo '<pre>'; print_r($smt->getSql()); die;
        $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
        return $result;
    }
}
