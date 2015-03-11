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
 * @category   CnpjFormat.php
 * @package    SimBase\View\Helper
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd     New BSD License
 */
namespace SimBase\View\Helper;

use Zend\View\Helper\AbstractHelper;

class CnpjFormat extends AbstractHelper
{

    public function __invoke($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', trim($cnpj));
        if (strlen($cnpj) != 14) {
            return null;
        }

        $cnpjFormat = substr($cnpj, 0, 2) . '.';
        $cnpjFormat .= substr($cnpj, 2, 3) . '.';
        $cnpjFormat .= substr($cnpj, 5, 3) . '/';
        $cnpjFormat .= substr($cnpj, 8, 4) . '-';
        $cnpjFormat .= substr($cnpj, 12, 2);
        return $cnpjFormat;
    }
}