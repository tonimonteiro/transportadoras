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
 * @category   Role.php
 * @package    SimAcl\Service
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd     New BSD License
 */
namespace SimAcl\Service;

use SimBase\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class Role extends AbstractService
{

    public function __construct(EntityManager $entityManager)
    {
        $this->setEntity('SimAcl\Entity\Role');
        parent::__construct($entityManager);
    }

//     public function insert(array $data)
//     {
//         $instanceEntity = $this->getEntity();
//         $entity = new $instanceEntity($data);

//         if ($data['parent']) {
//             $parent = $this->getEntityManager()->getReference($this->getEntity(), $data['parent']);
//             $entity->setParent($parent);
//         } else
//             $entity->setParent(null);

//         $this->getEntityManager()->persist($entity);
//         $this->getEntityManager()->flush();
//         return $entity;
//     }

//     public function update(array $data, $id)
//     {
//         $entity = $this->getEntityManager()->getReference($this->getEntity(), $id);
//         (new Hydrator\ClassMethods())->hydrate($data, $entity);

//         if ($data['parent']) {
//             $parent = $this->getEntityManager()->getReference($this->getEntity(), $data['parent']);
//             $entity->setParent($parent);
//         } else
//             $entity->setParent(null);

//         $this->getEntityManager()->persist($entity);
//         $this->getEntityManager()->flush();
//         return $entity;
//     }

}
