<?php
/**
 * Magiccart 
 * @category  Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license   http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-09-10 10:21:05
 * @@Modify Date: 2015-05-04 15:04:18
 * @@Function:
 */
?>
<?php
class Magiccart_Magicproduct_Block_Adminhtml_Manage_Edit_Tab_Config extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$model = Mage::registry('magicproduct_data');	
		
		// if($model->getStores())
		// {		
		// 	//$_model->setPageId(Mage::helper('core')->jsonDecode($_model->getPageId()));
		// 	$model->setStores(explode(',',$model->getStores()));
		// }
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('config_form', array('legend'=>Mage::helper('magicproduct')->__('General Information')));

		$fieldset->addField('timer', 'select', array(
			'label'     => Mage::helper('adminhtml')->__('Timer for Sale:'),
			'name'      => 'timer',
			'values'	=> Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray(),
			'value'     => array(1),
		));

		$slide = $fieldset->addField('slide', 'select', array(
			'label'     => Mage::helper('adminhtml')->__('slide'),
			'name'      => 'slide',
			'values'	=> Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray(),
			'value'     => array(1),
		));

		$vertical = $fieldset->addField('vertical', 'select', array(
			'label'     => Mage::helper('adminhtml')->__('Slide Vertical:'),
			'name'      => 'vertical',
			'values'	=> Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray(),
			'value'     => array(0),
		));

		$auto = $fieldset->addField('auto', 'select', array(
			'label'     => Mage::helper('adminhtml')->__('Auto Play:'),
			'name'      => 'auto',
			'values'	=> Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray(),
			'value'     => array(1),
		));

		$controls = $fieldset->addField('controls', 'select', array(
			'label'     => Mage::helper('adminhtml')->__('Show Next/Back control:'),
			'name'      => 'controls',
			'values'	=> Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray(),
			'value'     => array(1),
		));

		$pager = $fieldset->addField('pager', 'select', array(
			'label'     => Mage::helper('adminhtml')->__('Show Pager control:'),
			'name'      => 'pager',
			'values'	=> Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray(),
			'value'     => array(1),
		));	

        $speed = $fieldset->addField('speed', 'text', array(
            'name'      => 'speed',
            'label'     => Mage::helper('adminhtml')->__('Play Speed'),
            'title'     => Mage::helper('adminhtml')->__('Play Speed'),
            'required'  => false,
            'value'     => 1000,
            'class'     => 'validate-greater-than-zero',
        ));

        $pause = $fieldset->addField('pause', 'text', array(
            'name'      => 'pause',
            'label'     => Mage::helper('adminhtml')->__('Pause:'),
            'title'     => Mage::helper('adminhtml')->__('Pause:'),
            'required'  => false,
            'class'     => 'validate-greater-than-zero',
        ));

		$row = $fieldset->addField('row', 'select', array(
			'label'     => Mage::helper('adminhtml')->__('Display Row in Slide:'),
			'name'      => 'row',
			'values'	=> Mage::getSingleton('magicproduct/system_config_row')->toOptionArray(),
			'value'     => array(1),
		));

        $fieldset->addField('marginColumn', 'text', array(
            'name'      => 'marginColumn',
            'label'     => Mage::helper('adminhtml')->__('Margin column:'),
            'title'     => Mage::helper('adminhtml')->__('Margin column:'),
            'value'		=> 30,
            'required'  => false,
            'class'     => 'validate-greater-than-zero',
        ));

        $delay = $fieldset->addField('productDelay', 'text', array(
            'name'      => 'productDelay',
            'label'     => Mage::helper('adminhtml')->__('Product Delay:'),
            'title'     => Mage::helper('adminhtml')->__('Product Delay:'),
            'value'		=> 500,
            'required'  => false,
            'class'     => 'validate-greater-than-zero',
        ));

        $fieldset->addField('widthImages', 'text', array(
            'name'      => 'widthImages',
            'label'     => Mage::helper('adminhtml')->__('Width of Images:'),
            'title'     => Mage::helper('adminhtml')->__('Width of Images:'),
            'value' 	=> 200,
            'required'  => false,
            'class'     => 'validate-greater-than-zero',
        ));

        $fieldset->addField('heightImages', 'text', array(
            'name'      => 'heightImages',
            'label'     => Mage::helper('adminhtml')->__('Height of Images:'),
            'title'     => Mage::helper('adminhtml')->__('Height of Images:'),
            'value' 	=> 250,
            'required'  => false,
            'class'     => 'validate-greater-than-zero',
        ));

        $fieldset->addField('action', 'multiselect', array(
            'name'      => 'action',
            'label'     => Mage::helper('adminhtml')->__('Show Action product:'),
            'title'     => Mage::helper('adminhtml')->__('Show Action product:'),
            'values'	=> Mage::getSingleton('magicproduct/system_config_action')->toOptionArray(),
            'value'		=> array('cart', 'compare', 'wishlist', 'review'),
        ));
		
		// $fieldset->addField('select2', 'select', array(
		// 	'label'     => Mage::helper('adminhtml')->__('Select Type2'),
		// 	'class'     => 'required-entry',
		// 	'required'  => true,
		// 	'name'      => 'title',
		// 	'onclick' => "",
		// 	'onchange' => "",
		// 	'value'  => '4',
		// 	'values' => array(
		// 		'-1'=>'Please Select..',
		// 		'1' => array(
		// 		                'value'=> array(array('value'=>'2' , 'label' => 'Option2') , array('value'=>'3' , 'label' =>'Option3') ),
		// 		                'label' => 'Size'    
		// 		           ),
		// 		'2' => array(
		// 		                'value'=> array(array('value'=>'4' , 'label' => 'Option4') , array('value'=>'5' , 'label' =>'Option5') ),
		// 		                'label' => 'Color'   
		// 		           ),                                         
				  
		// 	               ),
		// 	'disabled' => false,
		// 	'readonly' => false,
		// 	'after_element_html' => '<small>Comments</small>',
		// 	'tabindex' => 1
		// ));


		// $fieldset->addField('advanced_settings', 'textarea', array(
		// 	'label'     => Mage::helper('adminhtml')->__('Advanced Settings'),
		// 	'required'  => false,
		// 	'name'      => 'advanced_settings',
		// 	'note'   	=> "Default : {numbers_align: 'right',animation:'fade',interval: 1000,dots: true,navigation: false}"
		// )); 
		
		if (Mage::getSingleton('adminhtml/session')->getMagicproductData())
		{
			$form->setValues(Mage::getSingleton('adminhtml/session')->getMagicproductData());
			Mage::getSingleton('adminhtml/session')->setMagicproductData(null);
		} elseif ( Mage::registry('magicproduct_data') ) {
            $data = Mage::registry('magicproduct_data')->getData();
            if($data) $form->setValues($data);
		}

        $this->setForm($form);
        $this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
            ->addFieldMap($slide->getHtmlId(), $slide->getName())
            ->addFieldMap($vertical->getHtmlId(), $vertical->getName())
            ->addFieldMap($auto->getHtmlId(), $auto->getName())
            ->addFieldMap($controls->getHtmlId(), $controls->getName())
            ->addFieldMap($pager->getHtmlId(), $pager->getName())
            ->addFieldMap($speed->getHtmlId(), $speed->getName())
            ->addFieldMap($pause->getHtmlId(), $pause->getName())
            ->addFieldMap($row->getHtmlId(), $row->getName())
            ->addFieldMap($delay->getHtmlId(), $delay->getName())

            ->addFieldDependence( $vertical->getName(), $slide->getName(), '1' )
            ->addFieldDependence( $auto->getName(), $slide->getName(), '1' )
            ->addFieldDependence( $controls->getName(), $slide->getName(), '1' )
            ->addFieldDependence( $pager->getName(), $slide->getName(), '1' )
            ->addFieldDependence( $speed->getName(), $slide->getName(), '1' )
            ->addFieldDependence( $pause->getName(), $slide->getName(), '1' )
            ->addFieldDependence( $row->getName(), $slide->getName(), '1' )
            ->addFieldDependence( $delay->getName(), $slide->getName(), '0' )
        );

		return parent::_prepareForm();
	}
}
