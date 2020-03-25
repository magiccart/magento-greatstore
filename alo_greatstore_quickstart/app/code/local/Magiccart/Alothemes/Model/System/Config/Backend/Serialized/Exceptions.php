<?php

class Magiccart_Alothemes_Model_System_Config_Backend_Serialized_Exceptions
    extends Mage_Adminhtml_Model_System_Config_Backend_Serialized
{
    protected function _beforeSave()
    {
        // Clean given value by removing "__empty" and incomplete sub values
        $value = $this->getValue();
        
        if (is_array(($value))) {
            unset($value['__empty']);
            foreach ($value as $key => $exception) {
                if (trim($exception['selector']) == '') {
                    unset($value[$key]);
                }
            }
        } else {
            $value = array();
        }
        
        $this->setValue($value);
        parent::_beforeSave();
    }
}
