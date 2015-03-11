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
 * @category   ParentSelect.php
 * @package    SimNavigation\Form
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd     New BSD License
 */
namespace SimNavigation\Form;

class ParentSelect
{
    public static function getOptionSelect($list)
    {

        $arrayInterator = new \RecursiveArrayIterator($list);
        $interator = new \RecursiveIteratorIterator($arrayInterator);

        $valueOptions = array(); $count = 0; $key = 0;
        foreach($interator as $label => $value) {
            if ($count%2 == 0) {
                $valueOptions[$key][$interator->key()] = $value;
            } else {
                $valueOptions[$key][$interator->key()] = $value;
                ++$key;
            }
            ++$count;
        }

        return $valueOptions;
    }
}
