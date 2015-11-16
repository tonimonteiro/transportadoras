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
namespace SisCep\Controller;

use SimBase\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use SisCep\Form\Cep;

class CepController extends AbstractController
{

    /**
     * Implements construct.
     */
    public function __construct()
    {
        $this->setForm('SisCep\Form\Cep');
        $this->setService('SisCep\Service\Cep');
        $this->setEntity('SisCep\Entity\Cep');
        $this->setRoute('admin-siscep/default');
        $this->setController('cep');
        $this->setPrimaryKey('id');

        $this->setItemPerPage(10);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \SimBase\Controller\AbstractController::getSearchFilters()
     */
    public function getSearchFilters()
    {
        // Getting params config.
        $config = $this->getServiceLocator()->get('Config');

        $list['keyword'] = array(
            'cepInicial' => 'Faixa inicial',
            'cepFinal' => 'Faixa final'
        );

        return $list;
    }

}
