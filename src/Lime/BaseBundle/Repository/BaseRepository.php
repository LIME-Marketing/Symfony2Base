<?php

namespace Lime\BaseBundle\Repository;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Lime\BaseBundle\Model\EntityInterface;
use Lime\BaseBundle\Event\BaseEvent;

/**
 * A generic class that provides basic repository functions. This class
 * can be created and using the BaseRepoFactory class.
 * 
 * @author Michael Shattuck <ms2474@gmail.com> 
 */
class BaseRepository extends EntityRepository
{
    protected $em;
    protected $repo;
    protected $class;
    protected $dispatcher;

    /**
     *
     * @param EventDispatcherInterface $dispatcher
     * @param EntityManager $em
     * @param string $class 
     */
    public function __construct(EventDispatcherInterface $dispatcher, EntityManager $em, $class)
    {
        parent::__construct($em, $em->getClassMetadata($class));

        $this->dispatcher = $dispatcher;
        $this->em         = $em;
        $this->repo       = $em->getRepository($class);
        $this->class      = $class;
    }

    /**
     * Function for checking the existence of an entity with a given id.
     *
     * @param string $id
     * @return boolean 
     */
    public function exists($id)
    {
        $entity = $this->find($id);

        if (null === $entity) {
            return false;
        }

        return $entity;
    }

    /**
     * Function for creating an entity based of the provided class.
     *
     * @param boolean $sendEvent
     * @return \Lime\BaseBundle\Repository\class 
     */
    public function create($sendEvent = false)
    {
        $entity = new $this->class();

        if ($sendEvent) {
            $this->createdEvent($entity);
        }

        return $entity;
    }

    /**
        * Save an entity to the database. 
        * 
        * @param EntityInterface $entity 
        */
    public function save(EntityInterface $entity, $sendPreEvent = false, $sendPostEvent = false, $sendCreationEvent = false)
    {
        if ($sendPreEvent) {
            $this->prePersistEvent($entity);
        }

        $this->doSave($entity);

        if ($sendPostEvent) {
            $this->postPersistEvent($entity);
        }

        if ($sendCreationEvent) {
            $this->createdEvent($entity);
        }
    }

    /**
     * Remove an entity from the database.
     *
     * @param EntityInterface $entity
     * @param boolean $sendEvent 
     */
    public function remove(EntityInterface $entity, $sendEvent = false)
    {
        $this->doRemove($entity);

        if ($sendEvent) {
            $this->removeEvent($entity);
        }
    }

    /**
     * Retrieve class name of this repository.
     *
     * @return string 
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Returns the Docrine Repository of this class.
     * 
     * @return Doctrine\ORM\EntityRepository
     */
    public function getDoctrineRepository()
    {
        return $this->repo;
    }

    /**
     * Function for performing a database search.
     *
     * @param string $searchterm
     * @param string $index
     * @return array  
     */
    public function search($searchterm, $index)
    {
        $whereString = "t.$index LIKE :searchterm";

        $dql = "SELECT t
            FROM $this->class t
            WHERE
            $whereString
            ORDER BY t.$index DESC
        ";

        $query = $this->createQuery($dql)
            ->setFirstResult(0)
            ->setMaxResults(20)
            ->setParameter('searchterm' , '%'.$searchterm.'%')
        ;

        return $query->getResult();
    }

    /**
     * Function for performing a weighted database search.
     *
     * @param string $searchterm
     * @param string $index
     * @return array  
     */
    public function weightedSearch($searchterm, array $caseArray)
    {
        $i           = 0;
        $caseString  = '';
        $whereString = '';

        foreach ($caseArray as $name => $weight) {
            $i++;

            $caseString .= "(CASE
                WHEN (t.$name LIKE :searchterm) THEN $weight
                ELSE 0
            END)";

            $whereString .= "t.$name LIKE :searchterm";
          
            if (count($caseArray) > $i) {
                $caseString  .= " + ";
                $whereString .= " OR ";
            }
        }

        $dql = "SELECT t,
            $caseString
            AS weight
            FROM $this->class t
            WHERE
            $whereString
            ORDER BY weight DESC
        ";

        $query = $this->createQuery($dql)
            ->setFirstResult(0)
            ->setMaxResults(20)
            ->setParameter('searchterm' , '%'.$searchterm.'%')
        ;

        return $query->getResult();
    }

    /**
     * Function for creating a custom DQL query.
     *
     * @param string $dql
     * @return \Doctrine\ORM\Query 
     */
    public function createQuery($dql = "")
    {
        $query = new Query($this->em);

        if (!empty($dql)) {
            $query->setDql($dql);
        }

        return $query;
    }

    /**
     * Function for reconstructing this repository using 
     * a different class. 
     *
     * @param string $class 
     */
    public function reconstruct($class)
    {
        $this->repo  = $this->em->getRepository($class);
        $this->class = $class;
    }

    /**
     * Function for sending a generic event with an entity.
     *
     * @param EntityInterface $entity
     * @param string $name 
     */
    public function sendEvent(EntityInterface $entity, $name) {
        $className = $this->createEventName();
        $this->dispatcher->dispatch($className.'.'.$name, new BaseEvent($entity));
    }

    /**
     * Performs the actual persistence of an entity.
     *
     * @param EntityInterface $entity 
     */
    protected function doSave(EntityInterface $entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * Performs the actual removal of an entity.
     *
     * @param EntityInterface $entity 
     */
    protected function doRemove(EntityInterface $entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }

    /**
     * Sends an generic created event with the entity attached.
     *
     * @param EntityInterface $entity 
     */
    protected function createdEvent(EntityInterface $entity) {
        $className = $this->createEventName();
        $this->dispatcher->dispatch($className.'.creation', new BaseEvent($entity));
    }

    /**
     * Sends an generic prepersist event with the entity attached.
     *
     * @param EntityInterface $entity 
     */
    protected function prePersistEvent(EntityInterface $entity) {
        $className = $this->createEventName();
        $this->dispatcher->dispatch($className.'.pre_persist', new BaseEvent($entity));
    }

    /**
     * Sends an generic postpersist event with the entity attached.
     *
     * @param EntityInterface $entity 
     */
    protected function postPersistEvent(EntityInterface $entity) {
        $className = $this->createEventName();
        $this->dispatcher->dispatch($className.'.post_persist', new BaseEvent($entity));
    }

    /**
     * Sends an generic remove event with the entity attached.
     *
     * @param EntityInterface $entity 
     */
    protected function removeEvent(EntityInterface $entity) {
        $className = $this->createEventName();
        $this->dispatcher->dispatch($className.'.remove', new BaseEvent($entity));
    }

    /**
     * Creates an event name based of the given class.
     *
     * @return string 
     */
    protected function createEventName()
    {
        $class      = $this->class;
        $classPrep1 = str_replace('Bundle\Entity', '', $class);
        $classPrep2 = str_replace('\\', '_', $classPrep1);
        $classPrep3 = strtolower($classPrep2);

        return $classPrep3;
    }
}
