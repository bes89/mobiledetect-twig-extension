<?php

namespace Bes\Twig\Extension;


class MobileDetectExtension extends \Twig\Extension\AbstractExtension
{
    protected $detector;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->detector = new \Mobile_Detect();
    }

    /**
     * Twig functions
     *
     * @return array
     */
    public function getFunctions()
    {
        $functions = array(
            new \Twig_SimpleFunction('get_available_devices', array($this, 'getAvailableDevices')),
            new \Twig_SimpleFunction('is_mobile', array($this, 'isMobile')),
            new \Twig_SimpleFunction('is_tablet', array($this, 'isTablet'))
        );

        foreach ($this->getAvailableDevices() as $device => $fixedName) {
            $methodName = 'is'.$device;
            $twigFunctionName = 'is_'.$fixedName;
            $functions[] = new \Twig_SimpleFunction($twigFunctionName, array($this, $methodName));
        }

        return $functions;
    }

    /**
     * Returns an array of all available devices
     *
     * @return array
     */
    public function getAvailableDevices()
    {
        $availableDevices = array();
        $rules = array_change_key_case($this->detector->getRules());

        foreach ($rules as $device => $rule) {
            $availableDevices[$device] = static::fromCamelCase($device);
        }

        return $availableDevices;
    }

    /**
     * Pass through calls of undefined methods to the mobile detect library
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array(array($this->detector, $name), $arguments);
    }

    /**
     * Converts a string to camel case
     *
     * @param $string
     * @return mixed
     */
    protected static function toCamelCase($string)
    {
        return preg_replace('~\s+~', '', lcfirst(ucwords(strtr($string, '_', ' '))));
    }

    /**
     * Converts a string from camel case
     *
     * @param $string
     * @param string $separator
     * @return string
     */
    protected static function fromCamelCase($string, $separator = '_')
    {
        return strtolower(preg_replace('/(?!^)[[:upper:]]+/', $separator.'$0', $string));
    }

    /**
     * The extension name
     *
     * @return string
     */
    public function getName()
    {
        return 'mobile_detect.twig.extension';
    }
}
