<?php

    namespace Estoque\Form;

    use Zend\Form\Form;
    use Zend\Form\Element;
    use Doctrine\ORM\EntityManager;

    class ProdutoForm extends Form{

        public function __construct(EntityManager $entityManager){

            parent::__construct('formProduto');

            //campo do nome
            $this->add([
                'type' => 'Text',
                'name' => 'nome',
                'attributes' => [
                    'class' => 'form-control'
                ]
            ]);

            //campo do preço
            $this->add([
                'type' => 'number',
                'name' => 'preco',
                'attributes' => [
                    'class' => 'form-control'
                ]
            ]);

            //campo do descrição
            $this->add([
                'type' => 'Textarea',
                'name' => 'descricao',
                'attributes' => [
                    'class' => 'form-control'
                ]
            ]);

            $this->add(new Element\Csrf('csrf'));

            //campo da categoria
            $this->add([
                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'name' => 'categoria',
                'options' => [
                    'object_manager' => $entityManager,
                    'target_class' => 'Estoque\Entity\Categoria',
                    'property' => 'nome',
                    'empty_option' => 'escolha uma categoria'
                ],
                'atributes' =>[
                    'class' => 'form-control'
                ]
            ]);
        }
    }
?>