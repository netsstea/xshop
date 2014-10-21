<?php
class Dao_Node_Story extends Cl_Dao_Node
{
    public $nodeType = 'story';
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
    		'collectionName' => 'story',
        	'documentSchemaArray' => array(
        		'name' => 'string',
    	        'slug' => 'string',
        		'iid' => 'int',
    	        'chapo' => 'string',
        		'avatar' => 'string',
        		'oavatar' => 'string',
        		'content' => 'string',
        		'mcontent' => 'string', //mobile content, where images have been resized
        		'tcontent' => 'string', //tab content ,images have been resized
        		'scontent' => 'string', //simple content (no image), (for stupid phones) 
    	        'content_uf' => 'string', //unfiltered content where <span class='item'> is converted to proper item links 
        		'tags' => array( 
    	            $tag
    	        ),
        	    'f' => 'int', //featured or not. If is set and equals 1 => featured news.
        	    'fts' => 'int', //featured time
        		'type' => 'int',  // 1 => story, 2 => image, 3 => video, 4 => flash-game, 5 => quiz
        		// 10 => 'ad'
        		'u' => $user, //who posted this	
        		'counter'	=>	array(
        			'c' => 'int', //comments
    	            'f' => 'int', //follow
    	            'r' => 'int', //recommend
    		        's' => 'int', //shares
    	            'l' => 'int', //likes
    	            'point' => 'long' //point after calculate like+share+comment
    	        ),
        	    'category' => 'string', //category's slug
        	    'categories' => 'array', //array of ancestors' category slug
        	    'seed_id' => 'string', //crawled seed id
        	    'ourl' => 'string', //original url
        	    'host' => 'string', //original host, ie. domain name. Such as "vnexpress.net"
        	    'source' => 'string', //source's slug
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
	    $fb_count = fb_counter($data['ourl']);
	    $like = $fb_count['data']['0']['like_count'];
	    $share = $fb_count['data']['0']['share_count'];
	    $comment = $fb_count['data']['0']['comment_count'];
	    $total = $fb_count['data']['0']['total_count'];
	    $data['counter']['l'] = $like;
	    $data['counter']['c'] = $comment;
	    $data['counter']['s'] = $share;
	    
		if (!isset($data['type']) || $data['type'] == '')
		{
			$data['type'] = 1;
		}
		
	    if (!isset($data['ots']) || $data['ots'] == '')
	    {
	        $data['ots'] = $data['ts'];
	    }
	    
	    if (isset($data['ourl']) && $data['ourl'] != '')
	    {
	    	if (strpos(strtolower($data['ourl']), 'http://') === false)
	    	{
	    		$data['ourl'] = "http://" . $data['ourl'] ;
	    	}
	    	$path = parse_url($data['ourl']);
	    	$host = $path['host'] ;//domain
	    	$data['source'] = Dao_Node_Source::getInstance()->getSourceIdFromUrl($host);
	    }
	     
	    if (!isset($data['iid']))
	    	$data['iid'] = $this->generateIid();
	     
	    if (get_value('_cl_test_crawler') == 1)
	    {
	    	$data['id'] = new MongoId();
	    	return array('success' => true, 'result' => $data, 'stop_propagation' => true);
	    }
	    //Tags
	    if (isset($data['tags']) && count($data['tags']) > 0)
	    {
	    	//unset  tag name 'featured' if user's not allowed
	    	foreach ($data['tags'] as $k => $tag){
	    		if($tag['name'] == featured_tag() && !has_perm('admin_story')){
	    			unset($data['tags'][$k]);
	    		}
	    	}
	    
	    	$r = Dao_Node_Tag::getInstance()->insertNewTags($data['tags']);
	    	if (!$r['success'])
	    		return $r;
	    	else
	    		$data['tags'] = $r['result'];
	    }
	    else 
	        $data['tags'] = array();
	    $data['slug'] = Cl_Utility::getInstance()->generateSlug($data['name']);
	    //get featured tags and automatically insert the tags into story if matched
	    $t = Dao_Node_Tag::getInstance()->getFeaturedTags();
	    
	    if ($t['success'] && count($t['result']) > 0)
	    {
	        $autoTags = array();
	        foreach ($t['result'] as $tag)
	        {
	            //see if $tag['keywords'] matches $data['name'], $data['chapo']
	            if ($this->isMatchingTag($tag, $data))
	            {
	                $autoTags[] = $tag;
	            }
	        }
	        if (count($autoTags) > 0)
	        {
	            foreach ($autoTags as $autoTag)
	            {
	                $shouldBeAdded = true;
    	            foreach ($data['tags'] as $t)
    	            {
    	                if ($t['name'] == $autoTag['name'])
    	                {
    	                    $shouldBeAdded = true;
    	                    break;
    	                }        
    	            }
    	            if ($shouldBeAdded)
    	                $data['tags'][] = $autoTag;
	            }
	        }
	    }
	    
        return array('success' => true, 'result' => $data);
	}
	
	public function afterInsertNode($data, $row)
	{
	    //calculate point of story then update to db.
        $r = calculate_story_point($row['counter']['l'],
                $row['counter']['s'],$row['counter']['c'],$row['ts']);
        $where = array('id' => $row['id']);
        $this->update($where,array('$set' => array('counter.point' => $r)));
	    //TODO: insert Story to list after success
	    $list = $data['list'] ? $data['list']: array();
	    if(count($list) >0)
	       Dao_Node_List::getInstance()->autoAddItemToList($list,$row);
		//TODO: refresh the lists
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
        //if success. Insert the newly added concepts if any
        if (isset($data['$set']['tags']) && count($data['$set']['tags']) > 0)
        {
        	//unset  tag name 'featured'
        	foreach ($data['$set']['tags'] as $k => $tag){
        		if($tag['name'] == featured_tag() && !has_perm('admin_story')){
        			unset($data['$set']['tags'][$k]);
        		}
        	}
        		
        	$r = Dao_Node_Tag::getInstance()->insertNewTags($data['$set']['tags']);
        	if (!$r['success'])
        	{
        		return $r;
        	}
        	else
        	{
        		$data['$set']['tags'] = $r['result'];
        	}
        	
        	f($data['$set']['tags']);
        }        
        if (isset($data['$set']['ourl']) && $data['$set']['ourl'] != '')
        {
        	$path = parse_url($data['$set']['ourl']);
        	$host = $path['host'] ;//domain
        	$data['$set']['source'] = Dao_Node_Source::getInstance()->getSourceIdFromUrl($host);
        }
        
        return array('success' => true, 'result' => $data);
    }
    
	public function afterUpdateNode($step, $where, $data, $currentRow)
    {
    	$this->clearAllStaticCache();
        return array('success' => true, 'result' => $data);    
    }   
     
	/******************************INSERT_COMMENT****************************/
    /**
     * You have $node = $data['_node'];
     */
	public function beforeInsertComment($data)
	{
	    $node = $data['_node'];
	    	        
        $data['node'] = array(
            'id'	=>	$data['nid'],
		);
        
		//$data['status'] = 0;
        
        if (isset($node['name']) && !empty($node['name']))
            $data['node']['name']	=	$node['name'];
        else if (isset($node['content']))
            $data['node']['name']	= word_breadcumb($node['content'], CACHED_POST_TITLE_WORD_LENGTH);
	    
        if(isset($data['attachments']) && (is_null($data['attachments']) || $data['attachments'] == ''))
        	unset($data['attachments']);
        if (isset($data['category']) && $data['category'] == 'hot')
            $data['f'] = 1;
		return array('success' => true, 'result' => $data);
	}
		
	/**
     * You have $node = $data['_node'];
	 * Add new comment to a post
	 * @param POST data $data
	 */
	public function afterInsertComment($data, $comment)
	{
	    return array('success' => true, 'result' => $comment);
	}
	
	public function beforeUpdateComment($step, $where, $data, $row)
	{
        if($step == 'is_spam') {
            // incresase counter.spam
            $data['$inc'] = array('counter.spam' => 1);
        }
		return array('success' => true, 'result' => $data);
	}
	
	
	public function afterUpdateComment($step, $where, $data, $row)
	{
        if(($step == 'is_spam') && 
                (in_array('admin', $data['$set']['roles']) || in_array('root', $data['$set']['roles']))
           )
        {
            // mark is_spammer
            $dataUpdate = array('$set' => array('is_spam' => 1));
            $cWhere = array('id' => $row['id']);
            Dao_Comment_Story::getInstance()->update($cWhere, $dataUpdate);
            
            // TODO: 
        }
        
		return array('success' => true, 'result' => $data);
	}
	
	/**
	 * Delete a single node by its Id
	 * @param MongoID $nodeId
	 */
	public function afterDeleteNode($row)
	{
	    //delete all comments
	    $commentDao = Dao_Comment_Story::getInstance();
	    $where = array('node.id' => $row['id']);
	    $commentDao->delete($where);
	    
	    $this->clearAllStaticCache();
	    return array('success' => true, 'result' => $row);
	}
	
	public function afterInsertTag($tag)
	{
	    $where = array('tags.id' => array('$ne' => $tag['id'])); 
	    //loop all stories and tag it if it matches title & summary
	    $r = $this->findAll(array('where' =>$where));    
	    if ($r['success'])
	    {
	        //f(count($r['result']));
	        foreach ($r['result'] as $row)
	        {
	            if ($this->isMatchingTag($tag, $row))
	            {
    	            $this->addTagToStory($tag, $row);
	            }
	        }
	    }
	    $this->clearAllStaticCache();
	    return array('success' => true);
	}
	
	public function afterUpdateTag($tag, $oldTag /* current tag*/)
	{
	    $where = array('tags.id' => array('$ne' => $tag['id']));
	     
	    $r = $this->findAll(array('where' =>$where));
	    //TODO: 
	    if ($r['success'])
	    {
	    	//f(count($r['result']));
	    	foreach ($r['result'] as $row)
	    	{
	    		if ($this->isMatchingTag($tag, $row))
	    		{
	    			$this->addTagToStory($tag, $row);
	    		}
	    	}
	    }
	    $this->clearAllStaticCache();
	    return array('success' => true);
	}
	
	public function addTagToStory($tag, $row)
	{
    	//f($row['name'] . ' does not match');
    	$currentTags = (isset($row['tags']) && count($row['tags']) > 0) ? $row['tags'] : array();
    	$add = true;
    	foreach ($currentTags as $t)
    	{
    		if ($t['slug'] == $tag['slug'])
    		{
    			$add = false;
    			break;
    		}
    	}
    	if ($add)
    	{
    		$currentTags[] = $tag;
    		$update = array('$set' => array('tags' => $currentTags));
    		$this->update(array('id' => $row['id']), $update);
    	}
	}
	function normalizeString($str)
	{
	    $str = unaccent_vietnamese_text(strip_tags($str));
	    $str = trim(strtolower($str));
	    //remove double spaces
	    $str = preg_replace("/(\s)+/", " ", $str);//replace multiple spaces with 1 space
	    return $str;
	}
	
	public function isMatchingTag($tag, $row)
	{
		//1. Search for matching categories
		$matchingCate = true;
		if (isset($tag['keywords_cate']) && count($tag['keywords_cate']) > 0)
		{
			if (!in_array($row['category'], $tag['keywords_cate']))
				$matchingCate = false;
		}
		if (!$matchingCate)
		{
			f($tag);
			f($row);
			return false;
		}
		//2. search for keywords
	    $keywordsMatched = 0;
	    
	    $title = $this->normalizeString($row['name']);
	    $chapo = $this->normalizeString($row['chapo']);

	    
	    $keywords = isset($tag['keywords']) ? $tag['keywords'] : array();
	    //$keywords can be "Bien dong,Truong Sa + Trung Quoc"
	    foreach($keywords as $keyword)
	    {
	        $match = true; //match $keyword

	        $terms = explode('+', $keyword); //"Truong Sa", "Trung Quoc"
	        //it must match every term
	        foreach ($terms as $term)
	        {
	            $term = $this->normalizeString($term);
	            //doesn't match either title or summary
	            if (
                    (
                        strlen($title) == 0 ||
        	            (strlen($title) > 0 && strpos($title, $term) === false)
                    )
    	                && 
                    (
    	                strlen($chapo) == 0 ||
    	                (strlen($chapo) > 0 && strpos($chapo, $term) === false)
                    )
                )
	            {
	                $match = false;
	                break;
	            }
	        }
	        
	        if ($match)
	        {
	            $keywordsMatched++;
	        }
	    }
	    if ($keywordsMatched > 0 /*$tag['keywords_minimum_matching_count'] */)
	        return true;
	    else 
	        return false;
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
	
	public function clearAllStaticCache()
	{
		$dir = get_cache_dir();
		rrmdir($dir);
	}
	
	/**
	 * Reformat for category or 'view' a detailed story
	 * @param unknown_type $row
	 * @param unknown_type $type
	 * @return string
	 */
	public function reformatStory($row, $type = 'category')
	{
		if (isset($row['content_uf']))
			unset($row['content_uf']);
		
		$row['url'] = node_link('story', $row);
		
		$cateDao = Dao_Node_Category::getInstance();
		$category = $cateDao->getCategory('slug', $row['category']);
		$row['category_name'] = $category['name'];
		//category tree
		$row['category_tree'][] = $category;
		if ($type == 'view')
		{
			
			while (isset($category['pid']) && $category['pid'] != 0)
			{
				$category = $cateDao->getCategory('id' , $category['pid']);
				$row['category_tree'][] = $category;
				
			}
			
			foreach ($row['category_tree'] as $cate)
			{
				$cateSlugs[] = $cate['slug'];
			}
			
			$row['categorySlugs'] = $cateSlugs;
			$row['category_tree'] = array_reverse($row['category_tree']);
		}	
			 
		if ($type == 'category')
			unset($row['content']);

		if (isset($row['source']) && $row['source'] != '')
		{
			$row['sourceInfo'] = Dao_Node_Source::getInstance()->getNodeFromRedis($row['source']);
		}
		
		if (!isset($row['ots']))
			$row['ots'] = $row['ts'] ;//= time() - 60 * 60 * 3; //3 hours ago
		$row['ago'] = convert_ts_to_js($row['ots']);
		if (!isset($row['chapo']))
			$row['chapo'] = $row['name'];
		if (!isset($row['avatar']) )
			$row['avatar'] = '';
		$row['link'] = node_link('story', $row);
		return $row;
	}
	
	
	public function getByList($listSlug)
	{
		$top = array();
		$t = Dao_Node_List::getInstance()->findOne(array('slug' => $listSlug));
		if ($t['success'])
		{
			$items = $t['result']['items_order'];
			$where = array('id' => array('$in' => $items));
			$r = $this->findAll(array($where));
			if ($r['success'])
			{
				$top = sort_array_by_id($r['result'], $t['result']['items_order']);
			}
		}
		return $top;
	}
	

	/**
	 * return array like
	 * 		home_top => list of stories (sorted)
	 * 		home_right => list of stories (sorted)
	 * @param unknown_type $listSlugArr
	 * @return Ambigous <sortedArrayOfRows, multitype:unknown >
	 */
	public function getByLists($listSlugArr)
	{
		$ret = array();
		foreach ($listSlugArr as $slug)
		{
			$ret[$slug] = array();
		}
		//TODO: maybe prefix with users if we go SAAS
		$where = array('slug' => array('$in' => $listSlugArr));
		$t = Dao_Node_List::getInstance()->findAll(array('where' => $where));
		if ($t['success'])
		{
			$allStoryIds = array();
			$lists = $t['result'];
			foreach($lists as $i => $list)
			{
				//Limit
				if (isset($list['lim']) && count($list['items_order']) > $list['lim'])
				{
					$list['items_order'] = array_slice($list['items_order'], 0, $list['lim']);
					$lists[$i] = $list;
				}
				if(isset($list['items_order']) && count($list['items_order']) > 1)
    				foreach ($list['items_order'] as $storyId)
    					$allStoryIds[] = $storyId;
			}			
			
			$where = array('id' => array('$in' => $allStoryIds));
			$r = $this->findAll(array('where' => $where));
			if ($r['success'])
			{
				$allStories = $r['result'];
				foreach ($allStories as $j => $story)
				{
					$allStories[$j] = $this->reformatStory($story, 'category');
				}
			}
			
			foreach ($lists as $list)
			{
				$slug = $list['slug'];
				if(!isset($list['items_order']))
				    $list['items_order'] = array('');
				$listItemIds = $list['items_order'];
				foreach ($allStories as $story)
				{
					if (in_array($story['id'], $listItemIds))
						$ret[$slug][] = $story;
				}
				
				$ret[$slug] = sort_array_by_id($ret[$slug], $list['items_order']);
			}
		}
		return $ret;
	}
	

	public function getAvailableLists()
	{
		$ret = array();
		$where = array('items_type' => 'story');
		$t = Dao_Node_List::getInstance()->findAll(array('where' => $where));
		//v($t);
		if ($t['success'])
		{
			foreach ($t['result'] as $list)
			{
				$ret[$list['slug']] = $list['name'];				
			}
		}
		return $ret;
	}
	
	public function getFakeStoryLists( $listSlugArr)
	{
		$ret = array();
		foreach ($listSlugArr as $slug)
		{
			$where = array('slug' => $slug);
			$t = Dao_Node_List::getInstance()->findOne($where);
			if ($t['success'])
			{
				$list = $t['result'];
				
				$fakeStory = array(
					'name' => " template story",
					'link' => "/list/update?id={$list['id']}&_cl_step=list_items_order",
					'avatar' => default_avatar('story') 		
				);
				if (isset($list['lim']))
					$fakeStory['name'] = $list['lim'] . ' x ' . $fakeStory['name'];
				
				$ret[$slug] = array($fakeStory);
			}
			else 
			{
				$createList = array(
			        'chapo' => 'demo chapo',
				    'ts' => 1,    
					'name' => "$slug not exist. Click to create",
					'link' => "/list/new?items_type=story&name={$slug}&slug={$slug}"		
				);
				$ret[$slug] = array($createList);
			}
		}
		//v($ret);
		return $ret;
		
	}
	
	
	public function getStoryList($category){
	    $limit = 10;
	    if($category != ''){
	       $where = array('category' => $category);
	       $cond['where'] = $where;
	       $cond['limit'] = $limit;
    	   $r = $this->find($cond);
    	   if($r['success'] && $r['count'] >0)
	          return $r;
	     }
        return(array('success' => false, 'result' => ''));
	}	
	
	public function getStoryByTagList($tags){
	    $limit = 10;
	    f($tags);
	    if($category != ''){
	        $where = array('name' => $category);
	        $cond['where'] = $where;
	        $cond['limit'] = $limit;
	    	   $r = $this->find($cond);
	    	   if($r['success'] && $r['count'] >0)
	    	       return $r;
	    }
	    return(array('success' => false, 'result' => ''));
	}   
	
	
}
