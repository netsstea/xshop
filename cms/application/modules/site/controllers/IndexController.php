<?php
class Site_IndexController extends Cl_Controller_Action_Index
{
    public function indexAction()
    {
    }
    
    public function categoryAction()
    {
    	$site = getenv('SITE');
    	    
    	$this->_request->setParam('status', array(1));
    	$this->_request->setParam('items_per_page', 10);
    	Zend_Registry::set('category', $this->getStrippedParam('category'));
    	$cateName = Dao_Node_Category::getInstance()->getCateNameFromSlug(Zend_Registry::get('category'));
    	Bootstrap::$pageTitle = $cateName;
    	
    	$this->genericSearch('Story_Form_Search', "Dao_Node_Story", 'Node');
    	$list = $this->getViewParam('list');
    	foreach ($list as $i => $val)
    	{
    		$val['url'] = node_link('story', $val);
    		$val['category_name'] = $cateName;
    		$val['sourceInfo'] = Dao_Node_Source::getInstance()->getNodeFromRedis($val['source']);
    		$list[$i] = $val;
    	}
    	$this->setViewParam('list', $list);
    	$this->setNoRenderer();
    	$site = getenv('SITE');
    	if ($site != '')
    	echo $this->renderScript($site . '/story-list.phtml');
    }
    
	public function errorAction()
	{
		
	}
    //==========================ADMIN==================================
    public function installAction()
    {
    	assure_perm('sudo');
    	$this->setLayout("admin");
    	if ($this->isSubmitted())
    	{
    		Cl_Dao_Util::getUserDao()->installSite();
    	}
    }
    
    public function adminAction()
    {
        assure_perm('sudo');
        //$this->setLayout("admin");
        Bootstrap::$pageTitle = "Dashboard";
    }
    
    public function apiAction()
    {
    	Bootstrap::$pageTitle = "API Documentation";
    }
}
