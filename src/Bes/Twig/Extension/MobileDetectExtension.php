<?php

namespace Bes\Twig\Extension;


class MobileDetectExtension extends \Twig_Extension
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
            'get_available_devices' => new \Twig_Function_Method($this, 'getAvailableDevices'),
            'is_mobile' => new \Twig_Function_Method($this, 'isMobile'),
            'is_tablet' => new \Twig_Function_Method($this, 'isTablet'),
        );

        foreach ($this->getAvailableDevices() as $device => $fixedName) {
            $methodName = 'is'.$device;
            $twigFunctionName = 'is_'.$fixedName;
            $functions[$twigFunctionName] = new \Twig_Function_Method($this, 'is'.$methodName);
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