<?php
/**API stuff
 * User should implement|config the following functions
 * - getHardmappingKeyData()
 * - allHardmappingKeys()
 * **/
class Story_ApiController extends Cl_Controller_Action_NodeIndex
{
	public function indexAction()
	{
		//NOTE that all of this can be moved into core
		$allowed = $this->apiPermission();
		if ($allowed !== true)
			$this->sendApiData('false', $allowed);
		
	    $action = $this->getStrippedParam('_cl_action', 'post'); //'new' or 'newdownload'
	    
	    if ($action == "hardmapping_keys")
	    {
	    	send_json(array('success' => true, 'result' => 
	    		$this->allHardmappingKeys()
			), false);
	    }
	    else if ($action == 'hardmapping')
	    {
	    	$key = $this->getStrippedParam('key');
	    	$ret = array();
	    	
	    	if ($key == 'all')
	    	{
				$allKeys = $this->allHardmappingKeys();
				foreach ($allKeys as $k)
				{
					$ret[$k['name']] = $this->getHardmappingKeyData($k['name']);
				}
	    	}
	    	else 
	    		$ret = $this->getHardmappingKeyData($key);

	    	send_json(array('success' => true, 'result' => $ret), false);
	    }
	    else if ($action == 'preview')
	    {
	        $seedId = $this->getStrippedParam('seed_id');
	        $where = array('seed_id' => $seedId);
	        $r = Dao_Node_Story::getInstance()->findOne($where);
	        if ($r['success'] )
	        {
	            $this->setViewParam('row', $r['result']);
	            $this->setNoRenderer();
	            echo $this->renderScript('index/view.phtml');
	            Bootstrap::$pageTitle = $r['result']['name'];
	        }        
	    }
	    else //POST
	    {
	    	//Cho trang web khac
	    	// $data = $_REQUEST;
	    	// insert_node_from_crawler($data);
            return $this->api("Dao_Node_Story", "Story_Form_New", "Story_Form_Update");
	    }                 
	}
	
	public function allHardmappingKeys()
	{
		return 	    	
			array(
	    		array('name' => 'status', 'type' => 'select', 'valueType' => 'int'),  
	    		array('name' => 'category', 'type' => 'select', 'valueType' => 'string'),
	    		array('name' => 'list', 'type' => 'multicheckbox', 'valueType' => 'string')
	    	);
	}
	
	public function getHardmappingKeyData($key)
	{
		if ($key == 'category')
		{
			$r = Dao_Node_Category::getInstance()->getCategoryTree();
			foreach ($r as $i => $cate)
			{
				$ret[$i] = array('value' => $cate['slug'], 'name' => $cate['tree_name']);
			}
		}
		elseif ($key == 'list')
		{
			$r = Dao_Node_Category::getInstance()->getCategoryTree();
			foreach ($r as $i => $cate)
			{
				$ret[$i] = array('value' => $cate['slug'], 'name' => $cate['tree_name']);
			}
		}
		
		else if ($key == 'status')
		{
			$ret = array(array('value' => 0, 'name' => 'queued'),
					array('value' => 1, 'name' => 'approved'));
		}
		return $ret;
	}
}
