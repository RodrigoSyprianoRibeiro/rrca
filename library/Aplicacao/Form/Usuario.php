<?php

class Aplicacao_Form_Usuario extends Zend_Form
{
    public function init()
    {
        $this->setName('usuario');

        $nome = new Zend_Form_Element_Text('nome');
        $nome->setLabel('Nome:')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty')
              ->setAttrib('class', 'form-control')
              ->setAttrib('placeholder', 'Entre com o Nome')
              ->setAttrib('title', 'Informe o seu nome');
        $this->addElement($nome);

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('E-mail:')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty')
              ->addValidator('EmailAddress')
              ->setAttrib('class', 'form-control')
              ->setAttrib('placeholder', 'Entre com o E-mail')
              ->setAttrib('title', 'Informe o e-mail');
        $this->addElement($email);

        $password = new Zend_Form_Element_Password('senha');
        $password->setLabel('Senha:')
                  ->addFilter('StripTags')
                  ->addFilter('StringTrim')
                  ->addValidator('NotEmpty')
                  ->setAttrib('class', 'form-control')
                  ->setAttrib('placeholder', 'Entre com a Senha')
                  ->setAttrib('title', 'Informe a senha');
        $this->addElement($password);

        $model = new Application_Model_Perfil();
        $perfil = new Zend_Form_Element_Select('id_perfil');
        $perfil->setLabel('Perfil:')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty')
              ->setAttrib('class', 'form-control')
              ->setAttrib('placeholder', 'Entre com o Perfil')
              ->addMultiOptions($model->getPerfis());
        $this->addElement($perfil);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Enviar')
                ->setAttrib('type', 'submit');
        $this->addElement($submit);
    }

    public function isValid($data)
    {
        if(isset($data['email']) && !empty($data['email']) && !isset($data['id'])) {
            $emailValidator = new Zend_Validate_Db_NoRecordExists('usuario', 'email');
            $this->getElement('email')
                 ->addValidator( $emailValidator );
        }
        return parent::isValid($data);
    }
}