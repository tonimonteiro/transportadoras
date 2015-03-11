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
 * @category   Position.php
 * @package    SimAds\Service
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd     New BSD License
 */
namespace SimAds\Service;

use SimBase\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class Position extends AbstractService
{

    public function __construct(EntityManager $entityManager)
    {
        $this->setEntity('SimAds\Entity\Position');
        parent::__construct($entityManager);
    }
}