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
 * @category   DoctrineObjectCustom.php
 * @package    SimBase\Hydrator
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd     New BSD License
 */
namespace SimBase\Hydrator;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use SimBase\Hydrator\Strategy\DateTimeStrategy as DateTimeStrategy;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class DoctrineObjectCustom extends DoctrineHydrator
{

    /**
     * @var \Zend\Stdlib\Hydrator\Strategy\StrategyInterface
     */
    protected $dateTimeStrategy;

    /**
     * Hydrate the object using a by-value logic (this means that it uses the entity API, in this
     * case, setters)
     *
     * @param array $data
     * @param object $object
     * @throws RuntimeException
     * @return object
     */
    protected function hydrateByValue(array $data, $object)
    {
        $tryObject = $this->tryConvertArrayToObject($data, $object);
        $metadata = $this->metadata;

        if (is_object($tryObject)) {
            $object = $tryObject;
        }

        foreach ($data as $field => $value) {
            $value = $this->handleTypeConversions($value, $field);
            $setter = 'set' . ucfirst($field);

            if ($metadata->hasAssociation($field)) {
                $target = $metadata->getAssociationTargetClass($field);

                if ($metadata->isSingleValuedAssociation($field)) {
                    if (! method_exists($object, $setter)) {
                        continue;
                    }

                    $value = $this->toOne($target, $this->hydrateValue($field, $value, $data));

                    if (null === $value && ! current($metadata->getReflectionClass()
                        ->getMethod($setter)
                        ->getParameters())->allowsNull()) {
                        continue;
                    }

                    $object->$setter($value);
                } elseif ($metadata->isCollectionValuedAssociation($field)) {
                    $this->toMany($object, $field, $target, $value);
                }
            } else {
                if (! method_exists($object, $setter)) {
                    continue;
                }

                $object->$setter($this->hydrateValue($field, $value, $data));
            }
        }

        return $object;
    }

    /**
     * Hydrate the object using a by-reference logic (this means that values are modified directly without
     * using the public API, in this case setters, and hence override any logic that could be done in those
     * setters)
     *
     * @param array $data
     * @param object $object
     * @return object
     */
    protected function hydrateByReference(array $data, $object)
    {
        $tryObject = $this->tryConvertArrayToObject($data, $object);
        $metadata = $this->metadata;
        $refl = $metadata->getReflectionClass();

        if (is_object($tryObject)) {
            $object = $tryObject;
        }

        foreach ($data as $field => $value) {
            // Ignore unknown fields
            if (! $refl->hasProperty($field)) {
                continue;
            }

            $value = $this->handleTypeConversions($value, $field);
            $reflProperty = $refl->getProperty($field);
            $reflProperty->setAccessible(true);

            if ($metadata->hasAssociation($field)) {
                $target = $metadata->getAssociationTargetClass($field);

                if ($metadata->isSingleValuedAssociation($field)) {
                    $value = $this->toOne($target, $this->hydrateValue($field, $value, $data));
                    $reflProperty->setValue($object, $value);
                } elseif ($metadata->isCollectionValuedAssociation($field)) {
                    $this->toMany($object, $field, $target, $value);
                }
            } else {
                $reflProperty->setValue($object, $this->hydrateValue($field, $value, $data));
            }
        }

        return $object;
    }

    /**
     * Handle various type conversions that should be supported natively by Doctrine (like DateTime)
     *
     * @param mixed $value
     * @param string $typeOfField
     * @return DateTime
     */
    protected function handleTypeConversions($value, $field)
    {
        switch ($this->metadata->getTypeOfField($field)) {
            case 'datetimetz':
            case 'datetime':
            case 'time':
            case 'date':
                if ('' === $value) {
                    return null;
                }

                if (is_int($value)) {
                    $dateTime = new \DateTime();
                    $dateTime->setTimestamp($value);
                    $value = $dateTime;
                } elseif (is_string($value) && $this->hasStrategy($field)) {
                    $value = $this->getStrategy($field)->hydrate($value);
                } else {
                    $value = $this->getDateTimeStrategy()->hydrate($value);
                }

                break;
            default:
        }

        return $value;
    }

    /**
     *
     * @return StrategyInterface
     */
    public function getDateTimeStrategy()
    {
        return $this->dateTimeStrategy ?  : $this->dateTimeStrategy = new DateTimeStrategy();
    }

    /**
     *
     * @param StrategyInterface $dateTimeStrategy
     * @return \Application\Hydrator\ObjectHydrator
     */
    public function setDateTimeStrategy(StrategyInterface $dateTimeStrategy)
    {
        $this->dateTimeStrategy = $dateTimeStrategy;
        return $this;
    }
}