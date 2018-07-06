<?php
namespace Order\Model;

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

class InmatesTable extends CustomTable {

    public $table = 'inmates';

  /*
     * get Inmates Details
     * @param type $userId
     * @return type
     */
    public function getInmatesDetails($userId) {
        $sql = new sql($this->adapter);
        $select = new select(array('t1' => $this->table));
        $select->columns(array('inmates_id','inmates_name','inmates_detail'));
        $select->where(array('created_by' => $userId));
        $smt = $sql->prepareStatementForSqlObject($select);
        $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
        return $result;
    }

    /*
     * get Inmates Details
     * @param type $userId
     * @return type
     */
    public function getInmatesIdDetails($id) {
        $sql = new sql($this->adapter);
        $select = new select(array('t1' => $this->table));
        $select->columns(array('inmates_id','inmates_name','inmates_detail'));
        $select->where(array('inmates_id' => $id));
        $smt = $sql->prepareStatementForSqlObject($select);
        $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
        return $result;
    }
    /**
     *
     * @throws \Exception
     */
    public function updateInmates($inmatesDetail,$userId = 0) {
        try {
            $insertData = array();
            $insertData['inmates_name'] =  $inmatesDetail['inmates_name'];
            $insertData['inmates_detail'] =  $inmatesDetail['inmates_name'];

            $this->update($insertData, array('user_id = ' . $userId,
                'inmates_id' =>  $inmatesDetail['inmates_id']
            ));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function insertInmates($inmatesDetail) {
        try {

            $ss = $this->insert($inmatesDetail);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    /**
     *
     * @throws \Exception
     */
    public function deleteInmates($inmatesId = '') {
        try {

            $this->delete(array(
                'inmates_id' => $inmatesId
            ));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}
