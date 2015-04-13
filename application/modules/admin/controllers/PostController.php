<?php

class Admin_PostController extends Aplicacao_Controller_Action {

    public function indexAction() {
        $model = new Application_Model_Post();
        $pagina = intval($this->_getParam('pagina', 1));

        $params = array('order' => 'data DESC',
                        'pagina' => $pagina
                    );

        $this->view->posts = $model->fetchAll($params);
   }

    public function newAction() {
        $form = new Aplicacao_Form_Post();
        $this->view->form = $form;
        if($this->_request->isPost()) {
            if($form->isValid($this->data)) {
                $this->data['id_usuario'] = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity()->id;
                $this->data['titulo_limpo'] = Aplicacao_Plugins_GeraUrl::geraUrlLimpa($this->data['titulo']);
                $this->data['url_post'] = Aplicacao_Plugins_GeraUrl::geraUrlPost($this->data['titulo_limpo']);
                $model = new Application_Model_Post();
                if($model->save($this->data))
                    $this->_redirect ('/admin/post');
            }
        }
    }

    public function editAction() {
        $model = new Application_Model_Post();
        $form = new Aplicacao_Form_Post();

        $id = (int) $this->_request->getParam("id",0);
        $post = $model->find($id);

        if ($post &&
            ($this->usuarioLogado->perfil == 'admin' ||
                $this->usuarioLogado->id == $post->id_usuario)) {

            $form->populate($post->toArray());
            $form->getElement('titulo')->setAttrib('readonly', true);
            $this->view->form = $form;

            if ($this->_request->isPost()) {
                if($id)
                    $this->data['id'] = $id;
                if ($form->isValid($this->data)) {
                    if ($model->save($this->data))
                        $this->_redirect ('/admin/post');
                }
            }
        } else {
            $this->_redirect ('/admin');
        }
    }

    public function deleteAction() {
        $model = new Application_Model_Post();
        $form = new Aplicacao_Form_Post();
        $id = (int) $this->_request->getParam("id",0);
        if($id)
            $this->data['id'] = $id;
        if($model->delete($this->data))
            $this->_redirect ('/admin/post');

        $this->view->form = $form;
        $this->view->error = "Erro ao excluir Post";
    }

    public function preDispatch() {
        $auth = Zend_Auth::getInstance();
        $auth->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity())
            $this->_redirect('/admin/login');
    }
}