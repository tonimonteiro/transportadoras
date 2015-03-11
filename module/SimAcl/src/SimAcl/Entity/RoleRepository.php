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
 * @category   RoleRepository.php
 * @package    SimAcl\Entity
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd      New BSD License
 */

namespace SimAcl\Entity;

use Doctrine\ORM\EntityRepository;

class RoleRepository extends EntityRepository
{

    public function fetchParent()
    {
        $entities = $this->findAll();
        $array = array();

        foreach ($entities as $entity) {
            $array[$entity->getId()] = $entity->getName();
        }
        return $array;
    }
}
