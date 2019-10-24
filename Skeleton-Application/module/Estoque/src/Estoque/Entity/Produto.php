<?php
namespace Estoque\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;

/**
 * @ORM\Entity(repositoryClass="\Estoque\Entity\Repository\ProdutoRepository")
 */
class Produto implements InputFilterAwareInterface {

    /**
     *@ORM\Id
     *@ORM\GeneratedValue(strategy="AUTO")
     *@ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     */
    private $nome;

    /**
     * @ORM\Column(type="decimal",scale=2)
     */ 
    private $preco;

    /**
     * @ORM\Column(type="string")
     */
     private $descricao;

    /**
      * @ORM\ManyToOne(targetEntity="Estoque\Entity\Categoria", inversedBy="produto")
      * @ORM\JoinColumn(name="categoria_id",referencedColumnName="id",nullable=false)
     */
    private $categoria;
 
     public function __construct($nome,$preco,$descricao){
         $this->nome = $nome;
         $this->preco = $preco;
         $this->descricao = $descricao;
     }

     public function setCategoria(Categoria $categoria){
        return $this->categoria = $categoria;
     }
 
     public function getCategoria(){
        return $this->categoria;
     }

     public function getId(){
        return $this->id;
    }
    
     public function getNome(){
         return $this->nome;
     }
         
     public function getPreco(){
         return $this->preco;
     }
     
     public function getDescricao(){
         return $this->descricao;
     }

     public function setNome($nome){
         $this->nome = $nome;
     }
     
     public function setPreco($preco){
         $this->preco = $preco;
     }

     public function setDescricao($descricao){
         $this->descricao = $descricao;
     }

     public function setInputFilter(InputFilterInterface $inputFilter){

        throw new Exception('Você não deve invocar este método');
     }

     public function getInputFilter(){

        $inputFilter = new InputFilter();
        $inputFilter->add([
            'name' => 'nome',
            'required' => true,
            'validators' => [
                [
                    'name' => 'StringLength',
                    'option' => [
                        'min' => 3,
                        'max' => 100

                    ]
                ],
            ]
        ]);
        return $inputFilter;
     }
}
?>