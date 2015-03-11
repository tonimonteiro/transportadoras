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
 * @category   MediaController.php
 * @package    Controller
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd      New BSD License
 */
namespace SimAds\Controller;

use SimBase\Controller\AbstractController;
use SimAds\Form\Media;
use Zend\View\Model\ViewModel;

class MediaController extends AbstractController
{

    /**
     * Implements construct.
     */
    public function __construct()
    {
        $this->setForm('SimAds\Form\Media');
        $this->setService('SimAds\Service\Media');
        $this->setEntity('SimAds\Entity\Media');
        $this->setRoute('simads-admin/default');
        $this->setController('media');
        $this->setPrimaryKey('id');
        $this->setParamId('id');

        $this->setItemPerPage(15);
    }

    /**
     * (non-PHPdoc)
     * @see \SimBase\Controller\AbstractController::getSearchFilters()
     */
    public function getSearchFilters()
    {
        // Getting params config.
        $config = $this->getServiceLocator()->get('Config');

        $list['list'] = array(
            'active' => array(
                'label' => 'Situação (Todos)',
                'option' => $config['params']['sn']
            ),
        );

        $list['keyword'] = array(
            'name' => 'Nome',
        );

        return $list;
    }


    public function newAction()
    {
        $form = new Media($this->getServiceLocator());

        $request = $this->getRequest();

        if ($request->isPost()) {

            $post = array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());

            /**
             * Somente Eletrosul.
             */
            $post['dateEntry'] = date('d/m/Y H:i:s');

            $form->setData($post);

            if ($form->isValid()) {

                $data = $form->getData();

                if (! empty($data['file']['name'])) {
                    $mediaFileName = $form->getInputFilter()->getValue('file');
                    $data['mediaFile'] = str_replace('./public', '', $mediaFileName['tmp_name']);
                }

                $service = $this->getServiceLocator()->get($this->getService());

                if ($service->insert($data)) {
                    $this->flashMessenger()
                    ->setNamespace('info')
                    ->addMessage('<strong>Registro inserido com sucesso!</strong>');
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
            'form' => $form
        ));
    }

    public function editAction()
    {
        $form = new Media($this->getServiceLocator());

        $request = $this->getRequest();

        /**
         * Get param id.
        */
        $param = $this->params()->fromRoute($this->getParamId(), 0);

        if (empty($param)) {
            $requestPost = $request->getPost()->toArray();
            $param = $requestPost[$this->getPrimaryKey()];
        }

        /**
         * Load class entity.
         */
        $entity = $this->getEntityManager()
                        ->getRepository($this->getEntity())
                        ->find($param);
        $entity = $entity->toArray();

        /**
         * Define last path saved.
        */
        $lastPath = $entity['mediaFile'];

        if ($param > 0) {
            $form->setData($entity);
        }

        if ($request->isPost()) {

            $post = array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());

            /**
             * Somente Eletrosul.
             */
            $post['dateEntry'] = date('d/m/Y H:i:s');

            $form->setData($post);

            if ($form->isValid()) {

                $data = $form->getData();

                if (! empty($data['file']['name'])) {
                    $mediaFileName = $form->getInputFilter()->getValue('file');

                    if (! empty($lastPath)) {
                        unlink('./public' . $lastPath);
                    }
                    $data['mediaFile'] = str_replace('./public', '', $mediaFileName['tmp_name']);
                } else {
                    $data['mediaFile'] = $lastPath;
                }

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
}
