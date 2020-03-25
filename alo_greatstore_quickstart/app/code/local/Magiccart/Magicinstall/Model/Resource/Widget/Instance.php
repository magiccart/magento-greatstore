<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: Magiccart<team.magiccart@gmail.com>
 * @@Create Date: 2014-07-25 15:05:55
 * @@Modify Date: 2014-07-25 15:06:36
 * @@Function:
 */

?>
<?php
class Magiccart_Magicinstall_Model_Resource_Widget_Instance extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Define main table
     *
     */
    protected function _construct()
    {
        $this->_init('widget/widget_instance', 'instance_id');
    }
    public function pageItemsLoad($instance_id)
    {
        $adapter = $this->_getReadAdapter();
        $select = $adapter->select()
            ->from($this->getTable('widget/widget_instance_page'))
            ->where('instance_id = ?', (int)$instance_id);
        $results = $adapter->fetchAll($select);
        return $results;
    }
    public function layoutLoad($instance_id){
        $adapter = $this->_getReadAdapter();
        $select = $adapter->select()
            ->from(array('clu' => $this->getTable('core/layout_update')))
            ->joinInner(array('wipl' => $this->getTable('widget/widget_instance_page_layout')),
                'clu.layout_update_id = wipl.layout_update_id')
            ->join(array('wip'=>$this->getTable('widget/widget_instance_page')),
                'wipl.page_id = wip.page_id')
            ->where('wip.instance_id = '.$instance_id);
        $xml = $adapter->fetchAll($select);
        return $xml[0]['xml'];
    }
}
