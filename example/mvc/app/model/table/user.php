<?php

namespace app\model\table;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class user {
    
    private $tableGateway;

    public function __construct($container)
    {
        $dbAdapter = $container["dbAdapter"];
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new \app\model\user());
        $this->tableGateway = new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
    }
    
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }
    
    public function getUserById($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }
    
}
