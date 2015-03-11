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
 * @category   DataGridSort.php
 * @package    Module
 * @subpackage Default_Controller
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd     New BSD License
 */
namespace SimBase\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Mvc\MvcEvent;

class DataGridSort extends AbstractHelper
{

    protected $mvcEvent;

    public function __construct(MvcEvent $mvcEvent)
    {
        $this->mvcEvent = $mvcEvent;
    }

    protected function getIcon($sort)
    {
        $icon = array(
            'asc' => 'glyphicon glyphicon-arrow-up',
            'desc' => 'glyphicon glyphicon-arrow-down'
        );
        return $icon[$sort];
    }

    public function __invoke($order = null, $return = 'url')
    {
        $routeMatch = $this->mvcEvent->getRouteMatch();
        $orderRequest = $this->mvcEvent->getRequest()->getQuery('order');
        $sortRequest = $this->mvcEvent->getRequest()->getQuery('sort');

        $icon = '';
        if ($order === $orderRequest) {
            $sort = ($sortRequest === 'asc' ? 'desc' : 'asc');
            $icon = $this->getIcon($sort);
        }

        if (empty($sort)) {
            $sort = 'asc';
        }

        $url = $this->getView()->url($routeMatch->getMatchedRouteName(), array(
            'controller' => $routeMatch->getParam('__CONTROLLER__'),
            'action' => 'index',
            'page' => $routeMatch->getParam('page')
        ), array(
            'query' => array(
                'order' => $order,
                'sort' => $sort
            )
        ));

        $data = array(
            'url' => $url,
            'icon' => $icon
        );
        return $data[$return];
    }
}