<?php
class Controller_Plugin extends  Cl_Controller_Plugin
{
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		Zend_Registry::set('theme', get_conf('theme:default_theme_name', 'default'));
		parent::preDispatch($request);	
	}
	
	public function dispatchLoopShutdown()
	{
		/*
		$page = Zend_Registry::get('page');
		//DO NOT CACHE FOR ADMIN
		if (!has_perm('admin_story'))
		{
			if (is_modal_ajax() && !is_rest())
			{
				$html = $this->getResponse()->getBody();
				$json = array('success' => true, 'result' => array('title' => Bootstrap::$pageTitle, 'content' => $html));
				//send_json(array('success' => true, 'result' => $json));
				if (	$page == 'story/index/view' 
						//|| $page == 'site/index/index'
						|| $page == 'story/index/list'
						|| $page == 'story/index/hot-tags'
				)
				{
					$file = get_cache_file_fullpath();
					$file = $file . '.json';
					$json = json_encode($json); // now is string
					Cl_Utility::getInstance()->saveFile($json, $file);
				}
			}
			else if (is_rest())
			{
				if (	$page == 'story/index/view'
						//|| $page == 'site/index/index'
						|| $page == 'story/index/list'
						|| $page == 'story/index/hot-tags'
				)
				{
					$file = get_cache_file_fullpath();
					$file = $file . '.rest';
					$json = Zend_Registry::get('rest_data');
					$json = json_encode($json); // now is string
					Cl_Utility::getInstance()->saveFile($json, $file);
				}
			}
			else if ($page == 'story/index/view' || $page == 'site/index/index')
			{
				$content = $this->getResponse()->getBody();
				$content = $content . "<span style='display:none;'>cached</span>";
				Cl_Utility::getInstance()->saveFile($content, get_cache_file_fullpath());
			}
		}		
		*/
		parent::dispatchLoopShutdown();
		//DO something with $content = $this->getResponse()->getBody(); if you like. For example cache it here
	}
}