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

namespace SimCms\Entity;

use Doctrine\ORM\EntityRepository;

class CmsRepository extends EntityRepository
{
    public function getList($navigation, $limit = -1, $offset = false)
    {
        $whereNavigation = 'c.navigationName = :param1';
        if (is_int($navigation)) {
        	$whereNavigation = 'c.navigation = :param1';
        }
        $param1 = $navigation;

        $query = $this->createQueryBuilder('c');
        $query->add('select', 'c')
        ->add('from', 'SimCms\Entity\Cms c')
        ->add('where', $whereNavigation . ' AND c.state = :param3 AND c.entry <= :param2 AND (c.output >= :param2 OR c.output is null)')
        ->add('orderBy', 'c.entry DESC')
        ->setParameter('param1', $param1)
        ->setParameter('param2', date('Y-m-d H:i:s'))
        ->setParameter('param3', 1)
        ->setFirstResult($offset);

        if ($limit > 0) {
            $query->setMaxResults($limit);
        }

        /*
        echo '<pre>';
        print_r($query->getQuery()->getSQL());
        die;
        */

        return $query->getQuery()->getResult();
    }
}
