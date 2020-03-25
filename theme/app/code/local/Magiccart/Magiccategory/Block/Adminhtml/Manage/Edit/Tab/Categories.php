<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-09-10 10:21:05
 * @@Modify Date: 2015-04-18 22:37:47
 * @@Function:
 */
?>
<?php
class Magiccart_Magiccategory_Block_Adminhtml_Manage_Edit_Tab_Categories extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Categories
{
    protected $_categoryIds;
    protected $_selectedNodes = null;
        
    public function __construct() {
        parent::__construct();
        $this->setTemplate('catalog/product/edit/categories.phtml');
    }
        
    protected function getCategoryIds() {
        $id     = $this->getRequest()->getParam('id');
        $model = Mage::getModel('core/config_data')->load($id);
        $catIds = array();
        if($model->getValue()){
            $data = unserialize($model->getValue());
            $catIds = isset($data['category_ids']) ? explode(',',$data['category_ids']) : array();
        }
        return $catIds;
    }   

    public function isReadonly() {
        return false;
    }
}
