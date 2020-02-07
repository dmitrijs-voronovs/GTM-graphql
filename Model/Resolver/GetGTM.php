<?php
/**
 * @category  Technodom
 * @package   Technodom\GTMGraphQl
 * @author    Rihards Stasans <info@scandiweb.com>
 * @copyright Copyright (c) 2019 Scandiweb, Inc (https://scandiweb.com)
 * @license   http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0 (OSL-3.0)
 */

namespace Technodom\GTMGraphQl\Model\Resolver;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Locale\Resolver as LocaleResolver;
use Technodom\GTM\Model\Config\Source\ElementType;
use Technodom\GTM\Model\Config\Source\Type;

/**
 * Class GetGTM
 *
 * @package Technodom\GTMGraphQl\Model\Resolver
 */
class GetGTM implements ResolverInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var LocaleResolver
     */
    private $localeResolver;

    /**
     * @var Json
     */
    private $json;

    /**
     * @var Type
     */
    private $type;

    /**
     * @var ElementType
     */
    private $elementType;

    /**
     * GetGTM constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param LocaleResolver $localeResolver
     * @param Json $json
     * @param Type $type
     * @param ElementType $elementType
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        LocaleResolver $localeResolver,
        Json $json,
        Type $type,
        ElementType $elementType
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->localeResolver = $localeResolver;
        $this->json = $json;
        $this->type = $type;
        $this->elementType = $elementType;
    }

    /**
     * Get promotions
     *
     * @return array
     */
    protected function getPromotions()
    {
        $promotions = [];
        $mapping = $this->json->unserialize(
            $this->getConfigData('mapping', 'promotions')
        ) ?: [];

        foreach ($mapping as $item) {
            $promotions[] = [
                'page' => $item['page'],
                'type' => $this->type->toArray()[(int)$item['type']],
                'element' => $item['element'],
                'element_type' => $this->elementType->getArray()[(int)$item['element_type']]
            ];
        }

        return $promotions;
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
     * @throws LocalizedException
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        return [
            'enabled' => !!$this->getConfigData('enabled'),
            'gtm_id' => $this->getConfigData('gtm_id'),
            'gtm_data_layer' => $this->getConfigData('gtm_data_layer'),
            'gtm_auth' => $this->getConfigData('gtm_auth'),
            'gtm_preview' => $this->getConfigData('gtm_preview'),
            'gtm_debug' => $this->getConfigData('debug'),
            'gtm_store' => $this->storeManager->getStore()->getCode(),
            'gtm_lang' => $this->localeResolver->getLocale(),
            'gtm_promotions' => $this->getPromotions()
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
