<?php

namespace Project3\StockStatus\Block\Cart;
class AbstractCart extends \Magento\Checkout\Block\Cart
{
    public function getProductDetailsHtml(\Magento\Catalog\Model\Product $product)
    {
        $html = $this->getLayout()->createBlock('Magento\Framework\View\Element\Template')->setProduct($product)->setTemplate('Project3_StockStatus::status_productlist.phtml')->toHtml();
        $renderer = $this->getDetailsRenderer($product->getTypeId());
        if ($renderer) {
            $renderer->setProduct($product);
            return $html . $renderer->toHtml();
        }
        return '';
    }
}