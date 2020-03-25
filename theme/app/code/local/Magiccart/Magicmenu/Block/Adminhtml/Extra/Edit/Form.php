<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-05-28 10:10:00
 * @@Modify Date: 2014-09-05 18:19:06
 * @@Function:
 */
 ?>
<?php

class Magiccart_Magicmenu_Block_Adminhtml_Extra_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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

