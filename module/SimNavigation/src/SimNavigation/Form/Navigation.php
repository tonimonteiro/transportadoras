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
 * @category   Anuncio.php
 * @package    BrAnuncio\Form
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd     New BSD License
 */
namespace SimNavigation\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Zend\Form\Element\Csrf;

class Navigation extends Form implements ServiceLocatorAwareInterface, InputFilterProviderInterface
{

    protected $serviceLocator;

    protected $objectManager;

    public function __construct(ServiceLocator $serviceLocator, $name = null, $options = array())
    {
        parent::__construct($name, $options);

        /**
         * Setting service locator.
         */
        $this->setServiceLocator($serviceLocator);

        /**
         * Config params.
         */
        $config = $this->getServiceLocator()->get('Config');

        /**
         * Setting objectManager.
         */
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        /**
         * Definition form attributes.
         */
        $this->setAttribute('method', 'post')
            ->setHydrator(new ClassMethods())
            ->setInputFilter(new NavigationFilter());

        /**
         * Definition form fields.
         */
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden'
            )
        ));

        $this->add(array(
            'name' => 'nameAction',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'nameAction',
            ),
            'options' => array(
                'label' => 'Action'
            )
        ));

        $this->add(array(
            'name' => 'nameGroup',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'nameGroup'
            ),
            'options' => array(
                'label' => 'Grupo de Navegação',
                'empty_option' => 'Selecione',
                'value_options' => $config['params']['navigation'],
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'parent',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'parent',
            ),
            'options' => array(
                'disable_inarray_validator' => true,
                'empty_option' => 'Selecione',
                'label' => 'Abaixo de',
                'value_options' => array()
            )
        ));

        $this->add(array(
            'name' => 'controller',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'controller'
            ),
            'options' => array(
                'label' => 'Controller'
            )
        ));

        $this->add(array(
            'name' => 'route',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'route'
            ),
            'options' => array(
                'label' => 'Route'
            )
        ));

        $this->add(array(
            'name' => 'resource',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'resource'
            ),
            'options' => array(
                'label' => 'Módulo/Página'
            )
        ));

        $this->add(array(
            'name' => 'label',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'label'
            ),
            'options' => array(
                'label' => 'Título/Nome/Label'
            )
        ));

        $this->add(array(
            'name' => 'fragment',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'fragment'
            ),
            'options' => array(
                'label' => 'Âncora (Fragment)'
            )
        ));

        $this->add(array(
            'name' => 'identification',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'identification'
            ),
            'options' => array(
                'label' => 'Id'
            )
        ));

        $this->add(array(
            'name' => 'class',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'class'
            ),
            'options' => array(
                'label' => 'Class'
            )
        ));

        $this->add(array(
            'name' => 'title',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'title'
            ),
            'options' => array(
                'label' => 'Title'
            )
        ));

        $this->add(array(
            'name' => 'target',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'target'
            ),
            'options' => array(
                'label' => 'Target'
            )
        ));

        $this->add(array(
            'name' => 'rel',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'rel'
            ),
            'options' => array(
                'label' => 'Rel'
            )
        ));

        $this->add(array(
            'name' => 'rev',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'rev'
            ),
            'options' => array(
                'label' => 'Rev'
            )
        ));

        $this->add(array(
            'name' => 'numberOrder',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'numberOrder'
            ),
            'options' => array(
                'label' => 'Order'
            )
        ));

        $this->add(array(
            'name' => 'active',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'active'
            ),
            'options' => array(
                'label' => 'Ativo',
                'empty_option' => 'Selecione',
                'value_options' => $config['params']['sn'],
            )
        ));

        $this->add(array(
            'name' => 'visible',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'visible'
            ),
            'options' => array(
                'label' => 'Visível',
                'empty_option' => 'Selecione',
                'value_options' => $config['params']['sn'],
            )
        ));

        $this->add(array(
            'name' => 'params',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'params'
            ),
            'options' => array(
                'label' => 'Params'
            )
        ));

        $this->add(array(
            'name' => 'uri',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'uri'
            ),
            'options' => array(
                'label' => 'Uri'
            )
        ));

        $this->add(array(
            'name' => 'registeredBy',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'registeredBy',
                'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => 'Registrado Por'
            )
        ));

        $this->add(array(
            'name' => 'registeredIn',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'registeredIn',
                'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => 'Registrado Em'
            )
        ));

        $this->add(array(
            'name' => 'modifiedBy',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'modifiedBy',
                'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => 'Modificado Por'
            )
        ));

        $this->add(array(
            'name' => 'modifiedIn',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'modifiedIn',
                'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => 'Modificado Em'
            )
        ));

        $this->add(new Csrf('security'));

        $this->add(array(
            'name' => 'save',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'class' => 'btn btn-success',
                'value' => 'Salvar Dados'
            )
        ));

        $this->add(array(
            'name' => 'saveInsert',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'class' => 'btn btn-success',
                'value' => 'Salvar e Inserir Próximo'
            )
        ));
    }

    /**
     *
     * @return multitype:multitype:boolean
     */
    public function getInputFilterSpecification()
    {
        $noRequired = array();
        foreach ($this->getElements() as $name) {

            if (empty($name->getAttributes()['required'])) {
                $noRequired[$name->getAttributes()['name']] = array('required' => false);
            }
        }

        return $noRequired;
    }
	/* (non-PHPdoc)
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
     */
    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

	/* (non-PHPdoc)
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

}
