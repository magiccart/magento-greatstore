<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-06-07 12:27:23
 * @@Modify Date: 2014-08-08 23:32:08
 * @@Function:
 */
 ?>
<?php
class Magiccart_Alothemes_Model_System_Config_Source_Themecolor
{

	const NSPACE = 'magiccart'; // namespace
	const THEMECLOR = 'themecolor'; // color css

    public function toOptionArray()
    {
        // return array(
        //     array('value'=>'blue', 'label'=>Mage::helper('adminhtml')->__('Blue')),
        //     array('value'=>'green', 'label'=>Mage::helper('adminhtml')->__('Green')),
        //     array('value'=>'orange', 'label'=>Mage::helper('adminhtml')->__('Orange')),
        //     array('value'=>'yellow', 'label'=>Mage::helper('adminhtml')->__('Yellow')),
        // );
        //return array('value'=>array('value'=>array(array('value'=>'themecolor/red.css', 'label'=>'red',)), 'label'=>'default/simple'));
        return $this->getAllOptions();
    }

    public function getAllOptions($withEmpty = true)
    {
            $design = $this->themecolorDetected();
            $options = array();
            foreach ($design as $package => $themes){
                $packageOption = array('label' => $package);
                $themeOptions = array();
                foreach ($themes as $theme) {
                    $themeOptions[] = array(
                        'label' => $theme,
                        'value' => $package.'_'.$theme
                    );
                }
                $packageOption['value'] = $themeOptions;
                $options[] = $packageOption;
            }
            $this->_options = $options;
        $label = $options ? Mage::helper('core')->__('-- Please Select --') : Mage::helper('core')->__('-- One Color --');
        if ($withEmpty) {
            array_unshift($options, array(
                'value' => '',
                'label' => $label
            ));
        }
        return $options;
    }

    public function themecolorDetected()
    {
    	$themecolorDir = $this->themecolorDetectedDir();
    	$colors = array();
        foreach ($themecolorDir as $dir) {
        $files = glob("$dir*.css" ,GLOB_BRACE);
            foreach ($files as $file) {
                $explode  = explode(DS, $file);
                $count    = count($explode);
                $value    = '';
                $i = 0;
                if(self::NSPACE)    {   $value    = $explode[$count-3] .'/'; $i++;  }
                if(self::THEMECLOR) {   $value   .= $explode[$count-2] .'/'; $i++;  }
                $value .=$explode[$count-1];
                $label    = $explode[$count-3-$i] .'/'. $explode[$count-2-$i]; // not true vs NSPACE null
                $colors[$label][] = $value;
            }
        }
        return $colors;
    }

	public function themecolorDetectedDir()
	{
		$frontend 	= Mage::getBaseDir('skin') . DS . 'frontend';
		$packages 	= $this->_listDirectories($frontend, true);
		$themecolor = array();
		foreach ($packages as $package) {
			$themes = $this->_listDirectories($package, true);
			foreach ($themes as $theme) {
				$folders = $this->_listDirectories($theme);
					foreach ($folders as $folder) {
						if(self::NSPACE && $folder == self::NSPACE){
                            $namespace = $theme .DS. $folder;
							$fds = $this->_listDirectories($namespace);
                            foreach ($fds as $fd) {
                                if($fd == self::THEMECLOR) $themecolor[] = $namespace .DS. $fd .DS;
                            }
						}else if(!self::NSPACE && $folder == self::THEMECLOR){
                            $themecolor[] = $theme .DS. $folder .DS;
                        }else if(!self::NSPACE && !self::THEMECLOR){
                            $themecolor[$theme] = $theme .DS; // not use $themecolor[]
                        }
                    }
		      }
        }
        return $themecolor;
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
