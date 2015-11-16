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
 * @category   AbstractController.php
 * @package    SimBase\Controller
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd     New BSD License
 */
namespace SimBase\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;

/**
 * Class AbstractController
 *
 * @package SimBase\Controller
 *
 */
abstract class AbstractController extends AbstractActionController
{

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     *
     * @var string
     */
    protected $entity;

    /**
     *
     * @var string object
     */
    protected $form;

    /**
     *
     * @var string
     */
    protected $controller;

    /**
     *
     * @var string
     */
    protected $route;

    /**
     *
     * @var string
     */
    protected $service;

    /**
     *
     * @var integer
     */
    protected $primaryKey;

    /**
     *
     * @var integer
     */
    protected $paramId;

    /**
     *
     * @var integer
     */
    protected $itemPerPage;

    /**
     *
     * @var string
     */
    protected $message;

    /**
     * Abstract contruct.
     */
    abstract function __construct();

    /**
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        if ($this->entityManager == null) {
            $this->setEntityManager($this->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager'));
        }

        return $this->entityManager;
    }

    /**
     *
     * @param object $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     *
     * @return the $entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     *
     * @param \Base\Controller\unknown $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     *
     * @return the $form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     *
     * @param
     *            Ambigous <string, object> $form
     */
    public function setForm($form)
    {
        $this->form = $form;
    }

    /**
     *
     * @return the $controller
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     *
     * @param string $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     *
     * @return the $route
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     *
     * @param string $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
    }

    /**
     *
     * @return the $service
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     *
     * @param string $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     *
     * @return the $primaryKey
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     *
     * @param number $primaryKey
     */
    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;
    }

    /**
     *
     * @return the $paramId
     */
    public function getParamId()
    {
        if (empty($this->paramId)) {
            return $this->getPrimaryKey();
        }
        return $this->paramId;
    }

    /**
     *
     * @param number $paramId
     */
    public function setParamId($paramId)
    {
        $this->paramId = $paramId;
        return $this;
    }

    /**
     *
     * @return the $itemPerPage
     */
    public function getItemPerPage()
    {
        return $this->itemPerPage;
    }

    /**
     *
     * @param number $itemPerPage
     */
    public function setItemPerPage($itemPerPage)
    {
        $this->itemPerPage = $itemPerPage;
    }

    /**
     *
     * @return the $message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     *
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Gets the $searchFilters.
     *
     * @return multitype:
     */
    public function getSearchFilters()
    {
        return false;
    }

    /**
     *
     * @return string
     */
    private function getSearchSessionName()
    {
        return $this->getController() . 'index';
    }

    /**
     * Gets the $searchSession.
     *
     * @return field_type
     */
    public function getSearchSession()
    {
        $session = $this->getServiceLocator()->get('SessionAdminSearch');
        $arrayCopy = $session->getArrayCopy();

        if (! empty($arrayCopy[$this->getSearchSessionName()])) {
            return $arrayCopy[$this->getSearchSessionName()];
        }
        return false;
    }

    /**
     *
     * @param unknown $search
     * @return \SimBase\Controller\AbstractController
     */
    protected function setSearchSession($search = '')
    {
        $session = $this->getServiceLocator()->get('SessionAdminSearch');
        $session[$this->getSearchSessionName()] = serialize($search);

        return $this;
    }

    public function unsetSearchAction()
    {
        $session = $this->getServiceLocator()->get('SessionAdminSearch');
        $session->offsetUnset($this->getSearchSessionName());

        return $this->redirect()->toRoute($this->getRoute(), array(
            'controller' => $this->getController(),
            'action' => 'index'
        ));
    }

    public function getWhereSession()
    {
        $session = unserialize($this->getSearchSession());
        if (empty($session)) {
            return false;
        }

        $criteria = array();
        $parameters = array();

        if (! empty($session['filter'])) {
            foreach ($session['filter'] as $field => $value) {
                if ($value != '') {
                    $criteria[$field] = 'a.' . $field . ' = :' . $field;
                    $parameters[$field] = $value;
                }
            }
        }

        if (! empty($session['keyword-search'])) {
            $criteria[$session['keyword-field']] = 'a.' . $session['keyword-field'] . ' LIKE :' . $session['keyword-field'];
            $parameters[$session['keyword-field']] = '%' . $session['keyword-search'] . '%';
        }

        $criteria = implode(' AND ', $criteria);
        return array(
            'where' => $criteria,
            'parameters' => $parameters
        );
    }

    /**
     * List data.
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        /**
         * Search definition.
         */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();
            $this->setSearchSession($post);
        }

        $query = $this->getEntityManager()
            ->getRepository($this->getEntity())
            ->createQueryBuilder('a');

        $search = $this->getWhereSession();
        if (! empty($search['where'])) {
            $query->where($search['where']);
            $query->setParameters($search['parameters']);
        }

        /**
         * Order definition.
         */
        if ($this->params()->fromQuery('order')) {
            $query->orderBy('a.' . $this->params()
                  ->fromQuery('order'), $this->params()
                  ->fromQuery('sort'));
        }

        /**
         * List data.
         */
        $list = $query->getQuery()->getResult();

        /**
         * Show data and pagination.
         */
        $page = $this->params()->fromRoute('page');

        $paginator = new Paginator(new ArrayAdapter($list));
        $paginator->setCurrentPageNumber($page)->setDefaultItemCountPerPage($this->getItemPerPage());

        /**
         * Return.
         */
        return new ViewModel(array(
            'data' => $paginator,
            'page' => $page,
            'searchFilters' => $this->getSearchFilters(),
            'params' => $this->getServiceLocator()->get('config')['params']
        ));
    }

    public function newAction()
    {
        if (is_string($this->getForm())) {

            $instanceForm = $this->getForm();
            $form = new $instanceForm($this->getServiceLocator());
        } else {

            $form = $this->getForm($this->getServiceLocator());
        }

        $request = $this->getRequest();

        /**
         * If post, continue.
         */
        if ($request->isPost()) {

            /**
             * Set data post.
             */
            $form->setData($request->getPost());

            /**
             * Validation.
             */
            if ($form->isValid()) {
                /**
                 * Getting service.
                 */
                $service = $this->getServiceLocator()->get($this->getService());

                /**
                 * Convert data post to array and save data.
                 */
                // if ($service->insert($request->getPost()->toArray())) {
                if ($service->insert($form->getData())) {
                    $this->flashMessenger()
                    ->setNamespace('info')
                    ->addMessage('<strong>Registro inserido com sucesso!</strong>');
                }

                /**
                 * Redirect.
                 */
                return $this->redirect()->toRoute($this->getRoute(), array(
                    'controller' => $this->getController(),
                    'action' => 'index'
                ));
            } else {
                $this->flashMessenger()
                ->setNamespace('danger')
                ->addMessage('<strong>Ops!</strong><br>Verifique os campos marcados como obrigatórios!');
            }
        }

        /**
         * Params config.
         */
        $params = $this->getServiceLocator()->get('config')['params'];

        /**
         * Return form.
         */
        return new ViewModel(array(
            'form' => $form,
            'params' => $params
        ));
    }

    public function editAction()
    {
        if (is_string($this->getForm())) {

            $instanceForm = $this->getForm();
            $form = new $instanceForm($this->getServiceLocator());
        } else {

            $form = $this->getForm($this->getServiceLocator());
        }

        $request = $this->getRequest();

        /**
         * Get param id.
         */
        $param = $this->params()->fromRoute($this->getParamId(), 0);

        /**
         * Load class entity.
         */
        $entity = $this->getEntityManager()
            ->getRepository($this->getEntity())
            ->find($param);

        if ($param > 0) {
            $form->setData($entity->toArray());
        }

        if ($request->isPost()) {

            $form->setData($request->getPost());

            if ($form->isValid()) {
                // $data = $request->getPost()->toArray();
                $data = $form->getData();

                $service = $this->getServiceLocator()->get($this->getService());

                if ($service->update($data, $data[$this->getPrimaryKey()])) {
                    $this->flashMessenger()
                    ->setNamespace('info')
                    ->addMessage('<strong>Registro atualizado com sucesso!</strong>');
                }

                /**
                 * Redirect.
                 */
                return $this->redirect()->toRoute($this->getRoute(), array(
                    'controller' => $this->getController(),
                    'action' => 'index'
                ));
            } else {
                $this->flashMessenger()
                ->setNamespace('danger')
                ->addMessage('<strong>Ops!</strong><br>Verifique os campos marcados como obrigatórios!');
            }
        }

        return new ViewModel(array(
            'form' => $form,
            'id' => $param
        ));
    }

    public function removeAction()
    {
        $service = $this->getServiceLocator()->get($this->getService());

        $id = (int) $this->params()->fromRoute($this->getParamId(), 0);

        if ($service->remove(array(
            $this->getPrimaryKey() => $id
        ))) {
            $this->flashMessenger()
                ->setNamespace('info')
                ->addMessage('<strong>Registro(s) removido(s) com sucesso!</strong>');
        } else {
            $this->flashMessenger()
                ->setNamespace('danger')
                ->addMessage('<strong>Ops!</strong><br>Não foi possível remover o(s) registro(s) selecionado(s)!');
        }

        /**
         * Redirect.
         */
        return $this->redirect()->toRoute($this->getRoute(), array(
            'controller' => $this->getController(),
            'action' => 'index'
        ));
    }

    public function removeResponseAction()
    {
        $request = $this->getRequest();
        $post = $request->getPost();

        if (! empty($post['list'])) {

            $service = $this->getServiceLocator()->get($this->getService());

            foreach ($post['list'] as $key => $id) {

                if ($service->remove(array(
                    $this->getPrimaryKey() => $id
                ))) {
                    $content = array(
                        'success' => '1',
                        'content' => 'Registro(s) removido(s) com sucesso!'
                    );
                } else {
                    $content = array(
                        'error' => '1',
                        'content' => 'Não foi possível remover o(s) registro(s) selecionado(s)!'
                    );
                }
            }
        }

        $response = $this->getResponse();
        $response->setContent(json_encode($content));

        return $response;
    }
}