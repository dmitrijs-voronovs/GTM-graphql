<?php
/**
 * @category  ScandiPWA
 * @package   ScandiPWA\GtmGraphQl
 * @author    Rihards Stasans <info@scandiweb.com>
 * @author    Dmitrijs Voronovs <info@scandiweb.com>
 * @copyright Copyright (c) 2019 Scandiweb, Inc (https://scandiweb.com)
 * @license   http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0 (OSL-3.0)
 */

namespace ScandiPWA\GtmGraphQl\Model\Resolver;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Store\Model\ScopeInterface;
use ScandiPWA\Gtm\Model\Config\Source\ElementType;
use ScandiPWA\Gtm\Model\Config\Source\Type;

/**
 * Class GetGtm
 *
 * @package ScandiPWA\GtmGraphQl\Model\Resolver
 */
class GetGtm implements ResolverInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * GetGtm constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get gtm configuration
     *
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     *
     * @return array|Value|mixed
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        return [
            'enabled' => !!$this->getConfigData('enabled'),
            'gtm_id' => $this->getConfigData('gtm_id')
        ];
    }

    /**
     * Get config data
     *
     * @param $field
     * @param string $section
     * @return bool|mixed
     */
    protected function getConfigData($field, $section = 'general')
    {
        $path = 'pwa_gtm/' . $section . '/' . $field;

        return $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE
        );
    }
}
