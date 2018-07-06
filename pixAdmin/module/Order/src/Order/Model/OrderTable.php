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

class OrderTable extends CustomTable
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
}
