<?php 
namespace Project3\FbComment\Block;

use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Catalog\Block\Product\Context;


class ProductTab extends AbstractProduct {

    protected $_config;


    public function __construct(Context $context, array $data = []) {
        parent::__construct($context, $data);

        $this->_config = $context->getScopeConfig();
        $this->setProductTabTitle();
        $this->setFacebookAppId();
    }


    protected function _beforeToHtml()
    {
        $_isEnabled = $this->_config->getValue('commentstore/commentpage/enabled');
        if ($_isEnabled) {
            $this->setTemplate('product_tab.phtml');
        } else {
            $this->setTemplate('blank.phtml');
        }

        return parent::_beforeToHtml();
    }


    public function setProductTabTitle()
    {
        if($this->_config->getValue('commentstore/commentpage/tab_title')){
            $this->setData('title', __($this->_config->getValue('commentstore/commentpage/tab_title')));
        } else {
            $this->setData('title', __('Facebook Comment'));

        }
    }


    public function setFacebookAppId() {
        $appId = $this->_config->getValue('commentstore/commentpage/app_id');
        $this->setData('app_id', $appId);
    }
}