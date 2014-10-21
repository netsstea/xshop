<?php
class Dao_Node_Template extends Cl_Dao_Node
{
    public $nodeType = 'template';
    public $primaryKey = 'id';    
    public $cSchema = array(
    		'id' => 'string',
    		'name' => 'string',		 // Name of the news site
    		//'pattern' => 'array',    // matching domains
    		'url' => 'string',
    		'slug' => 'string',	     // short name of the site. For example 'nyt' => New York Times
    		'avatar' => 'string',    //paper's avatar
    		'chapo' => 'string',
    		//add other stuff u want
    );
        
    protected function relationConfigs($subject = 'user')
    {
    	if ($subject == 'user')
    	{
    		return array(
    				'1' => '1', //vote | like
    				'2' => '2', //follow
    				'3' => '3' , //flag as spam
    		);
    	}
    }
    
	protected function _configs(){
	    $user = Cl_Dao_Util::getUserDao()->cSchema;
	    $tag = Dao_Node_Tag::getInstance()->cSchema;
    	return array(
    		'collectionName' => 'template',
        	'documentSchemaArray' => array(
        		'name' => 'string',		 // Name of the template
        		'lists' => 'array', //array of lists on the page
        		//TODO: configuration of the lists
        		'layout' => 'mixed', //JSON object describing layout
        		'themes' => 'array', //list of applicable themes,
        		'categories' => 'array', //list of categories which use this template as home page for category
        		'avatar' => 'string',    //avatar
        		'content' => 'string',  // Description of the news paper
    	        'content_uf' => 'string', //unfiltered content where <span class='item'> is converted to proper item links 
        		'u' => $user, //who posted this	
        		'ts' => 'int',
        		'status' => 'int', //0 for queue, 1 for approved
        	)
    	);
	}
	
    /**
     * Add new node
     * @param post data Array $data
     */
	public function beforeInsertNode($data)
	{
        return array('success' => true, 'result' => $data);
	}
	
	public function afterInsertNode($data, $row)
	{
		$this->cacheNodeToRedis($row);
		if (isset($data['categories']) && count($data['categories']) > 0)
			$this->autoInsertListForCategories($data['categories'], $row);
        return array('success'=> true, 'result' => $row);
	}
	
    /******************************UPDATE****************************/
    public function beforeUpdateNode($step, $where, $data, $currentRow)
    {
        
        return array('success' => true, 'result' => $data);
    }
    
	public function afterUpdateNode($step, $where, $data, $currentRow)
    {
    	$this->cacheNodeToRedis($currentRow['id']);
    	if (isset($data['$set']['categories']) && count($data['$set']['categories']) > 0)
    		$this->autoInsertListForCategories($data['$set']['categories'], $currentRow['id']);
    	 
        return array('success' => true, 'result' => $data);    
    }   
    
    public function autoInsertListForCategories($categorySlugs, $row)
    {
    	if (!is_array($row))
    	{
    		$r = $this->findOne(array('id' => $row));
    		if ($r['success'])
    			$row = $r['result'];
    		else return $r;
    	}
    	
    	//$row is template object
    	$name = $row['name'];
    	$lists = $row['lists'];
    	foreach ($categorySlugs as $cate)
    	{
    		foreach ($lists as $list)
    		{
	    		//insert new list of the form 
	    		$slug = "$cate:category:$list";
	    		//find if slug already exists
	    		$newList = array(
	    			'slug' => $slug,		
	    			'name' => "Category list $list : $cate",
	    			'items_type' => 'story'	,
	    			'limit' => '10'
	    				
	    		); 
	    		Dao_Node_List::getInstance()->insertNode($newList);
    		}
    	}
    }
     

	/**
	 * Delete a single node by its Id
	 * @param MongoID $nodeId
	 */
	public function afterDeleteNode($row)
	{
	    return array('success' => true, 'result' => $row);
	}
	/**
	 * Prepare data for new node insert
	 * @param Array $dataArray
	 */
	public function prepareFormDataForDaoInsert($dataArray = array(), $formName = "Template_Form_New")
	{
		return $dataArray;
	}	
	

	/******************************RELATION*********************************/
	public function beforeInsertRelation($data)
	{
		return array('success' => true, 'result' => $data);
	}
	public function afterInsertRelation($data, $newRelations, $currentRow)
	{
		return array('success' => true, 'result' => $data);
	}
	public function afterDeleteRelation($currentRow, $rt, $newRelations = array())
	{
	    return array('success' => true);
	}
	
	public function filterNewObjectForAjax($obj, $formData)
	{
		return array('id' => $obj['id'] /*, 'slug' => $obj['slug'] */);
	}
	
	public function filterUpdatedObjectForAjax($currentRow, $step, $data, $returnedData)
	{
		$ret = array('id' => $currentRow['id']);
		return $ret;
		/*
		 if (isset($data['slug']))
			$ret['slug'] = $data['slug'];
		elseif (isset($currentRow['slug']))
		$ret['slug'] = $currentRow['slug'];
		return $ret;
		*/
	}

	public function getListsByPage($page, $theme = 'default')
	{
		$where = array('name' => $page,
				'themes' => $theme
		);
		$t = $this->findOne($where);
		if ($t['success'])
		{
			$template = $t['result'];
			$lists = $template['lists'];
			foreach ($lists as $i => $l)
			{
				$lists[$i] = $template['name'] . ':' . $l;
			} 
			return $lists;
		}
		return array();
	}
}
