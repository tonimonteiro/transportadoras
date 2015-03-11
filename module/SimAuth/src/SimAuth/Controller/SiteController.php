<?php
namespace SimAuth\Controller;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use SimAuth\Form\Login;

class SiteController extends AuthController
{
    public function __construct()
    {
    	$this->setEntity('\\BrEmpresa\\Entity\\Empresa');
    	$this->setAdapter('\\SimAuth\\Auth\\Adapter');
    	$this->setToRoute(array('login' => 'site', 'logout' => 'site'));
    	$this->setToRouteParams(array('controller' => 'index', 'action' => 'index'));
    }

    /**
     * (non-PHPdoc)
     * @see \SimAuth\Controller\AuthController::getSessionName()
     */
    public function getSessionName()
    {
        $config = $this->getServiceLocator()->get('config');
        return $config['params']['session']['site'];
    }

    public function indexAction()
    {
        // form
        $form = new Login();

        // view helper
        $helper = $this->getServiceLocator()->get('ViewHelperManager')->get('Login');

        // request
        $request = $this->getRequest();

        // response
        $response = $this->getResponse();

        if ($request->isPost()) {

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $data = $request->getPost();

                // Criando Storage para gravar sessão da authtenticação
                $sessionStorage = new SessionStorage($this->getSessionName());

                $auth = new AuthenticationService();
                $auth->setStorage($sessionStorage); // Definindo o SessionStorage para a auth

                $authAdapter = $this->getServiceLocator()->get("\\SimAuth\\Auth\\Adapter");
                $authAdapter->setEntity($this->getEntity());
                $authAdapter->setUsername($data['username']);
                $authAdapter->setPassword($data['password']);

                $result = $auth->authenticate($authAdapter);

                if ($result->isValid()) {

                    $identify = $auth->getIdentity();
                    $credentials = $identify['credentials']->toArray();
                    $sessionStorage->write($credentials);

                    // setting content return
                    $content = array(
                        'success' => '1',
                        'content' => $helper->getReleased()
                    );
                    $response->setContent(json_encode($content));

                } else {
                    $this->flashMessenger()->setNamespace('warning')->addMessage('Informações inválidas!');

                    $content = array(
                    	'error' => '1',
                        'content' => $helper->getFormLogin()
                    );
                    $response->setContent(json_encode($content));
                }
            }
        } else {
            $response->setContent($helper->getFormLogin());
        }

        return $response;
    }
}
