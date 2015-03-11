<?php
/**
 * Sim Tecnologia Application
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.simtecnologia.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   AbstractService.php
 * @package    SimBase\Service
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd     New BSD License
 */
namespace SimBase\Service;

use Doctrine\ORM\EntityManager;
use SimBase\Hydrator\DoctrineObjectCustom as DoctrineHydrator;

/**
 * Class AbstractService
 *
 * @package Base\Service
 */
abstract class AbstractService
{

    /**
     *
     * @var EntityManager
     */
    protected $entityManager;

    /**
     *
     * @var object
     */
    protected $entity;

    /**
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
    }

    /**
     *
     * @return the $entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     *
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     *
     * @return the $entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     *
     * @param object $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * Method insert.
     *
     * @param array $data
     * @return $entity
     */
    public function insert(array $data)
    {
        $instanceEntity = $this->getEntity();
        $entity = new $instanceEntity();

        $hydrator = new DoctrineHydrator($this->getEntityManager());
        $entity = $hydrator->hydrate($data, $entity);

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity;
    }

    /**
     * Method update.
     *
     * @param array $data
     * @param integer $id
     * @return $entity
     */
    public function update(array $data, $id)
    {
        $entity = $this->getEntityManager()->getReference($this->getEntity(), $id);

        $hydrator = new DoctrineHydrator($this->getEntityManager());
        $entity = $hydrator->hydrate($data, $entity);

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity;
    }

    /**
     *
     * @param array $data
     * @return unknown boolean
     */
    public function remove(array $data)
    {
        $entity = $this->getEntityManager()->getRepository($this->getEntity())->findOneBy($data);

        if ($entity) {
            $this->getEntityManager()->remove($entity);
            $this->getEntityManager()->flush();

            return $entity;
        }

        return false;
    }
}
