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
use Zend\Mvc\Controller\Plugin\FlashMessenger as FlashMessenger;

class FlashMessages extends AbstractHelper
{
    /**
     * FlashMessenger::NAMESPACE_WARNING => array()
     * @var constants
     */
    const NAMESPACE_DEFAULT = 'default';

    /**
     * @var constants
     */
    const NAMESPACE_SUCCESS = 'success';

    /**
     * @var constants
     */
    const NAMESPACE_WARNING = 'warning';

    /**
     * @var constants
     */
    const NAMESPACE_ERROR = 'danger';

    /**
     * @var constants
     */
    const NAMESPACE_INFO = 'info';

    protected $flashMessenger;

    public function setFlashMessenger(FlashMessenger $flashMessenger)
    {
        $this->flashMessenger = $flashMessenger;
    }

    public function __invoke($includeCurrentMessages = false)
    {
        $messages = array(
            self::NAMESPACE_WARNING => array(),
            self::NAMESPACE_ERROR => array(),
            self::NAMESPACE_SUCCESS => array(),
            self::NAMESPACE_INFO => array(),
            self::NAMESPACE_DEFAULT => array()
        );

        foreach ($messages as $ns => &$m) {
            $m = $this->flashMessenger->getMessagesFromNamespace($ns);

            if ($includeCurrentMessages) {
                $m = array_merge($m, $this->flashMessenger->getCurrentMessagesFromNamespace($ns));
                $this->flashMessenger->clearCurrentMessagesFromNamespace($ns);
            }
        }

        return $messages;
    }
}