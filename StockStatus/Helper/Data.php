<?php
namespace Project3\StockStatus\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Catalog\Model\Product\Attribute\Repository $productAttributeRepository,
        array $data = []
    ) {
        $this->_ProductAttributeRepository = $productAttributeRepository;
        parent::__construct($context,$data);
    }
    public function getsize()
    {
        $size = $this->_ProductAttributeRepository->get('size')->getOptions();
        return $size;

    }
    public function getcolor()
    {
        $color = $this->_ProductAttributeRepository->get('color')->getOptions();
        return $color;

    }
    public function getConfig($config_path)
    {
        return $this->scopeConfig->getValue(
            $config_path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
