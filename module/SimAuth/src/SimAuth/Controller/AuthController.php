<?php
namespace SimAuth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use SimAuth\Form\Login;

class AuthController extends AbstractActionController
{
    protected $entity;

    protected $adapter;

    protected $sessionName;

    protected $toRoute;

    protected $toRouteParams;

	/**
     * Gets the $entity.
     *
     * @return field_type
     */
    public function getEntity()
    {
        return $this->entity;
    }

	/**
     * Sets the $entity.
     *
     * @param field_type $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
        return $this;
    }

	/**
     * Gets the $adapter.
     *
     * @return field_type
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

	/**
     * Sets the $adapter.
     *
     * @param field_type $adapter
     */
    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;
        return $this;
    }

	/**
     * Gets the $sessionName.
     *
     * @return field_type
     */
    public function getSessionName()
    {
        return $this->sessionName;
    }

	/**
     * Sets the $sessionName.
     *
     * @param field_type $sessionName
     */
    public function setSessionName($sessionName = '')
    {
        $this->sessionName = $sessionName;
        return $this;
    }

	/**
     * Gets the $toRoute.
     *
     * @return field_type
     */
    public function getToRoute($index)
    {
        if (empty($this->toRoute[$index])) {
            throw new \Exception('Index or key does not exist');
        }
        return $this->toRoute[$index];
    }

	/**
     * Sets the $toRoute.
     *
     * @param field_type $toRoute
     */
    public function setToRoute(array $toRoute)
    {
        $this->toRoute = $toRoute;
        return $this;
    }

	/**
     * Gets the $toRouteParams.
     *
     * @return field_type
     */
    public function getToRouteParams()
    {
        return $this->toRouteParams;
    }

	/**
     * Sets the $toRouteParams.
     *
     * @param field_type $toRouteParams
     */
    public function setToRouteParams(array $toRouteParams)
    {
        $this->toRouteParams = $toRouteParams;
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
     */
	public function indexAction()
    {
        $form = new Login();
        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $data = $request->getPost()->toArray();

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

                    $sessionStorage->write($auth->getIdentity()['credentials'], null);
                    return $this->redirect()->toRoute($this->getToRoute('login'), $this->getToRouteParams());

                } else {
                    $this->flashMessenger()->setNamespace('danger')->addMessage('Falhou sua tentativa de login!');
                }
            }
        }

        return new ViewModel(array('form' => $form));
    }

    public function logoutAction()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new SessionStorage($this->getSessionName()));
        $auth->clearIdentity();

        return $this->redirect()->toRoute($this->getToRoute('logout'));
    }
}
