<?php
    namespace Estoque\Entity;

    use Doctrine\ORM\Mapping as ORM;   
    
    /** @ORM\Entity **/
    class Categoria{

        /**
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="AUTO")
         * @ORM\Column(type="integer")
         */
        private $id;

        /**
         * @ORM\Column(type="string")
         */
        private $nome;

        /**
         * @ORM\OneToMany(targetEntity="Estoque\Entity\Produto", mappedBy = "categoria")
         */
        private $produto;
        
        public function __contruct($nome,$id=null){

            $this->id = $id;
            $this->nome = $nome;
        }

        public function getNome(){
            return $this->nome;
        }

        public function getId(){
            return $this->id;
        }

    }

?>