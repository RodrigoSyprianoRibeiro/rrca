<?php

class Admin_IndexController extends Aplicacao_Controller_Action {

    public function indexAction() {
        $modelUsuario = new Application_Model_Usuario();
        $this->view->quantidadeUsuarios = $modelUsuario->count();

        $modelPost = new Application_Model_Post();
        $this->view->quantidadePosts = $modelPost->count();
    }

    public function preDispatch() {
        $auth = Zend_Auth::getInstance();
        $auth->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity())
            $this->_redirect('/admin/login');
    }
}