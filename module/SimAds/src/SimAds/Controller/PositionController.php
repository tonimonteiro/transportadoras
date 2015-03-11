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
 * @category   PositionController.php
 * @package    Controller
 * @subpackage IndexController
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd      New BSD License
 */
namespace SimAds\Controller;

use SimBase\Controller\AbstractController;

class PositionController extends AbstractController
{

    /**
     * Implements construct.
     */
    public function __construct()
    {
        $this->setForm('SimAds\Form\Position');
        $this->setService('SimAds\Service\Position');
        $this->setEntity('SimAds\Entity\Position');
        $this->setRoute('simads-admin/default');
        $this->setController('position');
        $this->setParamId('id');
        $this->setPrimaryKey('id');

        $this->setItemPerPage(10);
    }

    /**
     * (non-PHPdoc)
     * @see \SimBase\Controller\AbstractController::getSearchFilters()
     */
    public function getSearchFilters()
    {
        // Getting params config.
        $config = $this->getServiceLocator()->get('Config');

        $list['list'] = array(
            'active' => array(
                'label' => 'Situação (Todos)',
                'option' => $config['params']['sn']
            ),
        );

        $list['keyword'] = array(
            'name' => 'Nome',
        );

        return $list;
    }
}
