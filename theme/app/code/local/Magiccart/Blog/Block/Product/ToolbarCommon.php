<?php
if (!class_exists('Magiccart_Blog_Block_Product_ToolbarCommon')) {
    if (Mage::helper('blog')->isMobileInstalled()) {
        class Magiccart_Blog_Block_Product_ToolbarCommon extends AW_Mobile_Block_Catalog_Product_List_Toolbar
        {
        }
    } else {
        class Magiccart_Blog_Block_Product_ToolbarCommon extends Mage_Catalog_Block_Product_List_Toolbar
        {
        }
    }
}