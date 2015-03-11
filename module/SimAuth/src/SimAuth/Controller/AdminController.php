<?php
namespace SimAuth\Controller;

class AdminController extends AuthController
{

    public function __construct()
    {
        $this->setEntity('\\SimUser\\Entity\\User');
        $this->setAdapter('\\SimAuth\\Auth\\Adapter');
        $this->setToRoute(array(
            'login' => 'admin/default',
            'logout' => 'simauth-admin'
        ));
        $this->setToRouteParams(array(
            'controller' => 'index',
            'action' => 'index'
        ));
    }

    /**
     * (non-PHPdoc)
     *
     * @see \SimAuth\Controller\AuthController::getSessionName()
     */
    public function getSessionName()
    {
        $config = $this->getServiceLocator()->get('Config');
        return $config['params']['session']['administrator'];
    }
}
