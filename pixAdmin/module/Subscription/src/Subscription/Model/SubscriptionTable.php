<?php

namespace Subscription\Model;

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

class SubscriptionTable extends CustomTable
{
    public $table = 'user';
    
    /**
     *
     * @param array $data            
     */
    public function userRegister(array $data)
    {
        $this->insert($data);
        return $this->lastInsertValue;
    }
    
    
    public function getPlanData($logedInId){
         $sql = new Sql($this->adapter);
        $select = $sql->select(array('t1' => 'add_plan'));
        $select->columns(array(
            'planId'=> new Expression('IF(t1.id IS NOT NULL,t1.id,"")'),
            'planName'=> new Expression('IF(t1.plan_name IS NOT NULL,t1.plan_name,"")'),
            'noOfImages'=> new Expression('IF(t1.no_of_images IS NOT NULL,t1.no_of_images,"")'),
            'price'=> new Expression('IF(t1.price IS NOT NULL,t1.price,"")'),
            ));
        
         $select->where(array('created_by='. $logedInId.' AND status=1'));
        $smt = $sql->prepareStatementForSqlObject($select);
        $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
        return $result;
        
    }
    
    public function getAllDetails($planId){
        $sql = new Sql($this->adapter);
        $select = $sql->select(array('t1' => 'add_plan'));
        $select->columns(array(
            'planId'=> new Expression('IF(t1.id IS NOT NULL,t1.id,"")'),
            'planDuration'=> new Expression('IF(t1.duration IS NOT NULL,t1.duration,"")'),
            'startDate'=> new Expression('IF(t1.start_date IS NOT NULL,t1.start_date,"")'),
            'endDate'=> new Expression('IF(t1.end_date IS NOT NULL,t1.end_date,"")'),
            'recurring'=> new Expression('IF(t1.recurring IS NOT NULL,t1.recurring,"")'),
            'noOfImages'=> new Expression('IF(t1.no_of_images IS NOT NULL,t1.no_of_images,"")'),
            'price'=> new Expression('IF(t1.price IS NOT NULL,t1.price,"")'),
            ));
        
         $select->where(array('created_by='. $logedInId.' AND status=1'));
        $smt = $sql->prepareStatementForSqlObject($select);
        $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
        return $result;
    }
    
    public function getAllPlanDetails($planId){
         $sql = new Sql($this->adapter);
        $select = $sql->select(array('t1' => 'add_plan'));
        $select->columns(array(
            'planId'=> new Expression('IF(t1.id IS NOT NULL,t1.id,"")'),
            'planName'=> new Expression('IF(t1.plan_name IS NOT NULL,t1.plan_name,"")'),
            'noOfImages'=> new Expression('IF(t1.no_of_images IS NOT NULL,t1.no_of_images,"")'),
            'price'=> new Expression('IF(t1.price IS NOT NULL,t1.price,"")'),
            ));
         $select->where(array('id='. $planId.' AND status=1'));
        $smt = $sql->prepareStatementForSqlObject($select);
        
        $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
        return $result;
    }
}
