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
 * @category   Acl.php
 * @package    Permission
 * @subpackage Acl
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd      New BSD License
 */
namespace SimAcl\Permission;

use Zend\Permissions\Acl\Acl as ZendAcl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
use SimAcl;

class Acl extends ZendAcl
{
    protected $roles;

    /**
     *
     * @param array $role
     */
    public function __construct(array $role)
    {
        $this->role = $role;
        $this->loadRole();
    }

	protected function loadRole()
    {
        foreach ($this->role as $role) {
            /* @var $role SimAcl\Entity\Role  */
            if ($role->getRole()) {
                $this->addRole(new Role($role->getName()), new Role($role->getRole()->getName()));
            } else {
                $this->addRole(new Role($role->getName()));
            }

            $this->loadResource($role->getNavigation());
            $this->loadPrivilege($role->getName(), $role->getNavigation());

            if ($role->getIsAdmin() == 1) {
                $this->allow($role->getName(), array(), array());
            }
        }
    }

    protected function loadResource($navigation)
    {
        $resourceName = '';
        foreach ($navigation as $resource) {
            if (! $this->hasResource($resource->getResourceNamespace())) {
                $this->addResource(new Resource($resource->getResourceNamespace()));
            }
        }
    }

    protected function loadPrivilege($roleName, $navigation)
    {
        foreach ($navigation as $privilege) {
            $this->allow($roleName, $privilege->getResourceNamespace(), $privilege->getPrivilege());
        }
    }
}
