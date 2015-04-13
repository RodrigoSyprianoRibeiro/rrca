<?php

abstract class Aplicacao_Controller_Action extends Zend_Controller_Action {

    protected $userId;
    protected $userNome;
    protected $userEmail;
    protected $userPerfil;
    protected $data;
    protected $_logger = null;

    public function init() {
        $this->flashMessenger = $this->_helper->FlashMessenger;
        $this->view->messages = $this->flashMessenger->getMessages();

        if ($this->_request->isPost()) {
            $this->data = $this->_request->getPost();
            if (isset($this->data['submit']))
                unset($this->data['submit']);
        }
        $auth = Zend_Auth::getInstance();
        $auth->setStorage(new Zend_Auth_Storage_Session('admin'));
        if ($auth->hasIdentity()) {
            $this->usuarioLogado = (object) array('id' => $auth->getIdentity()->id,
                                      'nome' => $auth->getIdentity()->nome,
                                      'email' => $auth->getIdentity()->email,
                                      'perfil' => $auth->getIdentity()->perfil,
                                      'imagem' => $auth->getIdentity()->imagem);
        }
    }
}