<?php
/**
 * Remember you have    
 *  public $dao;
 *  public $node, $nodeUC; //node name : foo|post|item...

 * @author tran
 */ 
class List_IndexController extends Cl_Controller_Action_NodeIndex 
{
    public function init()
    {
        //$this->daoClass = "Cl_Dao_Node_List";
        //$this->commentDaoClass = "Cl_Dao_Comment_List";
        
        /**
         * Chances to check for permission here if you like
         */
        parent::init();
        $this->theme = Zend_Registry::get('theme');
        
        /**
         * Chances to change layout if you like
         */
    }

    public function indexAction()
    {

    }

    public function newAction()
    {
    	$this->setLayout("admin");
        assure_perm('list_new');
        $this->genericNew("List_Form_New", "Dao_Node_List", "Node");
        
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
                	$this->ajaxData['callback'] = 'redirect';
                	$this->ajaxData['data'] = array('url' => "/list/update?_cl_step=items_order&id=". $this->ajaxData['result']['id']);
                }
            }
        }
        Bootstrap::$pageTitle = t("new_list",1);
    }

    public function updateAction()
    {
        //die();
        /**
         * Permission to update a node is done in 
         * $Node_Form_Update form->customPermissionFilter()
         * Do not do it here
         * @NOTE: object is already filtered in Index.php, done in Cl_Dao_Node::filterUpdatedObjectForAjax()
         */
    	$this->setLayout("admin");
        $this->genericUpdate("List_Form_Update", "Dao_Node_List" ,"", "Node");
        Bootstrap::$pageTitle = t("update_list",1);
    }
    

    public function searchAction()
    {
        assure_perm("search_list");//by default
        $this->setLayout("admin");
        $this->genericSearch("List_Form_Search", "Dao_Node_List", "Node");
        $this->setLayout("admin");
        Bootstrap::$pageTitle = t("search_gui_widgets_lists",1);        
    }
    
    public function searchCommentAction()
    {
        assure_perm("search_list");//by default
        $commentClass =$this->commentDaoClass;
        $this->genericSearch("List_Form_SearchComment", $commentClass, "");
        $this->setLayout("admin");
        Bootstrap::$pageTitle = t("search_news_comments",1);        
    }

    
    public function viewAction()
    {
        //TODO Your permission here
        parent::viewAction();//no permission yet
        if ($row = $this->getViewParam('row'))
        {
        	//$row = Dao_Node_List::getInstance()->reformatStory($row, 'view');
        	
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
                $r = Dao_Node_List::getInstance()->find($cond);
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
           
            Bootstrap::$pageTitle = $row['name'];
        }        
        else 
        Bootstrap::$pageTitle = t("view_news",1);
    }
    
    public function deleteNodePermissionCheck($row)
    {
        if (has_perm("delete_list"))
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
    	return has_perm("new_list_comment");
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
        assure_role('admin_list');
    	$ids = $this->getStrippedParam('ids');
    	$in = explode(',', $ids);
    	$where = array('id' => array('$in' => $in));
    	Dao_Node_List::getInstance()->delete($where);
    	Dao_Node_List::getInstance()->clearAllStaticCache();
    	$r = array('success' => true);
    	$this->handleAjaxOrMaster($r);
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
        
        $this->genericSearch('List_Form_Search', "Dao_Node_List", 'Node');
        if (is_ajax())
        {
        	if (isset($this->ajaxData['result']))
        	{
        		$list = $this->ajaxData['result'];
        
        		foreach ($list as $i => $row)
        		{
        			//$row = Dao_Node_List::getInstance()->reformatStory($row);
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
    
    public function testAction()
    {
        $url = "http://vnexpress.net/tin-tuc/the-gioi/my-do-mot-phan-lenh-cam-vu-khi-sat-thuong-voi-viet-nam-3088167.html";
        $r = fb_counter($url);
        calculate_point_of_story($r);
        die();
    }
    
    public function dragAction()
    {
        //http://news.local/list/multiupdate?prefich[]=xa-hoi
        /**
         * Permission to update a node is done in
         * $Node_Form_Update form->customPermissionFilter()
         * Do not do it here
         * @NOTE: object is already filtered in Index.php, done in Cl_Dao_Node::filterUpdatedObjectForAjax()
         */
        $this->setLayout("admin");
        $this->genericSearch("List_Form_Search", "Dao_Node_List","" ,"Node");
        if (isset($this->ajaxData['result'])) //success
        {
            $this->setViewParam('row', $this->ajaxData['result']);
        }
        Bootstrap::$pageTitle = t("update_list",1);
    }
   
}

 