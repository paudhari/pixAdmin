<?php

namespace Notes\Model;

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

class NotesTable extends CustomTable
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
    
    public function getNotesData($logedInId){
         $sql = new Sql($this->adapter);
        $select = $sql->select(array('t1' => 'add_note'));
        $select->columns(array(
            'noteId'=> new Expression('IF(t1.id IS NOT NULL,t1.id,"")'),
            'noteTitle'=> new Expression('IF(t1.note_title IS NOT NULL,t1.note_title,"")'),
            'noteDescription'=> new Expression('IF(t1.note_description IS NOT NULL,t1.note_description,"")'),
//            'price'=> new Expression('IF(t1.price IS NOT NULL,t1.price,"")'),
            ));
        
         $select->where(array('created_by='. $logedInId.' AND status=1'));
        $smt = $sql->prepareStatementForSqlObject($select);
        $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
        return $result;
    }
    
    public function getNotesDescription($noteId){
         $sql = new Sql($this->adapter);
        $select = $sql->select(array('t1' => 'add_note'));
        $select->columns(array(
            'noteDescription'=> new Expression('IF(t1.note_description IS NOT NULL,t1.note_description,"")'),
            ));
        $select->where(array('id='. $noteId));
        $smt = $sql->prepareStatementForSqlObject($select);
        $result = $this->resultSetPrototype->initialize($smt->execute())->toArray();
        return $result;
    }
    
}
