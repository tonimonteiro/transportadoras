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
namespace SisCep\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;

/**
 * Class Cep
 * @package SisCep\Form
 */
class Cep extends Form implements ServiceLocatorAwareInterface, InputFilterProviderInterface
{

    protected $serviceLocator;

    protected $objectManager;

    /**
     * Cep constructor.
     * @param ServiceLocator $serviceLocator
     * @param null $name
     * @param array $options
     */
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
        $this->setAttribute('method', 'post')->setHydrator(new ClassMethods())->setInputFilter(new CepFilter());

        /**
         * Definition form fields.
        */
        $this->add(array('name' => 'id','attributes' => array('type' => 'hidden')));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'transportadora',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'transportadora'
            ),
            'options' => array(
                'object_manager' => $objectManager,
                'target_class' => '\SisTransportadora\Entity\Transportadora',
                'property' => 'nome',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array('ativo' => 1),
                        'orderBy' => array(
                            'id' => 'ASC'
                        )
                    )
                ),
                'label' => 'Transportadora'
            )
        ));

        $this->add(array(
            'name' => 'cepInicial',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'cepInicial',
                'required' => 'required'
            ),
            'options' => array(
                'label_attributes' => array(
                    'class' => 'control-label required'
                ),
                'label' => 'Faixa Inicial'
            )
        ));

        $this->add(array(
            'name' => 'cepFinal',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'cepFinal',
                'required' => 'required'
            ),
            'options' => array(
                'label_attributes' => array(
                    'class' => 'control-label required'
                ),
                'label' => 'Faixa Final'
            )
        ));

        $this->add(array(
            'name' => 'pesoA',
            'type' => 'Zend\Form\Element\Number',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'pesoA',
                'required' => 'required'
            ),
            'options' => array(
                'label_attributes' => array(
                    'class' => 'control-label required'
                ),
                'label' => 'Peso inicial (Kg)'
            )
        ));

        $this->add(array(
            'name' => 'pesoZ',
            'type' => 'Zend\Form\Element\Number',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'pesoZ',
                'required' => 'required'
            ),
            'options' => array(
                'label_attributes' => array(
                    'class' => 'control-label required'
                ),
                'label' => 'Peso Final (Kg)'
            )
        ));

        $this->add(array(
            'name' => 'valor',
            'type' => 'Zend\Form\Element\Number',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'valor',
                'required' => 'required'
            ),
            'options' => array(
                'label_attributes' => array(
                    'class' => 'control-label required'
                ),
                'locale' => 'pt_BR',
                'label' => 'Valor (R$)'
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
     * @return array
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

    /**
     * @param ServiceLocator $serviceLocator
     * @return $this
     */
    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

}
