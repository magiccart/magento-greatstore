<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-25 14:47:03
 * @@Modify Date: 2015-03-06 09:10:37
 * @@Function:
 */
?>
<?php
class Magiccart_Magicinstall_Block_Adminhtml_Install_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('install_form', array('legend'=>Mage::helper('adminhtml')->__('Setting')));
        $scope    = $this->getRequest()->getParam('store');
        if($scope){
        	$scopeId = Mage::app()->getStore($scope)->getId();
			$fieldset->addField('scope', 'hidden', array(
				'label'     => Mage::helper('adminhtml')->__('Scope'),
				'class'     => 'required-entry',
				'required'  => true,
				'name'      => 'scope',
				'value'  	=> 'stores',
			));
			$fieldset->addField('scope_id', 'hidden', array(
				'label'     => Mage::helper('adminhtml')->__('Scope Id'),
				'class'     => 'required-entry',
				'required'  => true,
				'name'      => 'scope_id',
				'value'  	=> $scopeId,
			));
        }else {
        	$scope 	 = $this->getRequest()->getParam('website');
        	if($scope){
	        	$scopeId = Mage::app()->getWebsite($scope)->getId();
				$fieldset->addField('scope', 'hidden', array(
					'label'     => Mage::helper('adminhtml')->__('Scope'),
					'class'     => 'required-entry',
					'required'  => true,
					'name'      => 'scope',
					'value'  	=> 'websites',
				));
				$fieldset->addField('scope_id', 'hidden', array(
					'label'     => Mage::helper('adminhtml')->__('Scope Id'),
					'class'     => 'required-entry',
					'required'  => true,
					'name'      => 'scope_id',
					'value'  	=> $scopeId,
				));        		
        	}

        }
		// if (!Mage::app()->isSingleStoreMode()) {
		    // $fieldset->addField('store_ids', 'multiselect', array(
		    //     'name' => 'store_ids[]',
		    //     'label' => $this->__('Store View Active Theme'),
		    //     'required' => true,
		    //     'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, false),
		    // ));
		// }
		$fieldset->addField('theme', 'select', array(
			'label'     => Mage::helper('adminhtml')->__('Select Theme'),
			'name'      => 'theme',
			'required' => true,
			'values'    => Mage::getModel('magicinstall/import_theme')->toOptionArray(),
		));
		$fieldset->addField('config', 'select', array(
			'label'     => Mage::helper('adminhtml')->__('Action Config'),
			'name'      => 'config',
			'values'    => array(
				array('value' => 1, 'label' => Mage::helper('adminhtml')->__('Yes')),
				array('value' => 2, 'label' => Mage::helper('adminhtml')->__('No')),
			),
		));

		$pages = $fieldset->addField('pages', 'select', array(
			'label'     => Mage::helper('adminhtml')->__('Action Pages'),
			'name'      => 'pages',
			'values'    => array(
				array('value' => 1, 'label' => Mage::helper('adminhtml')->__('Yes')),
				array('value' => 2, 'label' => Mage::helper('adminhtml')->__('No')),
			),
		));

		$overwrite_pages = $fieldset->addField('overwrite_pages', 'select', array(
			'label'     => Mage::helper('adminhtml')->__('Overwrite Pages'),
			'name'      => 'overwrite_pages',
			'values'    => array(
				array('value' => 1, 'label' => Mage::helper('adminhtml')->__('Yes')),
				array('value' => 2, 'label' => Mage::helper('adminhtml')->__('No')),
			),
		));

		$blocks = $fieldset->addField('blocks', 'select', array(
			'label'     => Mage::helper('adminhtml')->__('Action Blocks'),
			'name'      => 'blocks',
			'values'    => array(
				array('value' => 1, 'label' => Mage::helper('adminhtml')->__('Yes')),
				array('value' => 2, 'label' => Mage::helper('adminhtml')->__('No')),
			),
		));

		$overwrite_blocks = $fieldset->addField('overwrite_blocks', 'select', array(
			'label'     => Mage::helper('adminhtml')->__('Overwrite Blocks'),
			'name'      => 'overwrite_blocks',
			'values'    => array(
				array('value' => 1, 'label' => Mage::helper('adminhtml')->__('Yes')),
				array('value' => 2, 'label' => Mage::helper('adminhtml')->__('No')),
			),
		));

/* 		$fieldset->addField('widgets', 'select', array(
			'label'     => Mage::helper('adminhtml')->__('Action Widgets'),
			'name'      => 'widgets',
			'values'    => array(
				array('value' => 1, 'label' => Mage::helper('adminhtml')->__('Yes')),
				array('value' => 2, 'label' => Mage::helper('adminhtml')->__('No')),
			),
		)); 
*/

		$fieldset->addField('menus', 'select', array(
			'label'     => Mage::helper('adminhtml')->__('Action Extra Menu'),
			'name'      => 'menus',
			'values'    => array(
				array('value' => 1, 'label' => Mage::helper('adminhtml')->__('Yes')),
				array('value' => 2, 'label' => Mage::helper('adminhtml')->__('No')),
			),
		));
		$fieldset->addField('slide', 'select', array(
			'label'     => Mage::helper('adminhtml')->__('Action Slide'),
			'name'      => 'slide',
			'values'    => array(
				array('value' => 1, 'label' => Mage::helper('adminhtml')->__('Yes')),
				array('value' => 2, 'label' => Mage::helper('adminhtml')->__('No')),
			),
		));
		$fieldset->addField('action', 'select', array(
		    'name' => 'action',
		    'title' => Mage::helper('adminhtml')->__('Store View'),
		    'label' => Mage::helper('adminhtml')->__('Instal or Uninstall'),
			'values'    => array(
				array('value' => 1, 'label' => Mage::helper('adminhtml')->__('Instal Template')),
				array('value' => 2, 'label' => Mage::helper('adminhtml')->__('Uninstall Template')),
			),
		));

		if ( Mage::getSingleton('adminhtml/session')->getInstallData() )
		{
			$form->setValues(Mage::getSingleton('adminhtml/session')->getInstallData());
			Mage::getSingleton('adminhtml/session')->setInstallData(null);
		} else {
	  //       $storeIdsActive = Mage::helper('magicinstall')->getStoreActiveTheme();
			// $form->setValues(array('store_ids'=>implode(',', $storeIdsActive)));
		}

        $this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
            ->addFieldMap($pages->getHtmlId(), $pages->getName())
            ->addFieldMap($blocks->getHtmlId(), $blocks->getName())
            ->addFieldMap($overwrite_pages->getHtmlId(), $overwrite_pages->getName())
            ->addFieldMap($overwrite_blocks->getHtmlId(), $overwrite_blocks->getName())
            ->addFieldDependence( $overwrite_pages->getName(),$pages->getName(),'1')
            ->addFieldDependence( $overwrite_blocks->getName(),$blocks->getName(),'1')
        );

		return parent::_prepareForm();
	}
}

