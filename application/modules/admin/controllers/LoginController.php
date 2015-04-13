<?php

class Admin_LoginController extends Aplicacao_Controller_Action {

    public function indexAction() {

        if (!Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->hasIdentity()) {

            $layout = Zend_Layout::getMvcInstance();
            $layout->setLayout("login")
                ->setLayoutPath(APPLICATION_PATH . '/modules/admin/views/layouts');

            $form = new Aplicacao_Form_Login();
            $this->view->form = $form;

            if ($this->_request->isPost()) {
                if ($form->isValid($this->data)) {
                    $authAdapter = $this->getAuthAdapter();
                    $authAdapter->setIdentity($this->data['email'])
                                ->setCredential($this->data['senha']);

                    $select = $authAdapter->getDbSelect();
                    $select->join(array('p' => 'perfil'), 'p.id = usuario.id_perfil', array('perfil' => 'nome'));

                    $result = $authAdapter->authenticate();

                    if ($result->isValid()) {
                        $auth = Zend_Auth::getInstance();
                        $auth->setStorage(new Zend_Auth_Storage_Session('admin'));
                        $dataAuth = $authAdapter->getResultRowObject(null, 'senha');
                        $auth->getStorage()->write($dataAuth);
                        $this->_redirect("/admin");
                    } else {
                        $this->view->error = "Usuário ou senha inválidos";
                        $form->populate($this->data);
                    }
                }
            }
        } else {
            $this->_redirect('/admin');
        }
    }

    private function getAuthAdapter() {
        $bootstrap = $this->getInvokeArg('bootstrap');
        $resource = $bootstrap->getPluginResource('db');
        $db = $resource->getDbAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($db);
        $authAdapter->setTableName('usuario')
                     ->setIdentityColumn('email')
                     ->setCredentialColumn('senha')
                     ->setCredentialTreatment('MD5(?)');

        return $authAdapter;
    }

    public function logoutAction() {
        $auth = Zend_Auth::getInstance();
        $auth->setStorage(new Zend_Auth_Storage_Session('admin'));
        $auth->clearIdentity();
        $this->_redirect('/admin');
    }
}