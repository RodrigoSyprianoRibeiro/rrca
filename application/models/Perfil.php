<?php

class Application_Model_Perfil extends Application_Model_Abstract {

    public function __construct() {
        $this->_dbTable = new Application_Model_DbTable_Perfil();
    }

    public function _insert(array $data) {
        return $this->_dbTable->insert($data);
    }

    public function _update(array $data) {
        return $this->_dbTable->update($data, array('id=?'=>$data['id']));
    }

    public function _delete(array $data) {
        return $this->_dbTable->delete($data, array('id=?'=>$data['id']));
    }

    public function getPerfis() {

        $perfis[''] = '-- Selecione o Perfil --';
        foreach($this->_dbTable->fetchAll() as $perfil) {
            $perfis[$perfil['id']] = $perfil['nome'];
        }
        return $perfis;
    }
}