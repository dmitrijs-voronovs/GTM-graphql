<?php
/**
 * @category  ScadniPWA
 * @package   ScadniPWA\GtmGraphQl
 * @author    Rihards Stasans <info@scandiweb.com>
 * @author    Dmitrijs Voronovs <info@scandiweb.com>
 * @author    Dmitrijs Voronovs <info@scandiweb.com>
 * @copyright Copyright (c) 2019 Scandiweb, Inc (https://scandiweb.com)
 * @license   http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0 (OSL-3.0)
 */

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'ScandiPWA_GtmGraphQl',
    __DIR__
);
