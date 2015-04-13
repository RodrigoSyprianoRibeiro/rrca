<?php

abstract class Application_Model_Abstract {

    protected $_dbTable;

    public function find($id) {
        return $this->_dbTable->find($id)->current();
    }

    public function save(array $data) {
        if (isset($data['id']))
            return $this->_update($data);
        else
            return $this->_insert($data);
    }

    public function delete(array $data) {
        if (isset($data['id']))
            return $this->_delete($data);
    }

    public function fetchAll($params=null) {
        $order = isset($params['order']) ? $params['order'] : '1 ASC';

        $select = $this->_dbTable->select();
        $select->order($order);

        $paginator = Zend_Paginator::factory($select);
        $paginator->setCurrentPageNumber($params['pagina']);
        return $paginator;
    }

    public function search(array $params) {
        $filtro = isset($params['filtro']) ? $params['filtro'] : "";
        $str = isset($params['str']) ? $params['str'] : "";

        $select = $this->_dbTable->select();

        if (!empty($str)) {
            $select->where($filtro." = '".$str."'");
        }

        return $this->_dbTable->fetchRow($select);
    }

    public function count() {
        $select = $this->_dbTable->select();

        return (int) count($this->_dbTable->fetchAll($select));
    }

    abstract public function _insert(array $data);

    abstract public function _update(array $data);

    abstract public function _delete(array $data);
}