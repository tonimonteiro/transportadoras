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
 * @category   IndexController.php
 * @package    Controller
 * @subpackage IndexController
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd      New BSD License
 */
namespace SisTransportadora\Controller;

use SimBase\Controller\AbstractController;

class TransportadoraController extends AbstractController
{

    /**
     * TransportadoraController constructor.
     */
    public function __construct()
    {
        $this->setForm('SisTransportadora\Form\Transportadora');
        $this->setService('SisTransportadora\Service\Transportadora');
        $this->setEntity('SisTransportadora\Entity\Transportadora');
        $this->setRoute('admin-transportadora/default');
        $this->setController('transportadora');
        $this->setPrimaryKey('id');

        $this->setItemPerPage(10);
    }

    /**
     * @see \SimBase\Controller\AbstractController::getSearchFilters()
     * @return mixed
     */
    public function getSearchFilters()
    {
        // Getting params config.
        $config = $this->getServiceLocator()->get('Config');

        $list['keyword'] = array(
            'nome' => 'Nome'
        );

        return $list;
    }
}
