<?php

namespace JobAd\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use JobAd\Domain\Collection;
use JobAd\Domain\Model\TypeOfJob\TypeOfJobRepository;
use JobAd\Domain\Model\TypeOfJob\TypeOfJobSpecification;
use JobAd\Domain\Model\TypeOfJob\TypeOfJob;
use JobAd\Domain\Model\TypeOfJob\Id;
use JobAd\Domain\Model\TypeOfJob\Adapter\TypeOfJobCollection;

/**
 * Description of TypeOfJobDoctrineRepository
 *
 * @author vedran
 */
class TypeOfJobDoctrineRepository implements TypeOfJobRepository
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function nextIdentity()
    {
        return Id::generate();
    }

    public function add(TypeOfJob $typeOfJob)
    {
        $this->em->persist($typeOfJob);
        $this->em->flush();
    }

    public function byId(Id $id)
    {
        return $this->em->find(TypeOfJob::class, $id);
    }

    public function query($specification): Collection
    {
        return $specification->specifies($this);
    }

    public function readDataByDQL(string $dql, array $params = [])
    {
        $query = $this->em->createQuery($dql)->setParameters($params);

        return new TypeOfJobCollection($query->getResult());
    }

    public function byIds(array $ids = [])
    {
        $query = $this->em->createQueryBuilder()
                ->select('t')
                ->from(TypeOfJob::class, 't')
                ->andWhere('t.id IN (:ids)')
                ->setParameter('ids', $ids);

        /**
         * @todo 
         * 
         * 25 svibanj 2017
         * nasao sam resenje kako da serializujem u primitivne tipove symfony form
         * ovo ovde ponovo najverovatinije return $query->getQuery()->getResult(); :)
         * 
         * 16 svibanj 2017
         * Symfony forme korste Doctrine ArryCollection a 
         * TypeOfJobCollection je to .
         * Kada naucim nacina da Symfony Form $typeOfJob prosledim niz ili drugacije
         * onda ovo ovde zameni. Trenutno radi sa ArryCollection ...
         * 
         * 
         * 13 ozujak 2017
         * Ovo treba ovako da izgleda return $query->getQuery()->getResult();
         * kolekcije se nalze u entitietu kao property $i[]. 
         * repozitorija nema veze sa ovim kolkcijama.
         * 
         * 
         */
        return new TypeOfJobCollection($query->getQuery()->getResult());
    }

    public function dataTable(array $params = [])
    {
        $query = $this->em->createQueryBuilder()
                ->select('t')
                ->from(TypeOfJob::class, 't')
                ->setFirstResult($params['start'])
                ->setMaxResults($params['length'])
                ->orderBy('t.createdAt', 'DESC');

        return new Paginator($query->getQuery(), $fetchJoinCollection = false);
    }

    /**
     * 
     * @todo refaktorisati specifikacije !!!! za sad ovako ...
     * 
     * Procitaj @return parametra ..
     * 
     * @param type $dql
     * @return bool !VEOMA VAZNO ... ZNACI NE VRACA [] , object, .... VRACA SAMO BOOL ...
     */
    public function nameIsUnique($dql, array $params = [])
    {
        $query = $this->em->createQuery($dql);
        $query->setParameter('name', $params['name']);
        $t = $query->execute();

        dump($t);

        if ($t) {
            dump('nije prazan....prazan...');
        }

        return ($t) ? false : true;
    }

}
