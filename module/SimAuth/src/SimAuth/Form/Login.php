<?php
namespace SimAuth\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilterProviderInterface;

class Login extends Form implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        /**
         * Definition form attributes.
        */
        $this->setAttribute('method', 'post')->setHydrator(new ClassMethods())->setInputFilter(new LoginFilter());

        /**
         * Public fields.
        */
        $this->add(array(
            'name' => 'username',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'username',
                'required' => 'required',
                'placeholder' => 'Seu usuário'
            ),
            'options' => array(
                //'label' => 'Usuário',
            )
        ));

        $this->add(array(
            'name' => 'password',
            'type' => 'Zend\Form\Element\Password',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'username',
                'required' => 'required',
                'placeholder' => 'Sua Senha'
            ),
            'options' => array(
                //'label' => 'Senha',
            )
        ));

        //$this->add(new Element\Csrf('security'));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Autenticar',
                'class' => 'btn bg-olive btn-block'
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
}

