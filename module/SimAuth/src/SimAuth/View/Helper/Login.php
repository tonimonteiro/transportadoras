<?php
namespace SimAuth\View\Helper;

use Zend\View\Helper\AbstractHelper;
use SimAuth\Form\Login as FormLogin;

class Login extends AbstractHelper
{

    public function getReleased()
    {
        $view = $this->getView();
        return $view->render('sim-auth/site/released.phtml');
    }

    public function getFormLogin()
    {
        $view = $this->getView();
        return $view->render('sim-auth/site/index.phtml', array('form' => new FormLogin() ));
    }

}