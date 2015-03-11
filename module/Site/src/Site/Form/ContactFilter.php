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
 * @category   EmpresaFilter.php
 * @package    BrEmpresa\Form
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd     New BSD License
 */
namespace Site\Form;

use Zend\InputFilter\InputFilter;
use Zend\Validator\Hostname;

class ContactFilter extends InputFilter
{

    public function __construct()
    {
        $this->add(array(
            'name'       => 'Email',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'EmailAddress',
                    'options' => array(
                        'allow'  => Hostname::ALLOW_DNS,
                        'domain' => true,
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name'       => 'Assunto',
            'required'   => true,
            'filters'    => array(
                array(
                    'name'    => 'StripTags',
                ),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 2,
                        'max'      => 140,
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name'       => 'Mensagem',
            'required'   => true,
        ));

        $this->add(array(
            'name' => 'Telefone',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
                array('name' => 'Digits'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'min' => '10',
                    'max' => '14',
                    'options' => array(
                        'messages' => array(
                            'stringLengthInvalid' => '(!)',
                            'stringLengthTooShort' => '(!)',
                            'stringLengthTooLong' => '(!)',
                        )
                    ),
                ),
                array(
                    'name' => 'Regex',
                    'options' => array(
                        'pattern' => '/^\(?\d{2}\)?[\s-]?9?\d{4}-?\d{4}$/',
                        'messages' => array(
                            'regexInvalid' => '(!)',
                            'regexNotMatch' => '(!)',
                            'regexErrorous' => '(!)',
                        )
                    ),
                ),
            )
        ));
    }
}
