<?php

class Aplicacao_Form_Post extends Zend_Form
{
    public function init()
    {
        $this->setName('post');

        $titulo = new Zend_Form_Element_Text('titulo');
        $titulo->setLabel('Título:')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty')
              ->setAttrib('class', 'form-control')
              ->setAttrib('placeholder', 'Entre com o Título')
              ->setAttrib('size', '100')
              ->setAttrib('title', 'Informe o Título');
        $this->addElement($titulo);

        $imagem = new Zend_Form_Element_Text('imagem_capa');
        $imagem->setLabel('Caminho Imagem:')
                ->setRequired(true)
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('class', 'form-control')
                ->setAttrib('placeholder', 'Entre com o Caminho da Imagem')
                ->setAttrib('title', 'Informe o Caminho da Imagem');
        $this->addElement($imagem);

        $conteudo = new Zend_Form_Element_Textarea('conteudo');
        $conteudo->setLabel('Conteudo:')
              ->setRequired(true)
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty')
              ->setAttrib('class', 'form-control')
              ->setAttrib('placeholder', 'Entre com o Conteúdo')
              ->setAttrib('title', 'Informe o Conteúdo');
        $this->addElement($conteudo);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Enviar')
                ->setAttrib('class', 'btn btn-primary')
                ->setAttrib('type', 'submit');
        $this->addElement($submit);
    }
}