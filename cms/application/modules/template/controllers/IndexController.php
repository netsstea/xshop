<?php
/**
 * Remember you have    
 *  public $dao;
 *  public $node, $nodeUC; //node name : foo|post|item...

 * @author tran
 */ 
class Template_IndexController extends Cl_Controller_Action_NodeIndex 
{
    public function init()
    {
        //$this->daoClass = "Cl_Dao_Node_Template";
        //$this->commentDaoClass = "Cl_Dao_Comment_Template";
        
        /**
         * Chances to check for permission here if you like
         */
        parent::init();
        /**
         * Chances to change layout if you like
         */
        $this->setLayout("admin");
    }

    public function indexAction()
    {

    }

    public function newAction()
    {
        assure_perm('template_new');
        $this->genericNew("Template_Form_New", "Dao_Node_Template", "Node");
        
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
                	$this->ajaxData['data'] = array('url' => '/template/search');
                }
            }
        }
        Bootstrap::$pageTitle = t("new_template",1);
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
        $this->genericUpdate("Template_Form_Update", $this->daoClass ,"", "Node");
        Bootstrap::$pageTitle = t("update_template",1);
    }

    public function searchAction()
    {
        assure_perm("search_template");//by default
        $this->setLayout("admin");
        $this->genericSearch("Template_Form_Search", $this->daoClass, "Node");
        $this->setLayout("admin");
        Bootstrap::$pageTitle = t("search_news",1);        
    }
    
    public function searchCommentAction()
    {
        assure_perm("search_template");//by default
        $commentClass =$this->commentDaoClass;
        $this->genericSearch("Template_Form_SearchComment", $commentClass, "");
        $this->setLayout("admin");
        Bootstrap::$pageTitle = t("search_news_comments",1);        
    }
    
    public function viewAction()
    {
        //sleep(1);
        //TODO Your permission here
        parent::viewAction();//no permission yet
        if ($row = $this->getViewParam('row'))
        {
        	//$row = Dao_Node_Template::getInstance()->reformatTemplate($row, 'view');
            
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
        if (has_perm("delete_template"))
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
    	return has_perm("new_template_comment");
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
        assure_role('admin_template');
    	$ids = $this->getStrippedParam('ids');
    	$in = explode(',', $ids);
    	$where = array('id' => array('$in' => $in));
    	Dao_Node_Template::getInstance()->delete($where);
    	Dao_Node_Template::getInstance()->clearAllStaticCache();
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
        
        $this->genericSearch('Template_Form_Search', "Dao_Node_Template", 'Node');
        if (is_ajax())
        {
        	if (isset($this->ajaxData['result']))
        	{
        		$list = $this->ajaxData['result'];
        
        		foreach ($list as $i => $row)
        		{
        			//$row = Dao_Node_Template::getInstance()->reformatTemplate($row);
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
            echo $this->renderScript('widget/template-list.phtml');
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
   
}

