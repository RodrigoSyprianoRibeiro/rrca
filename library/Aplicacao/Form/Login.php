<?php

class Aplicacao_Form_Login extends Zend_Form
{
    public function init()
    {
        $this->setName('login');
        $this->setAttrib('class', 'login');

        $email = new Zend_Form_Element_Text('email');
        $email->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty')
              ->addValidator('EmailAddress')
              ->setAttrib('class', 'form-control')
              ->setAttrib('placeholder', 'Email')
              ->setAttrib('title', 'Informe o e-mail');
        $this->addElement($email);

        $password = new Zend_Form_Element_Password('senha');
        $password->setRequired(true)
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim')
                 ->addValidator('NotEmpty')
                 ->setAttrib('class', 'form-control')
                 ->setAttrib('placeholder', 'Password')
                 ->setAttrib('title', 'Informe a senha');
        $this->addElement($password);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Entrar')
               ->setAttrib('class', 'btn btn-primary btn-block btn-flat')
               ->setAttrib('type', 'submit');
        $this->addElement($submit);

    }
}