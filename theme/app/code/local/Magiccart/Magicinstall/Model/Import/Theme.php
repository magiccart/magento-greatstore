<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-06-07 12:27:23
 * @@Modify Date: 2015-02-05 15:19:04
 * @@Function:
 */
 ?>
<?php
class Magiccart_Magicinstall_Model_Import_Theme
{

    public function toOptionArray()
    {
        return $this->getAllOptions();
    }

    public function getAllOptions($withEmpty = true)
    {
            $path = Mage::getModuleDir('etc', 'Magiccart_Magicinstall'). '/import/';
            $themes = $this->_listDirectories($path);
            $themeOptions = array();
            foreach ($themes as $theme) {
                $themeOptions[] = array(
                    'label' => $theme,
                    'value' => $theme
                );
            }
            $label = $themeOptions ? Mage::helper('core')->__('-- Select Theme --') : Mage::helper('core')->__('-- Not found theme --');
            if ($withEmpty) {
                array_unshift($themeOptions, array(
                    'value' => '',
                    'label' => $label
                ));
            }
        return $themeOptions;
    }

    private function _listDirectories($path, $fullPath = false)
    {
        $result = array();
        $dir = opendir($path);
        if ($dir) {
            while ($entry = readdir($dir)) {
                if (substr($entry, 0, 1) == '.' || !is_dir($path . DS . $entry)){
                    continue;
                }
                if ($fullPath) {
                    $entry = $path . DS . $entry;
                }
                $result[] = $entry;
            }
            unset($entry);
            closedir($dir);
        }

        return $result;
    }

}
