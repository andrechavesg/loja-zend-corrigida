<?php
    namespace Estoque\Entity;
    use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity*/
    class Usuario{

        /**
         *@ORM\Id
        *@ORM\GeneratedValue(strategy="AUTO")
        *@ORM\Column(type="integer")
        */
        private $id;
        /**
         * @ORM\Column(type="string")
         */
        private $email;
        /**
         * @ORM\Column(type="string")
         */
        private $senha;

        public function __construct($email,$senha){

            $this->email = $email;
            $this->senha = $senha;
        }

        public function getEmail(){

            return $this->email;
        }

        public function getId(){

            return $this->id;
        }
    
        public function getSenha(){

            return $this->senha;
        }
    }

?>