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
 * @category   PrivilegeRepository.php
 * @package    SimNavigation\Entity
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd      New BSD License
 */

namespace SimNavigation\Entity;

use Doctrine\ORM\EntityRepository;

class NavigationRepository extends EntityRepository
{
    public function findByParent($criteria=array(), $separator='')
    {
        $orderBy = array(
            'nameGroup' => 'ASC',
            'numberOrder' => 'ASC',
            'label' => 'ASC',
            'id' => 'ASC'
        );

        $list = $this->findBy($criteria, $orderBy);

        $newList = array();
        foreach($list as $key => $object) {
        	$newList[$object->getId()] = array(
        		'label' => ($separator ? $separator : '' ) . ' ' . $object->getLabel(),
        	    'value' => $object->getId(),
        	);

        	$criteria['parent'] = $object->getId();
        	$newList[$object->getId()]['parent'] = $this->findByParent($criteria, $separator . ' |— ');
        }
        return $newList;
    }

    /**
     * For Navigation GetPages.
     *
     * @param array $criteria
     * @return array
     */
    public function findByParentRecursive($criteria = array())
    {
        $orderBy = array(
            'numberOrder' => 'ASC',
            'label' => 'ASC',
            'id' => 'ASC'
        );

        $list = $this->findBy($criteria, $orderBy);

        $newList = array();
        foreach($list as $key => $object) {

            $criteria['parent'] = $object->getId();

            $newList[] = array(
                'label' => $object->getLabel(),
                'route' => $object->getRoute(),
                'controller' => $object->getController(),
                'action' => $object->getNameAction(),
                'resource' => $object->getResourceNamespace(),
                'privilege' => $object->getPrivilege(),
                'uri' => $object->getUri(),
                'target' => $object->getTarget(),
                'title' => $object->getTitle(),
                'visible' => ($object->getVisible() == 1 ? true : false),
                'params' => $object->getParams() ? unserialize($object->getParams()) : null,
                'pages' => $this->findByParentRecursive($criteria)
            );
        }
        return $newList;
    }

    public function findByParentRecursiveArray($parent = array(), $withRole = false)
    {
        $orderBy = array(
            'numberOrder' => 'ASC',
            'label' => 'ASC',
            'id' => 'ASC'
        );

        $list = $this->findBy($parent, $orderBy);

        $index = 0;
        $newList = array();
        foreach($list as $key => $object) {

            $toArray = $object->toArray();

            if ($withRole == false) {
                unset($toArray['role']);
            }

            $newList[$object->getId()] = $toArray;
            $newList[$object->getId()]['label'] = $toArray['label'];
            $newList[$object->getId()]['children'] = $this->findByParentRecursiveArray(array('parent' => $object->getId()));

        }

        return $newList;
    }
}
