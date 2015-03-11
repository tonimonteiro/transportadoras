<?php
namespace SimAuth\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

class UserIdentity extends AbstractHelper
{

    protected $authService;

    /**
     *
     * @return \Zend\Authentication\AuthenticationService
     */
    public function getAuthService()
    {
        return $this->authService;
    }

    /**
     *
     * @param string $namespace
     * @return Ambigous <\Zend\Authentication\mixed, NULL, \Zend\Authentication\Storage\mixed>|boolean
     */
    public function __invoke($namespace = null)
    {
        $sessionStorage = new SessionStorage($namespace);
        $this->authService = new AuthenticationService();
        $this->authService->setStorage($sessionStorage);

        if ($this->getAuthService()->hasIdentity()) {
            return $this->getAuthService()->getIdentity();
        } else
            return array();
    }
}
