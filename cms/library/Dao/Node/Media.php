<?php
class Dao_Node_Media extends Cl_Dao_Node
{
    public $nodeType = 'media';
    public $cSchema = array(
    		'id' => 'string',
    		'name' => 'string',
    		'avatar' => 'string',
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
    		'collectionName' => 'media',
        	'documentSchemaArray' => array(
        		'name' => 'string',
        		'slug' => 'string',
    	        'chapo' => 'string',
        		'avatar' => 'string',
        		'content' => 'string',
    	        'content_uf' => 'string', //unfiltered content where <span class='item'> is converted to proper item links 
        		'tags' => array( 
    	            $tag
    	        ),
        		'items' => array(
        			array('id' => 'string', 
        					'iid' => 'int', 
        					'slug' => 'string',
        					'type' => 'string',
        					'name' => 'string')
        		),
        		'items_order' => 'array',
        		'items_type' => 'string',
        			 
        	    'f' => 'int', //featured or not. If is set and equals 1 => featured news.
        	    'fts' => 'int', //featured time
        		'type' => 'int',  // 1 => story, 2 => image, 3 => video, 4 => flash-game, 5 => quiz
        		// 10 => 'ad'
        		'u' => $user, //who posted this	
        		'counter'	=>	array(
        			'c' => 'int',
    	            'f' => 'int', //follow
    	            'r' => 'int', //recommend
    	            'l' => 'int', //likes
    	        ),
        	    'category' => 'string', //category's slug
        	    'categories' => 'array', //array of ancestors' category slug
        	    'seed_id' => 'string', //crawled seed id
        	    'ourl' => 'string', //original url
        	    'host' => 'string', //original host, ie. domain name. Such as "vnexpress.net"
        	        
        		'comments' => array ( //comments can be embedded right into the node.
       					array(
        						'u'	=> $user,
                                //'content'	=>	'string',
       					        'fcontent' => 'string', //filtered content
                                'ts'	=>	'mixed',
                                'id'	=>	'mixed',
                                'vc' => 'int', //vote count
                                'uv' => 'array' //array uid voted
                            )
                        ),
        		'ts' => 'int',
        	    'ots' => 'int', //original article's posted timestamp
        		'status' => 'int', //0 for queue, 1 for approved
        		'weight' => 'int'
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
        return array('success'=> true, 'result' => $row);
	}
	
    /******************************UPDATE****************************/
    public function beforeUpdateNode($step, $where, $data, $currentRow)
    {

        return array('success' => true, 'result' => $data);
    }
    
	public function afterUpdateNode($step, $where, $data, $currentRow)
    {
    	if ($data['$set']['_cl_step'] == 'items_order')
    	{
    		$this->cacheItemsOrder($currentRow['id']);
    	}
        return array('success' => true, 'result' => $data);    
    }   
	
    /**
     * @param SyllabusId $id
     */
    public function cacheItemsOrder($id)
    {
    	$r = $this->findOne(array('id' => $id));
    	if (!$r['success'])
    	{
    		return $r;
    	}
    	else
    		$syllabus = $r['result'];
    
    	if (!isset($syllabus['items_order']) || count($syllabus['items_order']) == 0)
    		return array('success' => true);
    	
    	
    	//find all the units
    	$where = array('id' => array('$in' => $syllabus['items_order']));
    
    	$cond = array('where' => $where, 'order' => array('_id' => 1));
    	$daoClass = "Dao_Node_" . ucwords($syllabus['items_type']);

    	$unitDao = $daoClass::getInstance();
    	
    	$r = $unitDao->findAll($cond);
    	if ($r['success'])
    	{
    		$units = $r['result'];
    		// if syllabus already has 'units_order'
    		// the we should sort $units first by units_order
    		 
    		if (isset($syllabus['items_order']))
    		{
    			$tmp = array();
    			foreach ($syllabus['items_order'] as $unitId)
    			{
    				foreach ($units as $unit)
    				{
    					if ($unit['id'] == $unitId)
    					{
    						$tmp[] = $unit;
    					}
    				}
    			}
    
    			foreach ($units as $unit)
    			{
    				if (!in_array($unit['id'], $syllabus['items_order']))
    					$tmp[] = $unit;
    			}
    			$units = $tmp;
    		}
    
    		$cache = array();
    		 
    		$lessonCount = 0;
    		foreach ($units as $unit)
    		{
    			//$lessonCount = 0;
    			$t = $unitDao->getCacheObject($unit);
    			if ($t['success'])
    			{
    				$cache[] = $t['result'];
    			}
    		}
    		//update list of units and units counter
    		$update = array('$set' =>
    				array(
    						'items' => $cache,
    				)
    		);
    		$this->update(array('id' => $id), $update);
    		//reorder the lessons according to the array of unit ids in 'units_order'
    		$this->reorderArray($id, 'items', 'items_order');
    	}
    	//$this->cacheNodeToRedis($id);
    
    	return array('success'=> true);
    }
	/**
	 * Delete a single node by its Id
	 * @param MongoID $nodeId
	 */
	public function afterDeleteNode($row)
	{
	    //delete all comments
	    return array('success' => true, 'result' => $row);
	}
	
	/**
	 * Prepare data for new node insert
	 * @param Array $dataArray
	 */
	public function prepareFormDataForDaoInsert($dataArray = array(), $formName = "Story_Form_New")
	{
		return $dataArray;
	}	
	
	public function prepareCommentFormDataForDao($dataArray = array())
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
	
}
