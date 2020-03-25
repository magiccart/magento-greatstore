<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2014-03-14 20:26:27
 * @@Modify Date: 2014-03-15 23:40:05
 * @@Function:
 */
?>
<?php
class Magiccart_Magicproduct_Block_Adminhtml_Edit extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct() {

        $this->_blockGroup = 'magicproduct';
        $this->_controller = 'adminhtml_edit';

        $this->_headerText = Mage::helper('adminhtml')->__('Featured products');

        parent::__construct();

        $this->_removeButton('add');

        $this->_addButton('save', array(
            'label' => 'Save Featured Products',
            'onclick' => 'categorySubmit(\'' . $this->getSaveUrl() . '\')',
            'class' => 'Save',
        ));
    }

    public function getSaveUrl() {
        return $this->getUrl('*/*/save', array('store' => $this->getRequest()->getParam('store')));
    }

    protected function _afterToHtml($html) {
        return $this->_prependHtml() . parent::_afterToHtml($html);
    }

    private function _prependHtml() {
        $html = '
    	
    	<form id="featured_edit_form" action="' . $this->getSaveUrl() . '" method="post" enctype="multipart/form-data">
    	<input name="form_key" type="hidden" value="' . $this->getFormKey() . '" />
    		<div class="no-display">
        		<input type="hidden" name="featured_products" id="in_featured_products" value="" />
    		</div>
		</form>
    	';

        return $html;
    }

    public function getHeaderHtml() {
        return '<h3 style="background-image: url(' . $this->getSkinUrl('images/fam_package.gif') . ');" class="' . $this->getHeaderCssClass() . '">' . $this->getHeaderText() . '</h3>';
    }

    protected function _prepareLayout() {
        $this->setChild('store_switcher', $this->getLayout()->createBlock('adminhtml/store_switcher', 'store_switcher')->setUseConfirm(false)
        );
        return parent::_prepareLayout();
    }

    public function getGridHtml() {

        return $this->getChildHtml('store_switcher') . $this->getChildHtml('grid');
    }

}

