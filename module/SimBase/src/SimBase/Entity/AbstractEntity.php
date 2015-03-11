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
 * @category   AbstractEntity.php
 * @package    SimBase\Entity
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd     New BSD License
 */
namespace SimBase\Entity;

/**
 * Class AbstractEntity
 *
 * @package SimBase\Entity
 *
 */
abstract class AbstractEntity
{
    /**
     * Converting underscore to camelcase.
     *
     * @param array $attributes
     * @return multitype:unknown
     */
    protected function prepare(array $attributes)
    {
        $listVar = array();
        foreach ($attributes as $name => $value) {
            $nameToUpper = create_function('$c', 'return strtoupper($c[1]);');
            $name = preg_replace_callback('/_([a-z])/', $nameToUpper, $name);
            $listVar[$name] = $value;
        }
        return $listVar;
    }

    /**
     * Getting session values.
     *
     * @param string $name
     * @return multitype:
     */
    protected function getSession($name)
    {
        $session = new \Zend\Session\Container($name);
        return $session->getArrayCopy()['storage'];
    }
}
