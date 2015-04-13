<?php

class Application_Model_Usuario extends Application_Model_Abstract {

    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_Usuario();
    }

    public function _insert(array $data) {
        $data['senha'] = sha1($data['senha']);
        return $this->_dbTable->insert($data);
    }

    public function _update(array $data) {
        if (isset($data['senha']))
            $data['senha'] = md5($data['senha']);

        return $this->_dbTable->update($data, array('id=?'=>$data['id']));
    }

    public function _delete(array $data) {
        return $this->_dbTable->delete(array('id=?'=>$data['id']));
    }

    public function getNomeUsuario($id) {
        return $this->search(array('filtro'=>'id', 'str' => $id))->nome;
    }
}