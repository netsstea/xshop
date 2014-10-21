<?php
/**
 * Remember you have    
 *  public $dao;
 *  public $node, $nodeUC; //node name : foo|post|item...

 * @author tran
 */ 
class Story_IndexController extends Cl_Controller_Action_NodeIndex 
{
	private $theme;
    public function init()
    {
        //$this->daoClass = "Cl_Dao_Node_Story";
        //$this->commentDaoClass = "Cl_Dao_Comment_Story";
        
        /**
         * Chances to check for permission here if you like
         */
        parent::init();
        $this->theme = Zend_Registry::get('theme');
        $this->dao = Dao_Node_Story::getInstance();
        /**
         * Chances to change layout if you like
         */
    }

    public function indexAction()
    {
    	$site = getenv('SITE');
		if (!$site)
    		$site = 'news';
    
    	Bootstrap::$pageTitle = 'Daily English Articles';
		
    	$subcategorySlug = $this->getStrippedParam('subcategory', '');
    	$categorySlug = $this->getStrippedParam('category', '');
    	$categorySlugs = array();
    	$categoryTreeLine = array();
    	if ($categorySlug != '')
    	{
    		$categorySlugs[] = $categorySlug;
    		
    		$category = Dao_Node_Category::getInstance()->getCategory('slug', $categorySlug);
    		$categoryTreeLine[] = $category;
    		
    		$tree = Dao_Node_Category::getInstance()->getCategoryTree(array(), $category['id']);
    		$this->setViewParam('subcategoryTree', $tree);
    	}
    	if ($subcategorySlug != '')
    	{
    		$categorySlugs[] = $subcategorySlug;
    		Zend_Registry::set('subcategory', $subcategorySlug);
    		$subcategory =  Dao_Node_Category::getInstance()->getCategory('slug', $subcategorySlug);
    		$categoryTreeLine[] = $subcategory;
    	}

    	Zend_Registry::set('categoryTreeLine', $categoryTreeLine);
    	
    	Zend_Registry::set('categorySlugs', $categorySlugs);
    	
    	$lists = Dao_Node_Template::getInstance()->getListsByPage('home', $this->theme);
    	if (count($lists) == 0)
    		die("Page home theme ". $this->theme . " has no lists");
    		
    	/*
    	//Latest news
    	$r = $this->dao->find(array('order' => array('ts' => -1), 'limit' => 10));
    	if ($r['success'])
    		$lists['latest'] = $r['result'];
    	*/
    	
    	$storyList = $this->dao->getByLists($lists);
		$this->setViewParam('list', $storyList );
		$this->setNoRenderer();
      	echo $this->renderScript("index/{$this->theme}/home.phtml");
    }
    
    /*
    public function indexAction()
    {
    	$site = getenv('SITE');
    	if (!$site)
    		$site = 'news';
    	 
    	Bootstrap::$pageTitle = 'Daily English Articles';
    
    	$this->_request->setParam('status', array(1));
    	$this->_request->setParam('items_per_page', 10);
    	$this->genericSearch('Story_Form_Search', "Dao_Node_Story", 'Node');
    	$list = $this->getViewParam('list');
    	foreach ($list as $i => $val)
    	{
    		$val['url'] = node_link('story', $val);
    		$val['category_name'] = Dao_Node_Category::getInstance()->getCateNameFromSlug($val['category']);
    		if (isset($val['source']) && $val['source'] != '')
    			$val['sourceInfo'] = Dao_Node_Source::getInstance()->getNodeFromRedis($val['source']);
    		$list[$i] = $val;
    	}
    	
    	$this->setViewParam('list', $list);
    	$this->setNoRenderer();
    	echo $this->renderScript("index/{$site}/home.phtml");
    }
	*/
    
    public function newAction()
    {
    	$this->setLayout("admin");
        assure_perm('story_new');
        $this->genericNew("Story_Form_New", "Dao_Node_Story", "Node");
        
        if(isset($this->ajaxData)) {
            //command the form view to rediect if success
            if (isset($this->ajaxData['result'])) //success
            {
                if (is_preview())
                {
                    $this->setViewParam('row', $this->ajaxData['result']);
                    $this->setViewParam('is_preview', 1);
                    $this->_helper->viewRenderer->setNoRender(true);
                    $ret['data'] = $this->view->render('index/view.phtml');
                    $ret['success'] = true;
                    $ret['callback'] = 'populate_preview';
                    send_json($ret);
                    exit();
                }
                else 
                {
                	//TODO: if there's a list, then we redirect to manage the list...
                	$this->ajaxData['callback'] = 'redirect';
                	
                	$this->ajaxData['data'] = array('url' => 
                			"/story/update?id={$this->ajaxData['result']['id']}&_cl_step=avatar&_from=new");
                	//$this->ajaxData['data'] = array('url' => node_link('story' , $this->ajaxData['result']));
                }
            }
        }
        Bootstrap::$pageTitle = t("new_story",1);
    }

    public function updateAction()
    {
        /**
         * Permission to update a node is done in 
         * $Node_Form_Update form->customPermissionFilter()
         * Do not do it here
         * @NOTE: object is already filtered in Index.php, done in Cl_Dao_Node::filterUpdatedObjectForAjax()
         */
    	$this->setLayout("admin");
        $this->genericUpdate("Story_Form_Update", $this->daoClass ,"", "Node");
        Bootstrap::$pageTitle = t("update_story",1);
    }

    public function searchAction()
    {
        assure_perm("search_story");//by default
        $this->setLayout("admin");
        $this->genericSearch("Story_Form_Search", $this->daoClass, "Node");
        if ($this->getViewParam('count') > 0 || $this->ajaxData['count'] > 0)
        {
        	if (is_ajax())
        		$list = $this->ajaxData['result'];
        	else 
		        $list = $this->getViewParam('list');
			foreach ($list as $i => $item)
			{
				$item['link'] = node_link('story', $item);
				$list[$i] = $item;
			}
			if (is_ajax())
			{
				$this->ajaxData['result'] = $list;
			}
			else 
				$this->setViewParam('list', $list);
				        
        }
        $this->setLayout("admin");
        Bootstrap::$pageTitle = t("search_news",1);        
    }
    
    public function searchCommentAction()
    {
        assure_perm("search_story");//by default
        $commentClass =$this->commentDaoClass;
        $this->genericSearch("Story_Form_SearchComment", $commentClass, "");
        $this->setLayout("admin");
        Bootstrap::$pageTitle = t("search_news_comments",1);        
    }
    
    public function viewAction()
    {
        $where = array('iid' => $this->getStrippedParam('iid'));
        $r = $this->dao->findOne($where);
        if ($r['success'])
            $row = $r['result'];
        else 
            die("Not exists");
    	$row = $this->dao->reformatStory($row, 'view');
    	Zend_Registry::set('categorySlugs', $row['categorySlugs']);
    	if (count($row['categorySlugs']) > 0)
    	{
    		$categoryTree = $row['category_tree'];
    		Zend_Registry::set('categoryTreeLine', $categoryTree);
    		
    		$topCategory = $categoryTree[0];
    		$categorySlug = $topCategory['slug'];
    		
    		$category = Dao_Node_Category::getInstance()->getCategory('slug', $categorySlug);
    		$tree = Dao_Node_Category::getInstance()->getCategoryTree(array(), $category['id']);
    		$this->setViewParam('subcategoryTree', $tree);
    		if (count($categoryTree) > 1 && $row['category'] != $topCategory['id'])
    		{
    			Zend_Registry::set('subcategory', $categoryTree[1]['slug']);
    		}
    	}
    	
    	
        $row['related'] = array();
        if (isset($row['tags']) && count($row['tags']) > 0)
        {
            foreach ($row['tags'] as $t)
            {
            	if (isset($t['slug']))
            		$tagSlugs[] = $t['slug'];
            }
            $where = array('tags.slug' => array('$in' => $tagSlugs));
            $cond = array('where' => $where, 'limit' => 10, 'order' => array('ots' => -1));
            $r = $this->dao->find($cond);
            if ($r['success'] && $r['count'] > 0)
            {
                foreach ($r['result'] as $st)
                {
                	$related =  array('id' => $st['id'],
                            'name' => $st['name'],
                            'ots' => $st['ots']
                            );
                	if (isset($st['iid']))
                		$related['iid'] = $st['iid'];
                	if (isset($st['slug']))
                		$related['slug'] = $st['slug'];
                	 
                    $row['related'][] = $related;
                }
            }
        }
                    
        if(is_rest()) {
        	 
    		$ret = array('success' => true, 'result' => $row);
    		//$ret = array('success' => true, 'result' => $list);
    		$file = get_cache_file_fullpath();
    		$file = $file . '.rjson';
    		 
    		$jsonString = json_encode($ret); // now is string
    		Cl_Utility::getInstance()->saveFile($jsonString, $file);
    		 
    		send_json($ret);
        	die();
        }
        else
        {
            $this->setViewParam('row', $row);
        }
        $id = $this->getStrippedParam('id');
        $where = array('node.id' => $id);
        $commentClass =$this->commentDaoClass;
        $r = $commentClass::getInstance()->findAll(array('where' => $where));
        if ($r['success'] && $r['count'] > 0)
        {
            $comments = $this->dao->generateCommentTree($r['result'], 0);
            //Construct comment trees here
            $this->setViewParam('comments', $comments);
        }
        Bootstrap::$pageTitle = $row['name'];
        $this->setNoRenderer();
        $this->renderScript("index/{$this->theme}/view.phtml");
        
    }

    public function getDataForCategory()
    {
        $categorySlug = $this->getStrippedParam('category') ? $this->getStrippedParam('category') : '';
        $template = $this->getStrippedParam('template', 'category');
        $r = Dao_Node_Category::getInstance()->getCategoryBySlug($categorySlug);
        $where = array('prefich' => $categorySlug);
        if($r['success'] && $r['count'] >0){
            $lists = Dao_Node_Template::getInstance()->getListsByPage($template, $this->theme);
             
            foreach ($lists as $i => $l)
            {
                $lists[$i] = "$categorySlug:$l";
            }
             
            $storyList = Dao_Node_Story::getInstance()->getByLists($lists);
            foreach ($storyList as $fullSlug => $list)
            {
                unset($storyList[$fullSlug]);
                //remove prefich
                $shortSlug = str_replace("$categorySlug:", '', $fullSlug);
                $storyList[$shortSlug] = $list;
            }
            $this->setViewParam('list', $storyList );
            $this->setViewParam('category',$r['result']);
            $this->setViewParam('row', $r['result']);
        }
        return $r;
    }
    
    public function categoryAction()
    {
        $r = $this->getDataForCategory();
    	if ($r['success'])
    	{
    	    $this->setNoRenderer();
            $this->renderScript("index/{$this->theme}/category.phtml");
    	}
    	else
    	{
    	    $this->renderScript("index/{$this->theme}/404.phtml");
    	}
        Bootstrap::$pageTitle = $r['result']['name'].'-'.SITE_DESC;
    }
    
    
    public function deleteNodePermissionCheck($row)
    {
        if (has_perm("delete_story"))
            return array('success' => true);
        else 
            return array('success' => false);
    }
    public function commentAction(){
    	//$this->commentScript = "index/one-comment.phtml";
    	parent::commentAction();
    }
    
    //implements parent::newCommentPermissionCheck
    public function newCommentPermissionCheck($row)
    {
    	//TODO: Implement this
    	return has_perm("new_story_comment");
    }
    public function updateCommentAction()
    {
    	//$this->commentContentScript = "index/one-comment-content.phtml";
    	parent::updateCommentAction();
    }
    
    public function delCommentAction()
    {
    	parent::delCommentAction();
    }
    
    public function bulkDeleteAction()
    {
        assure_role('admin_story');
    	$ids = $this->getStrippedParam('ids');
    	$in = explode(',', $ids);
    	$where = array('id' => array('$in' => $in));
    	$this->dao->delete($where);
    	$this->dao->clearAllStaticCache();
    	$r = array('success' => true);
    	$this->handleAjaxOrMaster($r);
    }
    
    public function genMobileNavAction()
    {
        $r = Dao_Node_Category::getInstance()->getCategoryTree();
        $this->setViewParam('tree', $r);
        $this->setNoRenderer();
        $t = $this->view->render('index/gen-mobile-nav.phtml');
        
        if (getenv('SITE'))
            $file = PUBLIC_PATH . '/mobile/' . getenv('SITE') . 'nav.html';
        else
            $file = PUBLIC_PATH . '/mobile/nav.html';
        Cl_Utility::getInstance()->saveFile($t, $file);
        echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8' /></head><body>OK, following nav bar has been saved to <strong>{$file}</strong>";
        echo "<br/><hr/><br/><textarea cols='120' rows='30'>$t<textarea></body></html>"; 
        die();
    }
    
    public function listAction()
    {
        //sleep(1);
        Bootstrap::$pageTitle = t("news",1);
        $this->_request->setParam('status', array(1));
        
        if (!$this->getStrippedParam('items_per_page'))
            $this->_request->setParam('items_per_page', 10);
        
        $this->_request->setParam('order_ots', -1);
        
        $category = $this->getStrippedParam('category', '');
        
        if ($category != '')
        {
            $isCategory = false;
            $listOfCategories = Dao_Node_Category::getInstance()->getCategoryTree();
            foreach ($listOfCategories as $cate)
            {
                if ($category == $cate['slug'])
                {
                    $isCategory = true;
                    break;
                }
            }
            if (!$isCategory) //this must be a tag
            {
                $this->_request->setParam('category', '');
                $this->_request->setParam('tags__slug', $category);
            }
        }
        //featured
        /*
        if ($category == '' || $category == 'hot')
            $this->_request->setParam('f', 1);
        if ($category == 'hot')
        {
            $this->_request->setParam('category', '');
        }
        */

        /*
        if (is_thuky())
        {
        	$this->_request->setParam('category', '');
        }
        */
        
        $this->genericSearch('Story_Form_Search', "Dao_Node_Story", 'Node');
        if (is_ajax())
        {
        	if (isset($this->ajaxData['result']))
        	{
        		$list = $this->ajaxData['result'];
        
        		foreach ($list as $i => $row)
        		{
        			$row = $this->dao->reformatStory($row);
        			$list[$i] = $row;
        		}
        	}
        	else 
        		$list = array();
        	$this->setNoRenderer();
        	
        	$ret = array('success' => true, 'result' => $list);
        	if (is_rest())
        	{
	        	$file = get_cache_file_fullpath();
	        	$file = $file . '.rjson';
	        	$jsonString = json_encode($ret); // now is string
	        	Cl_Utility::getInstance()->saveFile($jsonString, $file);
        	}
        	        	
        	send_json($ret);
        }
        else 
        {
            $this->setNoRenderer();
            echo $this->renderScript('widget/story-list.phtml');
        }
    }
    
    public function hotTagsAction()
    {
        $this->_request->setParam('f', 1);
        $this->genericSearch('Tag_Form_Search', 'Dao_Node_Tag', 'Node');
        if (is_ajax())
        {
        	if (isset($this->ajaxData['result']))
        	{
        		$list = $this->ajaxData['result'];
        	}
            	else $list = array();
        	send_json(array('success' => true, 'result' => $list));
        }
    }
    
    public function tagAction()
    {
        $this->_request->setParam('tags.slug', $this->getStrippedParam('slug'));
        //$this->_request->setParam('f', -1);
        $this->genericSearch('Story_Form_Search', 'Dao_Node_Story', 'Node');
        if(!isset($this->ajaxData['result'])){
            $this->setNoRenderer();
            $this->renderScript("index/{$this->theme}/404.phtml");
        }
        elseif (isset($this->ajaxData['result']))
        {
            $storyList = $this->ajaxData['result'];
            $this->setViewParam('row', $storyList );
            $this->setNoRenderer();
            $this->renderScript("index/{$this->theme}/tag.phtml");
            //Dao_Node_Story::getInstance()->getStoryByTagList($list);
        }
        Bootstrap::$pageTitle = "Tag search";
    }
    
    public function domainAction()
    {
        $r = array('success' => true, 'result' => API_URL);
        send_json($r);
    }
    
    public function refreshAutosuggestAction()
    {
    	$redis = init_redis(RDB_DICT_DB);
    	$redis->flushDB();
    	
    	
    	$redis->select(RDB_CACHE_DB);
    	$keys = $redis->keys("d:*");
    	foreach($keys as $k)
    	{
    		$redis->del($k);
    	}
    	$t = Dao_Node_Tag::getInstance()->findAll();
    	if ($t['success'])
    	{
    		foreach ($t['result'] as $row)
    		{
//    			v($tag);
    			Dao_Node_Tag::getInstance()->addNodeToRedisSuggestion($row['id'], RDB_DICT_PREFIX, true);
    			Dao_Node_Tag::getInstance()->cacheNodeToRedis($row);    			
    		}
    	}
    	die('OK'); 
    }
   
    public function deleteOldStoriesAction()
    {
    	//TODO
    	Bootstrap::$pageTitle = "Delete old stories. TODO";
    }
    
    public function adminAction()
    {
    	//assure_perm('sudo');
    	$this->setLayout("admin");
    	Bootstrap::$pageTitle = "Dashboard";
    	 
    }
    
    public function multiupdateAction()
    {

        assure_perm('sudo');
        $r = $this->getDataForCategory();
        Bootstrap::$pageTitle = t("update_list_for_page" ,1);
    }
}

