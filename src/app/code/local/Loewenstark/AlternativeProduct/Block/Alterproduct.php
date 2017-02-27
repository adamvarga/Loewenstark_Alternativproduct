<?php

class Loewenstark_AlternativeProduct_Block_Alterproduct extends Mage_Catalog_Block_Product_Abstract {

    protected function _construct() {
        parent::_construct();
        $this->addData(array(
            'cache_lifetime' => 42300, // in Sekunden, (bool) false = immer gecached, null = niemals cachen
            'cache_tags' => array(
                Mage_Catalog_Model_Product::CACHE_TAG
            ),
        ));
    }

    /**
     * Get cache key informative items
     *
     * @return array
     */
    public function getCacheKeyInfo() {
        return array(
            'Projektname',
            $this->getNameInLayout(),
            $this->getTemplateFile(),
            Mage::app()->getStore()->getStoreId(),
            Mage::app()->getStore()->getCode(),
            Mage::app()->getStore()->getWebsiteId(),
            Mage::getDesign()->getPackageName(),
            Mage::getDesign()->getTheme('template'),
            Mage::registry('current_product')->getAlternativeProducts(),
        );
    }

    public function getProducts() {

        $current_product = Mage::registry('current_product');
        $alter_product = explode(',', $current_product->getAlternativeProducts());

        $products = Mage::getModel('catalog/product')->getCollection()
                ->addAttributeToSelect('*')
                ->addAttributeToFilter('status', 1)
                ->addAttributeToFilter('sku', array('in' => $alter_product));

        return $products;
    }

}
