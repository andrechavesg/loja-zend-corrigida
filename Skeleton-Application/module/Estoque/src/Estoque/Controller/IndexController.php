<?php
    namespace Estoque\Controller;

    use Zend\Mvc\Controller\AbstractActionController;
    use Zend\View\Model\ViewModel;
    use Estoque\Entity\Produto;
    use Zend\Mail\Message;
    use Zend\Mail\Transport\Smtp as SmtpTransport;
    use Zend\Mail\Transport\SmtpOptions;
    use Zend\Mime\Message as MimeMessage;
    use Zend\Mime\Part as MimePart;
    use Estoque\Form\ProdutoForm;
    use Estoque\Entity\Categoria;

    class IndexController extends AbstractActionController  {
        public function IndexAction(){
            $pagina = $this->params()->fromRoute('page',1);
            $qtdPorPagina = 5;
            $offset = ($pagina - 1) * $qtdPorPagina;

            $entityManager = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
            $repositorio = $entityManager->getRepository('Estoque\Entity\Produto');

            $produtos = $repositorio->getProdutosPaginados($qtdPorPagina,$offset);

            $view_params = Array(
       
                'produtos' => $produtos,
                'qtdPorPagina' => $qtdPorPagina
            );
            return new ViewModel($view_params);
        }
    
        public function cadastrarAction(){
            if(!$user= $this->identity()){
                return $this->redirect()->toUrl('/Usuario/Index');
            }

            $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
            $categoriaRepository = $entityManager->getRepository('Estoque\Entity\Categoria');
            $form = new ProdutoForm($entityManager);

            if($this->request->isPost()){

                $nome = $this->request->getPost('nome');
                $preco = $this->request->getPost('preco');
                $descricao = $this->request->getPost('descricao');
                $categoria = $categoriaRepository->find($this->request->getPost('categoria'));

                $produto = new Produto($nome,$preco,$descricao);
                $produto->setCategoria($categoria);

                $form->setInputFilter($produto->getInputFilter());
                $form->setData($this->request->getPost());

                if($form->isValid()){

                    $entityManager->persist($produto);
                    $entityManager->flush();
                    
                    return $this->redirect()->toUrl('/Index/Index');
                }


            }
            return new ViewModel(['form'=>$form]);
        }

        public function removerAction(){
            $id = $this->params()->fromRoute('id');
            
            if($this->request->isPost()){
                $id = $this->request->getPost('id');
                $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
                $repositorio = $entityManager->getRepository('Estoque\Entity\Produto');

                $produto = $repositorio->find($id);
                $entityManager->remove($produto);
                $entityManager->flush();

                return $this->redirect()->toUrl('/Index/Index');

            }
            
            return new ViewModel(['id' =>$id]);
        }

        public function editarAction(){
            $id = $this->params()->fromRoute('id');

            if(is_null($id)){
                $id = $this->request->getPost('id');
            }
            $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
            $repositorio = $entityManager->getRepository('Estoque\Entity\Produto');
            $produto = $repositorio->find($id);

            if($this->request->isPost()){
                $produto->setNome($this->request->getPost('nome'));
                $produto->setPreco($this->request->getPost('preco'));
                $produto->setDescricao($this->request->getPost('descricao'));

                $entityManager->persist($produto);
                $entityManager->flush();

                $this->flashMessenger()->addSuccessMessage('Produto alterado com sucesso.');

                return $this->redirect()->toUrl('/Index');
            }

            return new ViewModel(['produto' => $produto]);
        }

        public function contatoAction(){
           
            if($this->request->isPost()) {
                $nome     = $this->request->getPost('nome');
                $email    = $this->request->getPost('email');
                $msg = $this->request->getPost('msg');

                $msgHtml = "
                    <b>Nome:</b> {$nome},<br>
                    <b>Email:</b> {$email},<br>
                    <b>Mensagem:</b> {$msg}
                ";
                $htmlPart = new MimePart($msgHtml);
                $htmlPart->type= 'text/html';

                $htmlMsg = new MimeMessage();
                $htmlMsg->addPart($htmlPart);

                $email = new Message();
                $email->addTo('hlacerdabarros@gmail.com');
                $email->setSubject('Contato feito pelo site');
                $email->addFrom('hlacerdabarros@gmail.com');

                $email->setBody($htmlMsg);

                $config = array(

                    'host' => 'smtp.gmail.com',
                    'connection_class'  => 'login',
                    'connection_config' => array(
                        'ssl'       => 'tls',
                        'username' => 'hlacerdabarros@gmail.com',
                        'password' => 'pgmhenri69'
                        ),
                    'port' => 587,
            );
                $transport = new SmtpTransport();
                $options = new SmtpOptions($config);
                $transport->setOptions($options);

                $transport->send($email);

                $this->flashMessenger()->addMessage('Email enviado com sucesso.');
                
                return $this->redirect()->toURL('/Index');

            }
            return new ViewModel();
        }
    }