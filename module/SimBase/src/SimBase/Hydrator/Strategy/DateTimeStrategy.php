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
 * @category   DateTimeStrategy.php
 * @package    SimBase\Hydrator\Strategy
 * @subpackage DateTimeStrategy
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd     New BSD License
 */
namespace SimBase\Hydrator\Strategy;

use \DateTime;
use Zend\Stdlib\Hydrator\Strategy\DefaultStrategy;

class DateTimeStrategy extends DefaultStrategy
{
    protected $extractFormat;

    public function __construct($extractFormat = null)
    {
        if (empty($extractFormat)) {
            $extractFormat = 'd/m/Y H:i:s';
        }
        $this->setExtractFormat($extractFormat);
    }

	/**
     * @return the $extractFormat
     */
    public function getExtractFormat()
    {
        return $this->extractFormat;
    }

	/**
     * @param field_type $extractFormat
     */
    public function setExtractFormat($extractFormat)
    {
        $this->extractFormat = $extractFormat;
        return $this;
    }

	public function hydrate($value)
    {
        if (is_string($value) && "" === $value) {
            $value = null;
        } elseif (is_string($value)) {

            $dateTime = str_replace("/", "-", $value);
            $value = new DateTime($dateTime);
            $value->format('Y-m-d H:i:s');
        }

        return $value;
    }

    public function extract($value)
    {
        if (! $value) {
            return null;
        }

        return $value->format($this->getExtractFormat());
    }
}