<?php

namespace Opg\Common\Model\Entity\Traits;

use JMS\Serializer\Annotation\GenericAccessor;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;
use Opg\Common\Model\Entity\HasDateTimeAccessor;

/**
 * Class DateTimeAccessor
 * @package Opg\Common\Model\Entity\Traits
 */
trait DateTimeAccessor
{
    /**
     * @param $propertyName
     * @return string
     */
    public function getDateAsString($propertyName)
    {
        return $this->getFormattedDateTime($propertyName);
    }

    /**
     * @param $propertyName
     * @return string|null
     */
    public function getDateTimeAsString($propertyName)
    {
        return $this->getFormattedDateTime($propertyName, true);
    }

    /**
     * @param      $propertyName
     * @param bool $includeTime
     * @return string
     */
    protected function getFormattedDateTime($propertyName, $includeTime = false)
    {
        if (
            property_exists(get_class($this), $propertyName)
            && isset($this->{$propertyName})
            && $this->{$propertyName} instanceof \DateTime) {

            if ( true === $includeTime) {
                return $this->{$propertyName}->format(OPGDateFormat::getDateTimeFormat());
            } else {
                return $this->{$propertyName}->format(OPGDateFormat::getDateFormat());
            }
        }

        return '';
    }

    /**
     * @param $value
     * @param $propertyName
     * @return HasDateTimeAccessor
     */
    public function setDateTimeFromString($value, $propertyName)
    {
        if (property_exists(get_class($this), $propertyName) && !empty($value)) {
            $this->{$propertyName} = OPGDateFormat::createDateTime($value);
        }

        return $this;
    }

    /**
     * @param $value
     * @param $propertyName
     * @return HasDateTimeAccessor
     */
    public function setDateFromString($value, $propertyName)
    {
        return $this->setDateTimeFromString($value, $propertyName);
    }

    /**
     * @param $value
     * @param $propertyName
     * @return HasDateTimeAccessor
     */
    public function setDefaultDateFromString($value, $propertyName)
    {
        if (property_exists(get_class($this), $propertyName) && empty($value)) {
            $this->{$propertyName} = new \DateTime();
            return $this;
        }

        return $this;
    }
    /**
     * @param $methodName
     * @param $params
     * @return HasDateTimeAccessor
     * @throws \LogicException
     * @throws \Exception
     */
    public function __call($methodName, $params)
    {
        if (preg_match('/(s|g)et[A-Za-z]+DateString/', $methodName)) {
            $parameter = str_replace('String','',$methodName);
            $parameter = lcfirst(substr($parameter,3));

            if (property_exists(get_class($this), $parameter)) {
                if (substr($methodName,0,3) === 'get') {
                    return $this->getDateAsString($parameter);
                } else {
                    return $this->setDateFromString($params[0], $parameter);
                }
            } else {
                throw new \LogicException('Parameter ' . $parameter . ' does not exist in class ' . get_class($this));
            }
        }

        throw new \Exception('The method ' . $methodName . ' does not exist on ' . get_class($this));
    }
}
