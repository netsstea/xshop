<?php
    /**
     * Usage
     * Sample request
     *     /suggest.php?term=apple&node=concept to search for concept:apple => list of concepts matching apple
     *     term can also be replaced by 'q'
     *     THis is so that it will work with different jquery autocomplete plugins
     */

defined('PUBLIC_PATH')
|| define('PUBLIC_PATH', realpath(dirname(__FILE__)));

// Define path to application directory
defined('SAND_ROOT')
|| define('SAND_ROOT', realpath(dirname(__FILE__) . '/../../sand-core'));

require_once(SAND_ROOT . '/library/init.php');
require_once(SAND_ROOT . '/library/common.php');

$defines = get_config_file('defines');
require_once $defines;
    

    //ini_set('display_errors', 0);
    
    function autosuggest($terms, $term_prefix = RDB_DICT_PREFIX, $nodeType, $redis = null)
    {
        $time = time();
        if ($redis == null)
            $redis = init_redis(RDB_DICT_DB);
            
    	$prefixedTerms = array(); //query terms
    	//temporary key to store results
    	$output = 'output_' . session_id() . time(); //unique
    	foreach ($terms as $term)
    	{
    		$term = strtolower(trim($term));
    		if (!empty($term))
    			$prefixedTerms[] = $term_prefix . $term;
    	}
    	$count = count($prefixedTerms);
    	//weight is sum of all
    	$redis->zInter($output, $prefixedTerms); //inter-set all the zset which has key in $prefixedTerms and output to $output zSEt
    	
    	$pairs = false;//no pairs
    	if (count($terms) > 1)
    	    $pairs = terms_overlap($terms);
    
    	//if terms are overlaps. we need to resolve the pairs
    	//$pairs will be array of array("toshiba", "t");
    	if ($pairs)
    	{
    		foreach ($pairs as $val)
    		{
    			$arr = $redis->zRevRange($output, 0, -1, false); //gets weight as well
    			
    			$toshiba = $val[0];
    			$t = $val[1];
    			foreach ($arr as $item)
    			{
    				$itemArr = unserialize($item);
    				$strippedName = str_replace($toshiba, '', strtolower($itemArr['name']));
    				if (preg_match("/(\s$t|^$t)/i", $strippedName) === 0) //not match	
    				{
    					//this word contains 'toshiba' but no extra 't'
    					//pop this word out of $zSet 'output';	
    					$redis->zRem($output, $item);			
    				}
    			}
    		}
    	}			
    	$arr = $redis->zRevRange($output, 0, 10, true); //gets weight as well
    	
    	//now get extra information for each item from RDB_CACHE_DB
    	$ret = array();
    	$redis->select(RDB_CACHE_DB);
    	foreach ($arr as $itemId => $weight)
    	{
    	    $redisKeys[] =  $nodeType . ":" . $itemId;
    	}
    	
    	if (isset($redisKeys) && count($redisKeys) > 0)
    	{
        	$values = $redis->mGet($redisKeys); //get them all at once to avoid networking traffic to redis server
        	
        	$i = 0;
        	foreach ($arr as $itemId => $weight)
        	{
        		//$item = unserialize($item);
        		if ($values[$i] !== false)
        		{
                    $str = $values[$i];//$redis->get();
                    $r = unserialize($str);
                    if (isset($r['avatar']))
                        $avatar = display_avatar($r['avatar'], 50, AS3_ITEM_IMAGE_FOLDER);
                    else 
                        $avatar = default_avatar($nodeType);
                    
            		$ret[$itemId] = array(
            				//'name' => "$weight::" . $r['lname'],
            				'name' => $r['name'],
            				'avatar' => $avatar
        			);
            		if (isset($r['slug']))
            		{
            		    $ret[$itemId]['slug'] = $r['slug'];
            		}
        		}
        		$i ++;
                //$ret[$item['id']] = $item['name'] . "( weight: " . $weight . ")"; 
        	}
    	}
    	$redis->select(RDB_DICT_DB);
    	$redis->del($output);
    	return array('success' => true, 'result' => $ret, 'count' => count($ret));
    	
    }
    
    //====================================Start executing========================
    
    $redis = init_redis(RDB_DICT_DB);
    $term = get_value('term', '', 'string');
    if ($term == '')
        $term = get_value('q', '', 'string');
    if ($term == '')
    	$term = get_value('query', '', 'string');
    
    $type = get_value('prefix', '#','string'); //# for nodes, @ for users
    $node = get_value('node', '','string');
    if ($node == '' || $term == '')
    {
        $r = array('success' => false);
    }
    else 
    {
        $pregReplace = array('/(\s\s+)/', '/-/');
        $arr = explode(' ', preg_replace($pregReplace,' ',$term));
        if ($type == '#') //search for nodes
        {
        	if (defined('FAKE_REDIS'))
        	{
        		//init and search from MongoDB
        		// Ensure library/ is on include_path
        		set_include_path(implode(PATH_SEPARATOR, array(
        		realpath(APPLICATION_PATH . '/../library'),
        		get_include_path(),
        		)));
        		
        		require_once 'Zend/Loader/Autoloader.php';
        		//Zend_Loader::registerAutoload();
        		//Zend_Loader::autoload()
        		//Zend_Loader::
        		$autoloader = Zend_Loader_Autoloader::getInstance();
        		$autoloader->registerNamespace('Cl_');
        		$autoloader->registerNamespace('Dao_');
        		init_mongo();
        		//$where = array('ac' => array('$like' => ))
        		$where = array('ac' => new MongoRegex("/" . $term . "/i"));
        		$cond['where'] = $where;
        		$cond['limit'] = 10;
        		$r = Dao_Node_Tag::getInstance()->find($cond);
        		///return array('success' => true, 'result' => $ret, 'count' => count($ret));
        		
        	}
        	else //get data from real redis 
	            $r = autosuggest($arr,RDB_DICT_PREFIX, $node, $redis);
        }
        else 
        {
        	/*
            //get userid
            
            // Ensure library/ is on include_path
            set_include_path(implode(PATH_SEPARATOR, array(
                realpath(APPLICATION_PATH . '/../library'),
                get_include_path(),
            )));
            
            require_once 'Zend/Loader/Autoloader.php';
            //Zend_Loader::registerAutoload();
            //Zend_Loader::autoload()
            //Zend_Loader::
            $autoloader = Zend_Loader_Autoloader::getInstance();
            $autoloader->registerNamespace('Cl_');
            //assure_login();
            
        	$auth = Zend_Auth::getInstance();
            $u = $auth->getIdentity();    
        	    
            if (!isset($u['id']) || empty($u['id']) || $u['id'] == GUEST_ID)
            {
                $r = array('success' => false, 'err' => 'login first');
            }
            else 
            {
        	    init_mongo();
        		$r = Cl_Dao_Util::getUserDao()->suggestFollowers($u['id'], $arr);  
                //$r = autosuggest($arr,DICT_RDB_USER_PREFIX . $u['id'] . ":", $redis);
            }
            */
        }
    }
    
    
    
    if ($r['success'])
    {
    	$final = $r['result'];
    
        $f = array();
        if (count($final) > 0){
        	foreach ($final as $key=>$value) {
        		$id = isset($value['id']) ? $value['id'] : $key;
        	    $el = array(
        	        "id" => $id,
        	        "name" => $value['name'],
    	            'type' => 'story',
        			//'avatar' => $value['avatar']
                );
        	    if (isset($value['slug']))
        	        $el['slug'] = $value['slug'];
        		array_push($f, $el);
        	}
        }
        else //nothing found
        {
            if (get_value('addnew', '', 'string') !== '') //allow to dynamically add new
            {
                $el = array(
                    'id' => (string) new MongoId(),
                    'name' => $term,
                    'type' => 'story',
                    '_new' => true
                        
                );
                array_push($f, $el);
            }
        }
    }
    else 
        $f = $r;
    //header('Content-type: application/json');
    echo json_encode($f);
    exit();
