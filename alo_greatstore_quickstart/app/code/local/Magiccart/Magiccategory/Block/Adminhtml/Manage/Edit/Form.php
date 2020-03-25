<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-09-10 10:21:05
 * @@Modify Date: 2015-04-16 22:33:43
 * @@Function:
 */
?>
<?php
class Magiccart_Magiccategory_Block_Adminhtml_Manage_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form(array(
						'id' => 'edit_form',
						'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
						'method' => 'post',
						'enctype' => 'multipart/form-data'
					)
		);

		$form->setUseContainer(true);
		$this->setForm($form);
		return parent::_prepareForm();
	}
}
