<?php

namespace Project3\StockStatus\Block\Product;
class Status extends \Magento\Framework\View\Element\Template
{

    const XML_PATH_STOCKSTATUS_ENABLEDSTATUS = 'stockstore/statuspage/enabled_status';
    const XML_PATH_STOCKSTATUS_ENABLEDNUMBER = 'stockstore/statuspage/enabled_number';
    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlInterface;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
    protected $productFactory;

    /**
     * @param \Magento\Framework\UrlInterface $urlInterface
     * @param Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */


    public function __construct(\Magento\Framework\View\Element\Template\Context $context,
                                \Magento\Framework\UrlInterface $urlInterface,
                                \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
                                \Magento\Catalog\Model\ProductFactory $product
    )
    {
        parent::__construct($context);
        $this->urlInterface = $urlInterface;
        $this->scopeConfig = $scopeConfig;
        $this->productFactory = $product;
    }

    public function getProductId()
    {
        $data = $this->_request->getParam('id');
        return $data;
    }

    public function getStatus()
    {
        $isEnabled = $this->scopeConfig->getValue(self::XML_PATH_STOCKSTATUS_ENABLEDSTATUS, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        return $isEnabled;
    }
    public function getNumber()
    {
        $isNumber = $this->scopeConfig->getValue(self::XML_PATH_STOCKSTATUS_ENABLEDNUMBER, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        return $isNumber;
    }

    public function getType()
    {
        $id = $this->getProductId();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $stockRegistry = $objectManager->get('Magento\CatalogInventory\Api\StockRegistryInterface');

        $product = $this->productFactory->create()->load($id);

        $stockitem = $stockRegistry->getStockItem(
            $product->getId(),
            $product->getStore()->getWebsiteId()
        );
        $productArray = [];
        $productArray['type'] = $product->getTypeId();
        $productArray['price'] = $product->getPrice();
        $productArray['sku'] = $product->getSku();
        $productArray['qty'] = $stockitem->getQty();
        $productArray['status'] = $product->getData('custom_stock_status');
        $productArray['numberleft'] = $product->getData('notice_number_left');
        return $productArray;
    }




}