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
namespace SimCms\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Zend\Form\Element\Csrf;

class Cms extends Form implements ServiceLocatorAwareInterface, InputFilterProviderInterface
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
         * Define CkEditor / KcFinder.
         */
         $session = $this->getServiceLocator()->get('SessionAdminAdditional');
         $session->kcfinder = $config['params']['ckeditor']['kcfinder'];

        /**
         * Setting objectManager.
         */
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        /**
         * Definition form attributes.
         */
        $this->setAttribute('method', 'post')
            ->setHydrator(new ClassMethods())
            ->setInputFilter(new CmsFilter());

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
            'name' => 'locale',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'locale'
            ),
            'options' => array(
                'label' => 'Idioma',
                'value_options' => array(
                    'pt-BR' => 'Português',
                )
            )
        ));

        $this->add(array(
            'name' => 'title',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'title',
                'required' => 'required'
            ),
            'options' => array(
                'label_attributes' => array(
                    'class' => 'control-label required'
                ),
                'label' => 'Título'
            )
        ));

        $this->add(array(
            'name' => 'description',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'class' => 'form-control editor-middle',
                'id' => 'description',
            ),
            'options' => array(
                'label' => 'Descrição'
            )
        ));

        $this->add(array(
            'name' => 'content',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'class' => 'form-control editor',
                'id' => 'content',
            ),
            'options' => array(
                'label' => 'Conteúdo'
            )
        ));

        $this->add(array(
            'name' => 'url',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'url',
                'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => 'Endereço'
            )
        ));

        $this->add(array(
            'name' => 'entry',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control datetime',
                'id' => 'entry',
                'value' => date('d/m/Y H:i')
            ),
            'options' => array(
                'label' => 'Publicar em'
            )
        ));

        $this->add(array(
            'name' => 'output',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control datetime',
                'id' => 'output',
            ),
            'options' => array(
                'label' => 'Despublicar em'
            )
        ));

        $this->add(array(
            'name' => 'revision',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'revision',
                'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => 'Revisões'
            )
        ));

        $this->add(array(
            'name' => 'showDate',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'showDate',
                'value' => '2'
            ),
            'options' => array(
                'label' => 'Exibir a data?',
                'value_options' => $config['params']['sn'],
            )
        ));

        $this->add(array(
            'name' => 'showTime',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'showTime',
                'value' => '2'
            ),
            'options' => array(
                'label' => 'Exibir a hora?',
                'value_options' => $config['params']['sn'],
            )
        ));

        $this->add(array(
            'name' => 'destak',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'destak',
                'value' => '2',
                'disabled' => 'disabled'
            ),
            'options' => array(
                'label' => 'Destaque',
                'value_options' => $config['params']['sn'],
            )
        ));

        $this->add(array(
            'name' => 'orderBy',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'orderBy',
            ),
            'options' => array(
                'label' => 'Ordenação'
            )
        ));


        $this->add(array(
            'name' => 'state',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'state'
            ),
            'options' => array(
                'label' => 'Situação',
                'value_options' => $config['params']['situacao'],
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
                'label' => 'Título Visível',
                'value_options' => $config['params']['sn'],
            )
        ));

        $this->add(array(
            'name' => 'access',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'access',
                'disabled' => 'disabled'
            ),
            'options' => array(
                'label' => 'Acesso',
                'value_options' => $config['params']['cms']['access'],
            )
        ));

        $this->add(array(
            'name' => 'navigationName',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'nameGroup',
                'required' => 'required'
            ),
            'options' => array(
                'label_attributes' => array(
                    'class' => 'control-label required'
                ),
                'label' => 'Grupo de Navegação',
                'empty_option' => 'Selecione',
                'value_options' => $config['params']['navigation'],
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'navigation',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'parent',
                'required' => 'required'
            ),
            'options' => array(
                'label_attributes' => array(
                    'class' => 'control-label required'
                ),
                'disable_inarray_validator' => true,
                'empty_option' => 'Selecione',
                'label' => 'Página do Menu',
                'value_options' => array()
            )
        ));

        $this->add(array(
            'name' => 'created',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'created',
                'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => 'Criado Em'
            )
        ));

        $this->add(array(
            'name' => 'createdBy',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'createdBy',
                'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => 'Criado por'
            )
        ));

        $this->add(array(
            'name' => 'modified',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'modified',
                'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => 'Modificado Em'
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
