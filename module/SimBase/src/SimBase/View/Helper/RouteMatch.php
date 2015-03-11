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
 * @category   RouteMatch.php
 * @package    SimBase\View\Helper
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd     New BSD License
 */
namespace SimBase\View\Helper;

use Zend\View\Helper\AbstractHelper;

class RouteMatch extends AbstractHelper
{

    protected $routeMatch;

    public function __construct($routeMatch)
    {
        $this->routeMatch = $routeMatch;
    }

    public function getRouteName()
    {
        if (method_exists($this->routeMatch, 'getMatchedRouteName')) {
            return $this->routeMatch->getMatchedRouteName();
        }
    	return false;
    }

    public function getController()
    {
        if ($this->routeMatch) {
            $controller = $this->routeMatch->getParam('controller', 'index');
            return $controller;
        }
    }

    public function getControllerName()
    {
        if ($this->routeMatch) {
            return $this->routeMatch->getParam('__CONTROLLER__');
        }
    }
}