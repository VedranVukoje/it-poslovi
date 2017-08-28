<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Application\Service;

use Doctrine\ORM\EntityManager;
use JobAd\Application\Service\TransactionalSession;

/**
 * Description of DoctrineSession
 *
 * @author vedran
 */
class DoctrineSession implements TransactionalSession
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function executeAtomically(callable $operation)
    {
        return $this->em->transactional($operation);
    }

}
