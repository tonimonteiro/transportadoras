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
namespace SimNavigation\Controller;

use SimBase\Controller\AbstractController;
use SimNavigation\Form\Navigation;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;
use SimNavigation\Form\ParentSelect;

class NavigationController extends AbstractController
{

    /**
     *
     * @var static array
     */
    private static $navigation = array();

    /**
     *
     * @var static integer
     */
    private static $navigationKey = 0;

    /**
     * Implements construct.
     */
    public function __construct()
    {
        $this->setForm('SimNavigation\Form\Navigation');
        $this->setService('SimNavigation\Service\Navigation');
        $this->setEntity('SimNavigation\Entity\Navigation');
        $this->setRoute('simnavigation-admin/default');
        $this->setController('navigation');
        $this->setPrimaryKey('id');

        $this->setItemPerPage(1000);
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

        $list['list'] = array(
            'nameGroup' => array(
                'label' => 'Grupo Menu (Todos)',
                'option' => $config['params']['navigation']
            )
        );

        return $list;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \SimBase\Controller\AbstractController::indexAction()
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

        $search = $this->getWhereSession();
        $where = array(
            'parent' => - 1
        );
        if (! empty($search['where'])) {
            $where = $search['parameters'];
            $where['parent'] = 1;
        }

        /**
         * List data.
         */
        $list = $this->getEntityManager()
            ->getRepository($this->getEntity())
            ->findByParentRecursiveArray($where);

        $this->renderList($list);

        $page = $this->params()->fromRoute('page');

        $paginator = new Paginator(new ArrayAdapter(self::$navigation));
        $paginator->setCurrentPageNumber($page)->setDefaultItemCountPerPage($this->getItemPerPage());

        return new ViewModel(array(
            'data' => $paginator,
            'page' => $page,
            'searchFilters' => $this->getSearchFilters(),
            'params' => $this->getServiceLocator()->get('config')['params']
        ));
    }

    /**
     * (non-PHPdoc)
     *
     * @see \SimBase\Controller\AbstractController::newAction()
     */
    public function newAction()
    {
        $form = new Navigation($this->getServiceLocator());
        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $service = $this->getServiceLocator()->get($this->getService());

                $data = $form->getData();

                if (empty($data['uri'])) {
                    $data['privilege'] = strtolower($data['nameAction']);
                }

                if (is_array($data['nameAction'])) {

                    $loop = 0;
                    foreach ($data['nameAction'] as $actionId => $actionName) {

                        $data['privilege'] = $actionName;
                        $data['nameAction'] = $actionName;

                        $result = $service->insert($data);

                        if ($loop == 0) {
                            $data['parent'] = $result->getId();
                        }
                        $loop ++;
                    }
                } else {
                    if (empty($data['parent'])) {
                        $data['parent'] = 1;
                    }

                    if (empty($data['controller']) && empty($data['nameAction']) && empty($data['resource']) && empty($data['uri']) && $data['parent'] > 1) {

                        $navigation = $this->getEntityManager()->getRepository('\SimNavigation\Entity\Navigation')
                                                               ->findOneBy(array('id' => $data['parent'], 'active' => 1));
                        $path = $this->Path($navigation);
                        $data['uri'] = ($path['url'] ? $path['url'] : '/') . $this->UrlCustom()->friendly($data['label']);
                    }

                    $service->insert($data);
                }

                $action = 'index';
                if ($data['saveInsert'] != '') {
                    $action = 'new';
                }

                return $this->redirect()->toRoute($this->getRoute(), array(
                    'controller' => $this->getController(),
                    'action' => $action
                ));
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }

    /**
     * (non-PHPdoc)
     *
     * @see \SimBase\Controller\AbstractController::editAction()
     */
    public function editAction()
    {
        $form = new Navigation($this->getServiceLocator());
        $request = $this->getRequest();

        $param = $this->params()->fromRoute($this->getParamId(), 0);
        $entity = $this->getEntityManager()
            ->getRepository($this->getEntity())
            ->find($param);

        if ($param > 0) {
            $form->setData($entity->toArray());
        }

        /**
         * Loading parent with selected nameGroup.
         */
        $parents = $this->getEntityManager()
            ->getRepository($this->getEntity())
            ->findByParent(array(
            'parent' => 1,
            'nameGroup' => $form->get('nameGroup')
                ->getValue()
        ));

        $parentOption = array();
        foreach (ParentSelect::getOptionSelect($parents) as $key => $parent) {
            $parentOption['value_options'][$parent['value']] = $parent['label'];
        }
        $form->get('parent')->setOptions($parentOption);

        /**
         * Verify if posting.
         */
        if ($request->isPost()) {

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $service = $this->getServiceLocator()->get($this->getService());

                $data = $form->getData();

                if (empty($data['uri'])) {
                    $data['privilege'] = strtolower($data['nameAction']);
                }

                if (is_array($data['nameAction'])) {

                    $loop = 0;
                    foreach ($data['nameAction'] as $actionId => $actionName) {

                        $data['privilege'] = $actionName;
                        $data['nameAction'] = $actionName;

                        $result = $service->insert($data);

                        if ($loop == 0) {
                            $data['parent'] = $result->getId();
                        }
                        $loop ++;
                    }
                } else {
                    if (empty($data['parent'])) {
                        $data['parent'] = 1;
                    }

                    if (empty($data['controller']) && empty($data['nameAction']) && empty($data['resource']) && empty($data['uri']) && $data['parent'] > 1) {

                        $navigation = $this->getEntityManager()->getRepository('\SimNavigation\Entity\Navigation')
                                                               ->findOneBy(array('id' => $data['parent'], 'active' => 1));
                        $path = $this->Path($navigation);
                        $data['uri'] = ($path['url'] ? $path['url'] : '/') . $this->UrlCustom()->friendly($data['label']);
                    }

                    $service->update($data, $data[$this->getPrimaryKey()]);
                }

                return $this->redirect()->toRoute($this->getRoute(), array(
                    'controller' => $this->getController(),
                    'action' => 'index'
                ));
            }
        }

        return new ViewModel(array(
            'form' => $form,
            'id' => $param
        ));
    }

    /**
     *
     * @param array $list
     * @param number $level
     */
    private function renderList(array $list, $level = 0)
    {
        $tagSup = '';
        self::$navigationKey ++;

        foreach ($list as $listKey => $listValue) {

            $span = '';

            for ($i = 0; $i < $level; $i ++, $span .= ' <span>.</span> ');

            if ($level > 0) {
                $tagSup = '<sup>L</sup>';
            }

            self::$navigation[self::$navigationKey] = $listValue;
            self::$navigation[self::$navigationKey]['label'] = $span . $tagSup . $listValue['label'];
            $this->renderList($listValue['children'], $level + 5);
        }
    }

    public function nameGroupAction()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();

        if ($request->getMethod() != 'POST') {
            $response->setStatusCode(404);
            return $response;
        }

        $group = $request->getPost();

        try {
            if (isset($group)) {
                $listParents = $this->getEntityManager()
                    ->getRepository($this->getEntity())
                    ->findByParent(array(
                    'parent' => 1,
                    'nameGroup' => $group['data']
                ));

                $list = ParentSelect::getOptionSelect($listParents);
            } else {
                throw new \Exception('Falhou!');
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $response->setStatusCode(200);
        $response->getHeaders()->addHeaders(array(
            'Robots' => 'noindex, nofollow',
            'Content-Type' => 'application/json'
        ));
        $response->setContent(json_encode($list));

        return $response;
    }
}
