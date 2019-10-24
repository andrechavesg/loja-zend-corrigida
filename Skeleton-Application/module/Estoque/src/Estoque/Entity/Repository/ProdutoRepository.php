<?php
namespace Estoque\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ProdutoRepository extends EntityRepository{

    public function getProdutosPaginados($qtdPorPagina,$offset){

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $qb->select('p')
        ->from('Estoque\Entity\Produto', 'p')
        ->setMaxResults($qtdPorPagina)
        ->setFirstResult($offset)
        ->orderBy('p.id');

        $query = $qb->getQuery();

        $paginator = new Paginator($query);

        return $paginator;
    }
}