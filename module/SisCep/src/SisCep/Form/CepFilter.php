<?php
namespace SisCep\Form;

use Zend\InputFilter\InputFilter;

class CepFilter extends InputFilter
{

    public function __construct()
    {
        $this->add(array(
            'name' => 'cepInicial',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Não pode estar em branco'
                        )
                    )
                )
            )
        ));

        $this->add(array(
            'name' => 'cepFinal',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Não pode estar em branco'
                        )
                    )
                )
            )
        ));

        $this->add(array(
            'name' => 'peso',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'greaterThan',
                    'options' => array('min' => 0)
                )
            )
        ));

        $this->add(array(
            'name' => 'valor',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'greaterThan',
                    'options' => array('min' => 0)
                )
            )
        ));
    }
}
