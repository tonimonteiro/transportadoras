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
namespace SimCms\Controller;

use SimBase\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use SimCms\Form\Cms;
use SimNavigation\Form\ParentSelect;

class CmsController extends AbstractController
{

    /**
     * Implements construct.
     */
    public function __construct()
    {
        $this->setForm('SimCms\Form\Cms');
        $this->setService('SimCms\Service\Cms');
        $this->setEntity('SimCms\Entity\Cms');
        $this->setRoute('simcms-admin/default');
        $this->setController('cms');
        $this->setPrimaryKey('id');

        $this->setItemPerPage(20);
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
            'state' => array(
                'label' => 'Situação (Todos)',
                'option' => $config['params']['situacao']
            )
        );

        $list['keyword'] = array(
            'title' => 'Título',
            'content' => 'Conteúdo',
            'description' => 'Destaque',
            'navigationName' => 'Página'
        );

        return $list;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \SimBase\Controller\AbstractController::newAction()
     */
    public function newAction()
    {
        $form = new Cms($this->getServiceLocator());
        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $service = $this->getServiceLocator()->get($this->getService());

                $data = $form->getData();

                $navigation = $this->getEntityManager()->find('\SimNavigation\Entity\Navigation', $data['navigation']);
                $path = $this->Path($navigation);
                $navigationName = $this->UrlCustom()->friendly($path['url']);

                $data['navigationName'] = $navigationName;
                $data['url'] = $path['url'] . $this->UrlCustom()->friendly($data['title']);
                $data['urlIndex'] = $this->UrlCustom()->friendly($data['url'], '/', '');
                $data['description'] = html_entity_decode($data['description']);
                $data['content'] = html_entity_decode($data['content']);
                $data['revision'] = 0;

                if ($service->insert($data)) {
                    $this->flashMessenger()
                        ->setNamespace('info')
                        ->addMessage('<strong>Registro inserido com sucesso!</strong>');
                }

                $action = 'index';
                if ($data['saveInsert'] != '') {
                    $action = 'new';
                }

                return $this->redirect()->toRoute($this->getRoute(), array(
                    'controller' => $this->getController(),
                    'action' => $action
                ));
            } else {
                $this->flashMessenger()
                    ->setNamespace('danger')
                    ->addMessage('<strong>Ops!</strong><br>Verifique os campos marcados como obrigatórios!');
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
        $form = new Cms($this->getServiceLocator());
        $request = $this->getRequest();

        $param = $this->params()->fromRoute($this->getParamId(), 0);
        $entity = $this->getEntityManager()
            ->getRepository($this->getEntity())
            ->find($param);

        if ($param > 0) {
            $loadData = $entity->toArray();
            $loadData['navigationName'] = $loadData['navigationRow']['nameGroup'];
            $form->setData($loadData);
        }

        /**
         * Loading parent with selected nameGroup.
         */
        $parents = $this->getEntityManager()
            ->getRepository('\SimNavigation\Entity\Navigation')
            ->findByParent(array(
            'parent' => 1,
            'nameGroup' => $loadData['navigationName']
        ));

        $parentOption = array();
        foreach (ParentSelect::getOptionSelect($parents) as $key => $parent) {
            $parentOption['value_options'][$parent['value']] = $parent['label'];
        }
        $form->get('navigation')->setOptions($parentOption);

        if ($request->isPost()) {

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $data = $form->getData();

                $navigation = $this->getEntityManager()->find('\SimNavigation\Entity\Navigation', $data['navigation']);
                $path = $this->Path($navigation);
                $navigationName = $this->UrlCustom()->friendly($path['url']);

                $data['navigationName'] = $navigationName;
                $data['url'] = $path['url'] . $this->UrlCustom()->friendly($data['title']);
                $data['urlIndex'] = $this->UrlCustom()->friendly($data['url'], '/', '');
                $data['description'] = html_entity_decode($data['description']);
                $data['content'] = html_entity_decode($data['content']);
                $data['revision'] = $data['revision'] + 1;

                $service = $this->getServiceLocator()->get($this->getService());

                if ($service->update($data, $data[$this->getPrimaryKey()])) {
                    $this->flashMessenger()
                        ->setNamespace('info')
                        ->addMessage('<strong>Registro atualizado com sucesso!</strong>');
                }

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
}
