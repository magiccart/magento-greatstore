<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2014-08-06 16:17:34
 * @@Function:
 */
 ?>
<?php

class Magiccart_Testimonial_Block_Adminhtml_Testimonial_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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

