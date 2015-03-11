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
namespace SimUser\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;

class User extends Form implements ServiceLocatorAwareInterface, InputFilterProviderInterface
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
        $this->setAttribute('method', 'post')->setHydrator(new ClassMethods())->setInputFilter(new UserFilter());

        /**
         * Definition form fields.
        */
        $this->add(array('name' => 'id','attributes' => array('type' => 'hidden')));

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
                'label' => 'Nome'
            )
        ));

        $this->add(array(
            'name' => 'email',
            'type' => 'Zend\Form\Element\Email',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'email'
            ),
            'options' => array(
                'label' => 'Email'
            )
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'role',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'role',
                'required' => 'required'
            ),
            'options' => array(
                'object_manager' => $objectManager,
                'target_class' => '\SimAcl\Entity\Role',
                'property' => 'name',
                'empty_option' => 'Selecione',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array(
                            'id' => 'ASC'
                        )
                    )
                ),
                'label_attributes' => array(
                    'class' => 'control-label required'
                ),
                'label' => 'Acesso'
            )
        ));

        $this->add(array(
            'name' => 'username',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'username',
                'required' => 'required',
            ),
            'options' => array(
                'label_attributes' => array(
                    'class' => 'control-label required'
                ),
                'label' => 'Usuário'
            )
        ));

        $this->add(array(
            'name' => 'password',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'password',
                'type' => 'password'
            ),
            'options' => array(
                'label_attributes' => array(
                    'class' => 'control-label required'
                ),
                'label' => 'Senha'
            )
        ));

        $this->add(array(
            'name' => 'active',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'active',
                'required' => 'required',
                'value' => '1'
            ),
            'options' => array (
                'label_attributes' => array(
                    'class' => 'control-label required'
                ),
                'label' => 'Ativo',
                'value_options' => $config['params']['sn'],
            )
        ));

        $this->add(array(
            'name' => 'expireIn',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control date',
                'id' => 'expire_in'
            ),
            'options' => array(
                'label' => 'Expirar em',
                'format' => 'd/m/Y'
            )
        ));

        $this->add(new Element\Csrf('security'));

        $this->add(array(
            'name' => 'save',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'class' => 'btn btn-success',
                'value' => 'Salvar'
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
