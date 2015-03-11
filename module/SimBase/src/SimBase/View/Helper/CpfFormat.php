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
 * @category   CpfFormat.php
 * @package    SimBase\View\Helper
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd     New BSD License
 */
namespace SimBase\View\Helper;

use Zend\View\Helper\AbstractHelper;

class CpfFormat extends AbstractHelper
{

    public function __invoke($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', trim($cpf));
        if (strlen($cpf) != 11) {
            return null;
        }

        $cpfFormat = substr($cpf, 0, 3) . '.';
        $cpfFormat .= substr($cpf, 3, 3) . '.';
        $cpfFormat .= substr($cpf, 6, 3) . '-';
        $cpfFormat .= substr($cpf, 9, 3);

        return $cpfFormat;
    }
}