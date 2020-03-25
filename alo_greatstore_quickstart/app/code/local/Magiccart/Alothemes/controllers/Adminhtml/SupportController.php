<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-28 17:49:00
 * @@Modify Date: 2015-07-29 23:39:33
 * @@Function:
 */
 ?>
<?php
class Magiccart_Alothemes_Adminhtml_SupportController extends Mage_Adminhtml_Controller_Action
{
	const NAVIGATION = 'magiccart/alothemes_support';
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu(self::NAVIGATION)
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Help Support'), Mage::helper('adminhtml')->__('Help Support'));
		return $this;
	}   

	public function indexAction() {
		$this->loadLayout();
		
		$this->_addLeft($this
			->getLayout()
			->createBlock('core/text')
			->setText('
				<h3>Help Support</h3>
				<h3>ALO Themes Version 1.9</h3>
			'));
		//create a text block with the name of "example-block"
		$block = $this->getLayout()
			->createBlock('core/text', 'support-block')
			->setText('
				<h1>Support</h1>
				<p>
					You also can click: <a href="mailto:support@alothemes.com" target="_top">Send Mail to Support</a>.
					<br/>
					You also can click: <a href="http://alothemes.com/ticket" target="_blank">Make Ticket</a>.
					<br/>
					Please check if you get the confirmation email from our system to ensure the ticket has been created successfully.
				</p>
			');      
		$this->_addContent($block);
		
		$block = $this->getLayout()
			->createBlock('core/text')
			->setText('
				<script type="text/javascript">
					// alert ("foo");
				</script>'
			);
	    $this->_addJs($block);

		$this->renderLayout();
	}

}

