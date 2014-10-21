<?php
class List_Form_Helper extends Cl_Form_NodeHelper
{
    public function getStatus()
    {
    	$ret = array(0 => 'queued', 1 => 'approved');
    	return array('success' =>true, 'result' => $ret);
    }
    
    public function getSuggestTags()
    {
        $default = array("_begin", "_inter", "_adv");
        $ret = get_conf('suggest_tags', $default);
        return $ret;
    }
}
