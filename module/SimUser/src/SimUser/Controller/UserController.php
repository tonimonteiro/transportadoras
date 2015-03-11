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
namespace SimUser\Controller;

use SimBase\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use SimUser\Form\User;

class UserController extends AbstractController
{

    /**
     * Implements construct.
     */
    public function __construct()
    {
        $this->setForm('SimUser\Form\User');
        $this->setService('SimUser\Service\User');
        $this->setEntity('SimUser\Entity\User');
        $this->setRoute('simuser-admin/default');
        $this->setController('user');
        $this->setPrimaryKey('id');

        $this->setItemPerPage(10);
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

        $list['keyword'] = array(
            'name' => 'Nome'
        );

        return $list;
    }


    public function editAction()
    {
        $form = new User($this->getServiceLocator());
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

            // all data.
            $toArray = $entity->toArray();

            // setting password generic
            $toArray['password'] = '@1x1x1x@';

            // setting data
            $form->setData($toArray);
        }

        if ($request->isPost()) {

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $data = $form->getData();

                if ($data['password'] == '@1x1x1x@') {
                    unset($data['password']);
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
