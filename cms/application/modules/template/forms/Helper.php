<?php
class Template_Form_Helper extends Cl_Form_NodeHelper
{
    public function getStatus()
    {
    	$ret = array(0 => 'queued', 1 => 'approved');
    	return array('success' =>true, 'result' => $ret);
    }
    


    public function prefixWithName($data, $elName, $val, $reverse = false, $elConfig = array())
    {
    	if (!$reverse)
    	{
    		foreach ($val as $i => $v)
    			$val[$i] = $data['name'] . ':' . $v;
    	}
    	else
    	{
    		foreach($val as $i => $v)
    		{
    			$tmp = explode(":", $v);
    			array_shift($tmp);
    			$val[$i] = implode(":", $tmp);
    		}
    	}
    	return $val;
    }
    /*
    public function getItemsPerPageList($params)
    {
    	$ret = array(
    	    '-1' => "All",
    		'10' => "10/page",
    		'20' => "20/page",
    		'30' => "30/page",	
    		'50' => "50/page");
    	return array('success' => true, 'result' => $ret);
    }
    */
}
