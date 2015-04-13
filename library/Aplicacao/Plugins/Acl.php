<?php

class Aplicacao_Plugins_Acl extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(Zend_Controller_Request_Abstract $request) {

        $acl = new Zend_Acl();

        $acl->addRole(new Zend_Acl_Role('usuario'));
        $acl->addRole(new Zend_Acl_Role('admin'), 'usuario');

        $acl->add(new Zend_Acl_Resource('admin:error'));
        $acl->add(new Zend_Acl_Resource('admin:index'));
        $acl->add(new Zend_Acl_Resource('admin:login', 'logout'));
        $acl->add(new Zend_Acl_Resource('admin:post'));
        $acl->add(new Zend_Acl_Resource('admin:usuario'));

        $acl->add(new Zend_Acl_Resource('blog:error'));
        $acl->add(new Zend_Acl_Resource('blog:index'));

        $acl->add(new Zend_Acl_Resource('default:error'));
        $acl->add(new Zend_Acl_Resource('default:index'));


        $acl->allow('usuario', 'blog:error');
        $acl->allow('usuario', 'blog:index');

        $acl->allow('usuario', 'default:error');
        $acl->allow('usuario', 'default:index');

        $acl->allow('usuario', 'admin:error');
        $acl->allow('usuario', 'admin:index');
        $acl->allow('usuario', 'admin:login', 'logout');
        $acl->allow('usuario', 'admin:post', array('index', 'new', 'edit'));
        $acl->deny('usuario', 'admin:post', 'delete');
        $acl->allow('usuario', 'admin:usuario', array('edit'));
        $acl->deny('usuario', 'admin:usuario', array('index', 'new', 'delete'));
        $acl->allow('admin', 'admin:post');
        $acl->allow('admin', 'admin:usuario');

        // Primeiro vamos instânciar o Zend_Auth
        $auth = Zend_Auth::getInstance();
        $auth->setStorage(new Zend_Auth_Storage_Session('admin'));
        // Agora vamos descobri qual o modulo, controller e action que o usuário está acessando
        $module = $request->getModuleName();
        $controller = $request->getControllerName();
        $action = $request->getActionName();

        if($auth->hasIdentity()) {
            $identity = $auth->getIdentity();

            if(!$acl->has($module . ':' . $controller, $action) or
                    !$acl->isAllowed($identity->perfil, 'admin:'.$controller, $action)) {
                if ($module == 'admin') {
                    $request->setModuleName('admin')
                            ->setControllerName('index')
                            ->setActionName('index');
                } else {
                    $request->setModuleName('default')
                            ->setControllerName('index')
                            ->setActionName('index');
                }
            }
        }
    }
}