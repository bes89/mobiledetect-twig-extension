<?php

namespace Bes\Twig\Extension;


class MobileDetectExtension extends \Twig_Extension
{
    protected $detector;

    public function __construct()
    {
        $this->detector = new Mobile_Detect();
    }

    /**
     * Twig functions
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'is_mobile' => new \Twig_Function_Method($this->detector, 'isMobile'),
        );
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