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
namespace SimAcl\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use SimNavigation\Form\ParentSelect;

class Role extends Form implements ServiceLocatorAwareInterface, InputFilterProviderInterface
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
         * Definition translate.
         */
        $this->setParent($options);

        $this->setAttribute('method', 'post');

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
                'label' => 'Nome'
            )
        ));

        $this->add(array(
            'name' => 'parent',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'parent'
            ),
            'options' => array(
                'label' => 'Herda',
                'empty_option' => 'Nenhum',
                'value_options' => $this->getParent()
            )
        ));

        $this->add(array(
            'name' => 'isAdmin',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'isAdmin'
            ),
            'options' => array(
                'label' => 'Administrador?',
                'value_options' => $config['params']['sn'],
            )
        ));

        /**
         * Test.
         */

        $listParents = $objectManager->getRepository('SimNavigation\Entity\Navigation')->findByParent(array('parent' => null));

        $this->add(array(
            'name' => 'navigation',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'class' => 'form-control',
                'multiple' => 'multiple',
                'style' => 'height: 300px'
            ),
            'options' => array(
                'object_manager' => $objectManager,
                'target_class'   => 'SimNavigation\Entity\Navigation',
                'label' => '',
                'value_options' => ParentSelect::getOptionSelect($listParents),
            )
        ));

//         $this->add(array(
//             'type' => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
//             'name' => 'navigation',
//             'options' => array(
//                 'label_attributes' => array(
//                     'class' => 'checkbox'
//                 ),
//                 'object_manager' => $objectManager,
//                 'target_class'   => 'SimNavigation\Entity\Navigation',
//                 'property'       => 'label',
//                 'is_method'      => true,
//                 'label_generator'  =>  function($target){
//                     return  '  ' . $target->getLabel();
//                 },
//                 'find_method'    => array(
//                 'name'   => 'findByParentNull',
// //                 'params' => array(
// //                     'criteria' => array('parent' => 11),
// //                 ),
//                 ),
//             ),
//         ));

        /**
         * End.
         */

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'class' => 'btn btn-success',
                'value' => 'Salvar Dados'
            )
        ));
    }

    /**
     *
     * @return the $parent
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     *
     * @param string $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
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
