<?php

namespace Project3\ShippingBar\Block;

class ShippingBar extends \Magento\Framework\View\Element\Template
{
    protected $_cart;
    protected $_checkoutSession;
    const XML_PATH_SHIPPINGBAR_ENABLED = 'shippingstore/shippingpage/enabled';
    const XML_PATH_SHIPPINGBAR_SHIPPINGTYPE = 'shippingstore/shippingpage/shippingtype';
    const XML_PATH_SHIPPINGBAR_SHIPPINGGOAL = 'shippingstore/shippingpage/shipping_goal';
    const XML_PATH_SHIPPINGBAR_CARTEMPTY = 'shippingstore/content/cart_empty';
    const XML_PATH_SHIPPINGBAR_CARTNOTEMPTY = 'shippingstore/content/cart_not_empty';
    const XML_PATH_SHIPPINGBAR_CARTGOAL = 'shippingstore/content/cart_goal';
    const XML_PATH_SHIPPINGBAR_DELAY = 'shippingstore/wheretodisplay/page_delay';
    const XML_PATH_SHIPPINGBAR_DISPLAYTYPE = 'shippingstore/wheretodisplay/display_type';
    const XML_PATH_SHIPPINGBAR_PAGEDISPLAY = 'shippingstore/wheretodisplay/page_display';
    const XML_PATH_SHIPPINGBAR_FONTFAMILY = 'shippingstore/design/font_family';
    const XML_PATH_SHIPPINGBAR_FONTSIZE = 'shippingstore/design/font_size';
    const XML_PATH_SHIPPINGBAR_FONTWEIGHT = 'shippingstore/design/font_weight';
    const XML_PATH_SHIPPINGBAR_FONTCOLOR = 'shippingstore/design/font_color';
    const XML_PATH_SHIPPINGBAR_BACKGROUNDCOLOR = 'shippingstore/design/background_color';
    const XML_PATH_SHIPPINGBAR_TEXTALIGN = 'shippingstore/design/text_align';

    protected $_storeManager;
    protected $_currency;
    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlInterface;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\UrlInterface $urlInterface,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Directory\Model\Currency $currency,
        array $data = array()
    ) 
{

        $this->_cart = $cart;
        $this->_checkoutSession = $checkoutSession;
        $this->urlInterface = $urlInterface;
        $this->scopeConfig = $scopeConfig;
        $this->_storeManager = $storeManager;
        $this->_currency = $currency;
    parent::__construct($context, $data);
    }

    public function getCurrentCurrencySymbol()
    {
        return $this->_currency->getCurrencySymbol();
    }

    public function getCart()
    {
        return $this->_cart;
    }

    public function getCheckoutSession()
    {
        return $this->_checkoutSession;
    }
    //Content when cart is empty
    public function getCartEmpty()
    {
        $isDisplay = $this->scopeConfig->getValue(self::XML_PATH_SHIPPINGBAR_PAGEDISPLAY, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $isEnabled = $this->scopeConfig->getValue(self::XML_PATH_SHIPPINGBAR_ENABLED, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if ($isEnabled&&($isDisplay=='5'||$isDisplay=='1')) {
            $cartEmpty = $this->scopeConfig->getValue(
                self::XML_PATH_SHIPPINGBAR_CARTEMPTY,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
            return $cartEmpty;
        } else {
            return null;
        }
    }
    //Content when cart is not empty
    public function getCartNotEmpty()
    {
        $isDisplay = $this->scopeConfig->getValue(self::XML_PATH_SHIPPINGBAR_PAGEDISPLAY, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $isEnabled = $this->scopeConfig->getValue(self::XML_PATH_SHIPPINGBAR_ENABLED, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if ($isEnabled&&($isDisplay=='5'||$isDisplay=='1')) {
            $cartNotEmpty = $this->scopeConfig->getValue(
                self::XML_PATH_SHIPPINGBAR_CARTNOTEMPTY,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
            return $cartNotEmpty;
        } else {
            return null;
        }
    }
    //Content when goal is reached
    public function getCartGoal()
    {
        $isDisplay = $this->scopeConfig->getValue(self::XML_PATH_SHIPPINGBAR_PAGEDISPLAY, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $isEnabled = $this->scopeConfig->getValue(self::XML_PATH_SHIPPINGBAR_ENABLED, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if ($isEnabled&&($isDisplay=='5'||$isDisplay=='1')) {
            $cartGoal = $this->scopeConfig->getValue(
                self::XML_PATH_SHIPPINGBAR_CARTGOAL,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
            return $cartGoal;
        } else {
            return null;
        }
    }
    //Display with delay after page load, seconds
    public function getDelay()
    {
        return $delay = $this->scopeConfig->getValue(
            self::XML_PATH_SHIPPINGBAR_DELAY,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    //Get Display Type:
    public function getDisplayType()
    {
        return $displaytype = $this->scopeConfig->getValue(
            self::XML_PATH_SHIPPINGBAR_DISPLAYTYPE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    // Get Type of Shipping
    public function getType()
    {
        $isEnabled = $this->scopeConfig->getValue(self::XML_PATH_SHIPPINGBAR_ENABLED, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if ($isEnabled) {
            $type = $this->scopeConfig->getValue(self::XML_PATH_SHIPPINGBAR_SHIPPINGTYPE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            return $type;
        } else {
            return null;
        }

    }
    // Get value of Shipping
    public function getValue()
    {
        $isEnabled = $this->scopeConfig->getValue(self::XML_PATH_SHIPPINGBAR_ENABLED, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if ($isEnabled) {
            $buttonText = $this->scopeConfig->getValue(self::XML_PATH_SHIPPINGBAR_SHIPPINGGOAL, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            return $buttonText;
        } else {
            return null;
        }

    }
    //Get enable
    public function getEnable()
    {
        return $enable = $this->scopeConfig->getValue(
            self::XML_PATH_SHIPPINGBAR_ENABLED,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    //Get font-family
    public function getFontFamily()
    {
        return $fontFamily = $this->scopeConfig->getValue(
            self::XML_PATH_SHIPPINGBAR_FONTFAMILY,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    //Get font-size
    public function getFontSize()
    {
        return $fontSize = $this->scopeConfig->getValue(
            self::XML_PATH_SHIPPINGBAR_FONTSIZE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    //Get font-weight
    public function getFontWeight()
    {
        return $fontWeigth = $this->scopeConfig->getValue(
            self::XML_PATH_SHIPPINGBAR_FONTWEIGHT,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    //Get text-align
    public function getTextAlign()
    {
        return $textAlign = $this->scopeConfig->getValue(
            self::XML_PATH_SHIPPINGBAR_TEXTALIGN,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    //Get font-color
    public function getFontColor()
    {
        return $fontColor = $this->scopeConfig->getValue(
            self::XML_PATH_SHIPPINGBAR_FONTCOLOR,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    //Get background-color
    public function getBackgroundColor()
    {
        return $backgroundColor = $this->scopeConfig->getValue(
            self::XML_PATH_SHIPPINGBAR_BACKGROUNDCOLOR,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
