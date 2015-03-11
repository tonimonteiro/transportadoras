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

namespace SimAds\Entity;

use Doctrine\ORM\EntityRepository;

class MediaRepository extends EntityRepository
{

    public function getList($limit, $position, $order)
    {
        $orderBy = '';
        if (isset($order)) {
        	$orderBy = ' ORDER BY m.' . $order;
        }
        $where = 'm.position = :param2 AND m.active = :param1';

        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery('SELECT m FROM SimAds\Entity\Media m WHERE ' . $where . $orderBy )
                               ->setParameter('param1', 1)
                               ->setParameter('param2', $position)
                               ->setMaxResults($limit);

        $result = $query->getArrayResult();

        if ($orderBy == '') {
            shuffle($result);
        }

        return $result;
    }
}
