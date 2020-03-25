<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-25 17:02:47
 * @@Modify Date: 2015-11-06 17:12:09
 * @@Function:
 */
?>
<?php

class Magiccart_Magicinstall_Model_Import_Cms extends Mage_Core_Model_Abstract
{
	private $_importPath;

	public function __construct()
    {
        parent::__construct();
		//$this->_importPath = Mage::getModuleDir('etc', 'Magiccart_Magicinstall'). '/import/';
		$this->_importPath = Mage::getBaseDir().'/app/code/local/Magiccart/Magicinstall/etc/import/';
    }
	
	/**
	 * Import CMS items
	 * @param string model string
	 * @param string name of the main XML node (and name of the XML file)
	 * @param bool overwrite existing items
	 */

	public function importCmsItems($typeModel, $typeImport, $theme, $overwrite = false, $storeIds=array(0))
    {
		try
		{
			$xmlPath = $this->_importPath . $theme .DIRECTORY_SEPARATOR. $typeImport . '.xml';
			if (!is_readable($xmlPath)) throw new Exception(Mage::helper('adminhtml')->__("Can't read data file: %s", $xmlPath));
			$xmlObj = new Varien_Simplexml_Config($xmlPath);
			
			$conflictingOldItems = array();
			$i = 0;
			if($xmlObj->getNode($typeImport)){
				foreach ($xmlObj->getNode($typeImport)->children() as $item){
					//Check if block already exists
					$oldBlocks = Mage::getModel($typeModel)->getCollection()
						->addFieldToFilter('identifier', $item->identifier)
						->addStoreFilter($storeIds);
					
					//If items can be overwritten
					if ($overwrite){
						if (count($oldBlocks) > 0){
							$conflictingOldItems[] = $item->identifier;
							foreach ($oldBlocks as $old) $old->delete();
						}
					}else {
						if (count($oldBlocks) > 0){
							$conflictingOldItems[] = $item->identifier;
							continue;
						}
					}
					// var_dump(get_class_methods($item));die;
					Mage::getModel($typeModel)->setInstanceId($item->instance_id)
											->setData($item->asArray())
											->setStores($storeIds)
											->save();
					$i++;
				}
			}

			//Final info
			
			if ($i) Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__("Number of imported items: %s $typeImport", $i));
			else Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('adminhtml')->__("No $typeImport items were imported"));
			
			if ($overwrite){
				if ($conflictingOldItems)
					Mage::getSingleton('adminhtml/session')->addSuccess(
						Mage::helper('adminhtml')->__('Items (%s) with the following identifiers were overwritten:<br />%s', count($conflictingOldItems), implode(', ', $conflictingOldItems))
					);
			}else{
				if ($conflictingOldItems)
					Mage::getSingleton('adminhtml/session')->addNotice(
						Mage::helper('adminhtml')->__('Unable to import items (%s) with the following identifiers (they already exist in the database):<br />%s', count($conflictingOldItems), implode(', ', $conflictingOldItems))
					);
			}
		}
		catch (Exception $e)
		{
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			// Mage::logException($e);
		}
    }

	public function deleteCmsItems($typeModel, $typeImport, $theme, $storeIds=array(0))
    {
		try
		{
			$xmlPath = $this->_importPath . $theme .DIRECTORY_SEPARATOR. $typeImport . '.xml';
			if (!is_readable($xmlPath)) throw new Exception(Mage::helper('adminhtml')->__("Can't read data file: %s", $xmlPath));
			$xmlObj = new Varien_Simplexml_Config($xmlPath);

			$conflictingOldItems = array();
			$i = 0;
			if($xmlObj->getNode($typeImport)){
				foreach ($xmlObj->getNode($typeImport)->children() as $item){
					$model = Mage::getModel($typeModel)->load($item->identifier);
			        $storesOld = $model->getStoreId();
			        $storeNew = array();
			        if(is_array($storesOld)){
				        foreach ($storesOld as $storeId) {
				            if (!in_array($storeId, $storeIds)) $storeNew[] = $storeId;
				        }			        	
			        } else {
			        	if (!in_array($storesOld, $storeIds)) $storeNew[] = $storesOld;
			        }

			        if (!$storeNew) $model->delete();
			        else $model->setStores($storeNew)->save();
					$i++;
				}
			}

			//Final info
			
			if ($i) Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__("Number of uninstall items: %s $typeImport", $i));
			else Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('adminhtml')->__("No $typeImport items were uninstall"));
		}
		catch (Exception $e)
		{
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			// Mage::logException($e);
		}
    }

    /**
     * Import Widget items
     * @param string model string
     * @param string name of the main XML node (and name of the XML file)
     * @param bool overwrite existing items
     */

    public function importWidgetItems($typeModel, $typeImport, $theme, $overwrite = false, $storeIds=array(0))
    {
        try
        {
            $xmlPath = $this->_importPath . $theme .DIRECTORY_SEPARATOR. $typeImport . '.xml';
            if (!is_readable($xmlPath)) throw new Exception(Mage::helper('adminhtml')->__("Can't read data file: %s", $xmlPath));
            $xmlObj = new Varien_Simplexml_Config($xmlPath);
            $i = 0;
            if($xmlObj->getNode($typeImport)){
	            foreach ($xmlObj->getNode($typeImport)->children() as $item){
	                $model = Mage::getModel($typeModel)
							->setData($item->asArray())
		                    ->setsStoreIds(implode(',', $storeIds))
		                    ->save();
	                foreach($item->page as $object){
	                    Mage::getSingleton('magicinstall/resource_widget')->importInstancePage($model->getInstanceId(), $object, $item->sort_order, $item->xml);
	                }
	                $i++;
	            }            	
            }
            //Final info
            if($i) Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__("Number of imported items: %s $typeImport", $i));
            else Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('adminhtml')->__("No $typeImport items were imported"));
        } catch (Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            // Mage::logException($e);
        }
    }

    public function importMenuItems($typeModel, $typeImport, $theme, $overwrite = false, $storeIds=array(0))
    {
        try
        {
            $xmlPath = $this->_importPath . $theme .DIRECTORY_SEPARATOR. $typeImport . '.xml';
            if (!is_readable($xmlPath)) throw new Exception(Mage::helper('adminhtml')->__("Can't read data file: %s", $xmlPath));
            $xmlObj = new Varien_Simplexml_Config($xmlPath);
            $i = 0;
            if($xmlObj->getNode($typeImport)){
	            foreach ($xmlObj->getNode($typeImport)->children() as $item){
					//Check if Extra Menu already exists
					$oldMenus = Mage::getModel($typeModel)->getCollection()
										->addFieldToFilter('link', $item->link)
										->load();
					
					//If items can be overwritten
					$overwrite = false; // get in cfg
					if ($overwrite){
						if (count($oldMenus) > 0){
							foreach ($oldMenus as $old) $old->delete();
						}
					}else {
						if (count($oldMenus) > 0){
							continue;
						}
					}
					   	
	                $model = Mage::getModel($typeModel)
								->setData($item->asArray())
			                    ->setsStoreIds(implode(',', $storeIds))
			                    ->save();
	                $i++;
	            }            	
            }
            //Final info
            if($i) Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__("Number of imported items: %s $typeImport", $i));
            else Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('adminhtml')->__("No $typeImport items were imported"));
        } catch (Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            // Mage::logException($e);
        }
    }

    public function importSlideItems($typeModel, $typeImport, $theme, $overwrite = false, $storeIds=array(0))
    {
        try
        {
            $xmlPath = $this->_importPath . $theme .DIRECTORY_SEPARATOR. $typeImport . '.xml';
            if (!is_readable($xmlPath)) throw new Exception(Mage::helper('adminhtml')->__("Can't read data file: %s", $xmlPath));
            $xmlObj = new Varien_Simplexml_Config($xmlPath);
            $i = 0;
            if($xmlObj->getNode($typeImport)){
	            foreach ($xmlObj->getNode($typeImport)->children() as $item){
					//Check if Extra Menu already exists
					$oldSlide = Mage::getModel($typeModel)->getCollection()
										->addFieldToFilter('identifier', $item->identifier)
										->load();
					
					//If items can be overwritten
					$overwrite = false; // get in cfg
					if ($overwrite){
						if (count($oldSlide) > 0){
							foreach ($oldSlide as $old) $old->delete();
						}
					}else {
						if (count($oldSlide) > 0){
							continue;
						}
					}
					   	
	                $model = Mage::getModel($typeModel)->setData($item->asArray())->save();
	                $i++;
	            }            	
            }
            //Final info
            if($i) Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__("Number of imported items: %s $typeImport", $i));
            else Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('adminhtml')->__("No $typeImport items were imported"));
        } catch (Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            // Mage::logException($e);
        }
    }

    public function importSystemConfig($typeModel, $typeImport, $theme, $scope = 'default', $storeIds=array(0))
    {
        try
        {
            $exception = array(
            	'magicproduct/identifier/',
            	'magiccategory/identifier/',
            	);
            $xmlPath = $this->_importPath . $theme .DIRECTORY_SEPARATOR. $typeImport . '.xml';
            if (!is_readable($xmlPath)) throw new Exception(Mage::helper('adminhtml')->__("Can't read data file: %s", $xmlPath));
            $xmlObj = new Varien_Simplexml_Config($xmlPath);
            $i = 0;
            if($xmlObj->getNode($typeImport)){
            	$model = Mage::getModel('core/config');
	            foreach ($xmlObj->getNode($typeImport)->children() as $item){
	            	$node = $item->asArray();
	            	// $item->value->asArray(); // get value path
	            	// $item->value->asArray(); // get value value
					//Check if Config already exists
					$continue = false;
					foreach ($exception as $exp) { // config for magicproduct and magiccategory
						$tmpstr = substr($node['path'], 0, strlen($exp));
						if($tmpstr == $exp){
							$model->saveConfig($node['path'], $node['value'], 'default', 0);
							$i++;
							$continue = true;
						} 
					}
					if($continue) continue;
	            	if(is_array($storeIds)){
	            		foreach ($storeIds as $storeId) {
	            			if($scope == 'websites'){
	            				$oldValue = Mage::app()->getStore($storeId)->getWebsite()->getConfig($node['path']);
	            			}else{
	            				$oldValue = Mage::getStoreConfig($node['path'], $storeId);
	            			}

	            			if($oldValue != $node['value']){
	            				$model->saveConfig($item->path, $node['value'], $scope, $storeId);
	            				$i++;
	            			}
	            		}
	            	} else {
	            		$oldValue = Mage::getStoreConfig($node['path'], $storeIds);
            			if($oldValue != $node['value']){
            				$model->saveConfig($node['path'], $node['value'], $scope, $storeIds);
            				$i++;
            			} 
	            	}
	                
	            }            	
            }
            //Final info
            if($i) Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__("Number of imported items: %s $typeImport", $i));
            else Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('adminhtml')->__("No $typeImport items were imported"));
        } catch (Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            // Mage::logException($e);
        }
    }

	public function deleteSystemConfig($typeModel, $typeImport, $theme, $storeIds=array(0))
    {
		try
		{
			$xmlPath = $this->_importPath . $theme .DIRECTORY_SEPARATOR. $typeImport . '.xml';
			if (!is_readable($xmlPath)) throw new Exception(Mage::helper('adminhtml')->__("Can't read data file: %s", $xmlPath));
			$xmlObj = new Varien_Simplexml_Config($xmlPath);
            $i = 0;
            if($xmlObj->getNode($typeImport)){
            	$model = Mage::getModel($typeModel);
	            foreach ($xmlObj->getNode($typeImport)->children() as $item){
	            	$node = $item->asArray();
	            	// $item->value->asArray(); // get value path
	            	// $item->value->asArray(); // get value value
					//Check if Config already exists
	            	if(is_array($storeIds)){
	            		foreach ($storeIds as $storeId) {
	            			$oldValue = Mage::getStoreConfig($node['path'], $storeId);
	            			if($oldValue != $node['value']){
	            				$model->deleteConfig($node['path'], 'stores', $storeId);
	            				$i++;
	            			}
	            		}
	            	} else {
	            		$oldValue = Mage::getStoreConfig($node['path'], $storeIds);
	            			if($oldValue != $node['value']){
	            				$model->deleteConfig($node['path'], 'stores', $storeIds);
	            				$i++;
	            			} 
	            	}
	            }            	
            }
			//Final info
			
			if ($i) Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__("Number of uninstall items: %s $typeImport", $i));
			else Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('adminhtml')->__("No $typeImport items were uninstall"));
		}
		catch (Exception $e)
		{
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			// Mage::logException($e);
		}
    }

    public function importPermissionsItems($typeModel, $typeImport, $theme, $overwrite = false, $storeIds=array(0))
    {

        try
        {
            $xmlPath = $this->_importPath . $theme .DIRECTORY_SEPARATOR. $typeImport . '.xml';
            if (!is_readable($xmlPath)) throw new Exception(Mage::helper('adminhtml')->__("Can't read data file: %s", $xmlPath));
            $xmlObj = new Varien_Simplexml_Config($xmlPath);
            $i = 0;
            if($xmlObj->getNode($typeImport)){
	            foreach ($xmlObj->getNode($typeImport)->children() as $item){
					//Check if Permissions Block already exists
					$oldSlide = Mage::getModel($typeModel)->getCollection()
										->addFieldToFilter('block_name', $item->block_name)
										->load();
					if (count($oldSlide) > 0) continue;
					else Mage::getModel($typeModel)->setData($item->asArray())->save();
	                $i++;
	            }            	
            }
            //Final info
            if($i) Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__("Number of imported items: %s $typeImport", $i));
            else Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('adminhtml')->__("No $typeImport items were imported"));
        } catch (Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            // Mage::logException($e);
        }

    }

}
