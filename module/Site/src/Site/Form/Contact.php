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
 * @category   Contact.php
 * @package    Site\Form
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd     New BSD License
 */
namespace Site\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\InputFilter\InputFilterProviderInterface;
use Site\Form\ContactFilter;

class Contact extends Form implements ObjectManagerAwareInterface, InputFilterProviderInterface
{

    protected $captcha;

    protected $objectManager;

    public function __construct(ObjectManager $objectManager, $name = null, $options = array())
    {
        parent::__construct($name, $options);

        /**
         * Setting object manager.
         */
        $this->setObjectManager($objectManager);

        /**
         * Definition form attributes.
         */
        $this->setAttribute('method', 'post')
            ->setHydrator(new ClassMethods())
            ->setInputFilter(new ContactFilter());

        /**
         * Public fields.
         */
        $this->add(array(
            'name' => 'Nome',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'nome',
                'required' => 'required'
            ),
            'options' => array(
                'label_attributes' => array(
                    'class' => 'control-label required'
                ),
                'label' => 'Seu nome'
            )
        ));
        $this->add(array(
            'name' => 'Assunto',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'assunto',
                'required' => 'required'
            ),
            'options' => array(
                'label_attributes' => array(
                    'class' => 'control-label required'
                ),
                'label' => 'Qual o assunto?'
            )
        ));
        $this->add(array(
            'name' => 'Email',
            'type' => 'Zend\Form\Element\Email',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'email',
                'required' => 'required'
            ),
            'options' => array(
                'label_attributes' => array(
                    'class' => 'control-label required'
                ),
                'label' => 'Seu email'
            )
        ));
        $this->add(array(
            'name' => 'Telefone',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control phone_ddd',
                'id' => 'telefone'
            ),
            'options' => array(
                'label' => 'Seu telefone'
            )
        ));
        $this->add(array(
            'name' => 'Cidade',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'cidade',
                'required' => 'required'
            ),
            'options' => array(
                'label' => 'Cidade',
                'label_attributes' => array(
                    'class' => 'required',
                )
            )
        ));
        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'Estado',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'estado',
                'required' => 'required'
            ),
            'options' => array(
                'object_manager' => $objectManager,
                'target_class' => '\SimCep\Entity\CepUf',
                'property' => 'nome',
                'empty_option' => 'Selecione',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array(
                            'nome' => 'ASC'
                        )
                    )
                ),
                'label_attributes' => array(
                    'class' => 'control-label required'
                ),
                'label' => 'Estado'
            )
        ));

        $this->add(array(
            'name'  => 'Mensagem',
            'type'  => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'required',
                'rows' => 5,
                'placeholder' => 'Sua mensagem...'
            ),
        ));

        $this->add(new Element\Csrf('security'));

        $this->add(array(
            'name' => 'send',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'class' => 'btn btn-green btn-sm',
                'style' => 'display:block',
                'value' => 'Enviar Mensagem'
            )
        ));
    }

    /**
     *
     * @return the $objectManager
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }

    /**
     *
     * @param ObjectManager $objectManager
     */
    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
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
}
