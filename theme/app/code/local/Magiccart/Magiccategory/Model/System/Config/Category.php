<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-08-07 22:10:30
 * @@Modify Date: 2014-11-10 13:46:10
 * @@Function:
 */
?>
<?php

class Magiccart_Magiccategory_Model_System_Config_Category extends Varien_Object
{
 
    // public function toOptionArray() {
    //     $store      = Mage::app()->getStore()->getRootCategoryId();
    //     $collection = Mage::getModel('catalog/category')->getCollection()
    //         ->setStoreId($store)
    //         ->addAttributeToSelect('name')
    //         ->addAttributeToSelect('url_path')
    //         ->addAttributeToSelect('is_active');
    //     $ret    =   array();
    //     foreach($collection as $category) {
    //         $ret[]  =   array(
    //             'value' =>  $category->getId(),
    //             'label' =>  $category->getName()
    //         );  
    //     } 
    //     return $ret;
    // }

	const PREFIX_ROOT = '*'; 	

    const REPEATER = '*';
 
    const PREFIX_END = '';
 
    protected $_options = array();
 
    /**
     * @param int $parentId
     * @param int $recursionLevel
     *
     * @return array
     */
    public function toOptionArray($parentId=1 , $recursionLevel=null)
    {
        $recursionLevel = (int)$recursionLevel;
        $parentId       = (int)$parentId;
 
        $category = Mage::getModel('catalog/category');
        /* @var $category Mage_Catalog_Model_Category */
        $storeCategories = $category->getCategories($parentId, $recursionLevel, TRUE, FALSE, TRUE);
 
        foreach ($storeCategories as $node) {
            /* @var $node Varien_Data_Tree_Node */
 
            $this->_options[] = array(
 
                'label' => self::PREFIX_ROOT .$node->getName(),
                'value' => $node->getEntityId()
            );
            if ($node->hasChildren()) {
                $this->_getChildOptions($node->getChildren());
            }
 
        }
 
        return $this->_options;
    }
 
    /**
     * @param Varien_Data_Tree_Node_Collection $nodeCollection
     */
    protected function _getChildOptions(Varien_Data_Tree_Node_Collection $nodeCollection)
    {
 
        foreach ($nodeCollection as $node) {
            /* @var $node Varien_Data_Tree_Node */
            $prefix = str_repeat(self::REPEATER, $node->getLevel() * 1) . self::PREFIX_END;
 
            $this->_options[] = array(
 
                'label' => $prefix . $node->getName(),
                'value' => $node->getEntityId()
            );
 
            if ($node->hasChildren()) {
                $this->_getChildOptions($node->getChildren());
            }
        }
    }
 

}
