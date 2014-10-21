<?php
class Dao_Node_Source extends Cl_Dao_Node
{
    public $nodeType = 'source';
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
    		'collectionName' => 'source',
        	'documentSchemaArray' => array(
        		'name' => 'string',		 // Name of the news site
        		'url' => 'string', //original url
        		'domains' => 'array', //list of matching patterns for domain
        		// a source such as vnexpress.net might have multiple matching
        		//domains like 'vnexpress.net', 'm.vnexpress.net', 'tab.vnexpress.net'
        	
    	        //'pattern' => 'array',    // matching domains 
        		'slug' => 'string',	     // short name of the site. For example 'nyt' => New York Times
        		'avatar' => 'string',    //paper's avatar
        		'chapo' => 'string',    // Short of the news paper
        		'content' => 'string',  // Description of the news paper
        		'language' => 'string', // which language is this news paper
        		'country' => 'string',  // which country 
    	        'content_uf' => 'string', //unfiltered content where <span class='item'> is converted to proper item links 
        		'tags' => array( 
    	            $tag //maybe available categories ????
    	        ),
        	    'f' => 'int', //featured or not. If is set and equals 1 => featured news.
        	    'fts' => 'int', //featured time
        		'type' => 'int',  // 1 => source, 2 => image, 3 => video, 4 => flash-game, 5 => quiz
        		// 10 => 'ad'
        		'u' => $user, //who posted this	
        		'counter'	=>	array(
        			'c' => 'int',
    	            'f' => 'int', //follow
    	            'r' => 'int', //recommend
    	            'l' => 'int', //likes
    	        ),
        	    
        	    'host' => 'string', //original host, ie. domain name. Such as "vnexpress.net"
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
	    if (!isset($data['ots']) || $data['ots'] == '')
	    {
	        $data['ots'] = $data['ts'];
	    }
        $data['tags'] = array();
	    
        return array('success' => true, 'result' => $data);
	}
	
	public function afterInsertNode($data, $row)
	{
		$this->cacheNodeToRedis($row, array(), $row['slug']);
	    $this->clearAllStaticCache();
        return array('success'=> true, 'result' => $row);
	}
	
    /******************************UPDATE****************************/
    public function beforeUpdateNode($step, $where, $data, $currentRow)
    {
        /*
         * You have $step and $data['$set']['_u'] available
         */
        if ($step == 'feature')
        {
        	if ($data['$set']['f'])
        		$data['$set']['fts'] = time();
        	else
        		$data['$unset']['fts'] = 1;
        }
        
        return array('success' => true, 'result' => $data);
    }
    
	public function afterUpdateNode($step, $where, $data, $currentRow)
    {
    	$this->cacheNodeToRedis($currentRow['id']);
    	$this->clearAllStaticCache();
        return array('success' => true, 'result' => $data);    
    }   
     

	/**
	 * Delete a single node by its Id
	 * @param MongoID $nodeId
	 */
	public function afterDeleteNode($row)
	{
	    
	    $this->clearAllStaticCache();
	    return array('success' => true, 'result' => $row);
	}
	
	function normalizeString($str)
	{
	    $str = unaccent_vietnamese_text(strip_tags($str));
	    $str = trim(strtolower($str));
	    //remove double spaces
	    $str = preg_replace("/(\s)+/", " ", $str);//replace multiple spaces with 1 space
	    return $str;
	}
	
	/**
	 * Prepare data for new node insert
	 * @param Array $dataArray
	 */
	public function prepareFormDataForDaoInsert($dataArray = array(), $formName = "Source_Form_New")
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
	
	public function clearAllStaticCache()
	{
		$dir = get_cache_dir();
		rrmdir($dir);
	}
	
	/**
	 * Given a url like vnexpress.net/tin-tuc/cong-dong/hai-nguoi-nhat-doi-mua-nhat-rac-ben-ho-guom-2956780.html
	 * return the ID of vnexpress
	 * @param unknown_type $url
	 */
	public function getSourceIdFromUrl($domain)
	{
		$domain = strtolower($domain);
		$redis = init_redis();
		$redisKey = "source_domain_mapping:" . $domain;
		if (0 && $redis->get($redisKey))
		{
			return $redis->get($redisKey);
		}
		else 
		{
			//get last TLD m.vnexpress.vn => vnexpress.vn
			$r = $this->findAll();
			if ($r['success'])
			{
				foreach ($r['result'] as $source)
				{
					if (isset($source['domains']))
					{
						foreach ($source['domains'] as $allowedDomain)
						{
							/*
							$path = parse_url("http://" . $allowedDomain);
							f($path);
							//escape "." chars 
							$pattern = str_replace('.', '\.', $allowedDomain);
							$pattern = str_replace('*', '.*', $pattern);
							$pattern = '/' . $pattern . '/';
							f("pattern is ...");
							f($pattern);
							if (preg_match($pattern, $domain))
							{
								//this is the value
								$ret = $redis->set($redisKey, $source['id']);
								return $source['id'];
							}
							*/
							if ($allowedDomain == $domain)
							{
								$ret = $redis->set($redisKey, $source['id']);
								return $source['id'];
							}
						}
					}
				}
			}
		}
		return '';
	}
}
