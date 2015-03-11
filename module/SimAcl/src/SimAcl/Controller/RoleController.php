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
 * @package    Controller
 * @subpackage RoleController
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd      New BSD License
 */
namespace SimAcl\Controller;

use SimBase\Controller\AbstractController;

class RoleController extends AbstractController
{

    /**
     * Implements construct.
     */
    public function __construct()
    {
        $this->setForm('SimAcl\Form\Role');
        $this->setService('SimAcl\Service\Role');
        $this->setEntity('SimAcl\Entity\Role');
        $this->setRoute('simacl-admin/default');
        $this->setController('role');
        $this->setPrimaryKey('id');

        $this->setItemPerPage(10);
    }

    public function testAction()
    {
        $acl = $this->getServiceLocator()->get('SimAcl\Permission\Acl');

        echo $acl->isAllowed("Redator", "Posts", "Excluir") ? "Permitido" : "Negado";
        die();
    }
}
