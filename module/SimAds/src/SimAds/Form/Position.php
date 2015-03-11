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
namespace SimAds\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Zend\InputFilter\InputFilter;

class Position extends Form implements ServiceLocatorAwareInterface, InputFilterProviderInterface
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
            ->setInputFilter(new InputFilter());

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
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'name',
                'required' => 'required'
            ),
            'options' => array(
                'label_attributes' => array(
                    'class' => 'control-label required'
                ),
                'label' => 'Posição'
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
                'value_options' => $config['params']['sn'],
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

        $this->add(new Element\Csrf('security'));

        $this->add(array(
            'name' => 'send',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'class' => 'btn btn-success',
                'style' => 'display:block',
                'value' => 'Salvar Dados'
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