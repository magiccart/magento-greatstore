<?php
/**
 * Magiccart
 * @category     Magiccart
 * @copyright   Copyright (c) 2014 ALO (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2014-06-05 20:29:22
 * @@Modify Date: 2015-01-25 00:16:42
 * @@Function:
 */
 ?>
<?php
class Magiccart_Alothemes_Block_Search_Form extends Mage_Core_Block_Template
{

    protected function _construct()
    {
        $this->addData(array(
            'cache_lifetime'=> false,
            'cache_tags'    => array(Mage_Core_Model_Store::CACHE_TAG, Mage_Cms_Model_Block::CACHE_TAG)
        ));
    }

    public function getSearchableCategories()
    {
        $rootCategory = Mage::getModel('catalog/category')->load(Mage::app()->getStore()->getRootCategoryId());
        return $this->getSearchableSubCategories($rootCategory);
    }

    public function getSearchableSubCategories($category)
    {
        return Mage::getModel('catalog/category')->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('all_children')
            ->addAttributeToFilter('is_active', 1)
            ->addAttributeToFilter('include_in_menu', 1)
            ->addIdFilter($category->getChildren())
            ->setOrder('position', 'ASC')
            ->load();
    }

    public function getCurrentlySelectedCategoryId() {
        $helper = $this->helper('alothemes/search');
        if ($helper->isCategoryPage() && $helper->selectCategoryOnCategoryPages()) {
            foreach (Mage::getSingleton('catalog/layer')->getState()->getFilters() as $filterItem) {
                if ($filterItem->getFilter() instanceof Mage_Catalog_Model_Layer_Filter_Category) {
                    if ($filterItem->getFilter()->getCategory()->getLevel() <= $helper->getMaximumCategoryLevel()) {
                        return $filterItem->getValue();
                    }
                }
            }
            return Mage::getSingleton('catalog/layer')->getCurrentCategory()->getEntityId();
        }
        if ($helper->isSearchResultsPage()) {
            foreach (Mage::getSingleton('catalogsearch/layer')->getState()->getFilters() as $filterItem) {
                 if ($filterItem->getFilter() instanceof Mage_Catalog_Model_Layer_Filter_Category) {
                     return $filterItem->getValue();
                 }
            }
        }
        return Mage::app()->getStore()->getRootCategoryId();
    }
}
