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
 * @category   CpfOrCnpjFormat.php
 * @package    SimBase\View\Helper
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd     New BSD License
 */
namespace SimBase\View\Helper;

use Zend\View\Helper\AbstractHelper;

class CpfOrCnpjFormat extends AbstractHelper
{
    public function __invoke($number)
    {
        $number = preg_replace('/[^0-9]/', '', trim($number));

        if(strlen($number) == 11) {

            $cpfFormat = substr($number, 0, 3) . '.';
            $cpfFormat .= substr($number, 3, 3) . '.';
            $cpfFormat .= substr($number, 6, 3) . '-';
            $cpfFormat .= substr($number, 9, 3);

            return $cpfFormat;

        } else if(strlen($number) == 14) {

            $cnpjFormat = substr($number, 0, 2) . '.';
            $cnpjFormat .= substr($number, 2, 3) . '.';
            $cnpjFormat .= substr($number, 5, 3) . '/';
            $cnpjFormat .= substr($number, 8, 4) . '-';
            $cnpjFormat .= substr($number, 12, 2);

            return $cnpjFormat;

        } else {

            return null;
        }
    }
}