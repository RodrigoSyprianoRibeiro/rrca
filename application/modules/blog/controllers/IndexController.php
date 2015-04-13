<?php

class Blog_IndexController extends Aplicacao_Controller_Action {

    public function indexAction() {

        $model = new Application_Model_Post();
        $pagina = intval($this->_getParam('pagina', 1));

        $params = array('order' => 'data DESC',
                        'pagina' => $pagina
                    );

        $this->view->posts = $model->fetchAll($params);
    }

    public function showAction() {
        $model = new Application_Model_Post();
        $titulo = $this->_request->getParam("titulo");
        $post = $model->buscaPost($titulo);
        if($post)
            $this->view->post = $post;
        else
            $this->_redirect('/');
    }
}