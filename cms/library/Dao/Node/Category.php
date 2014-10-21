<?php
class Dao_Node_Category extends Cl_Dao_Node_Category
{
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
		//v($top);
		return $top;
	}
	
	static function getCategoryTypes()
	{
		$default = array('story' => t('story'));
		return get_conf('category_types', $default);
	}
	
	/**
	 * 
	 * @param String $type : 'slug' or 'id'
	 * @param String $val
	 */
	public function getCategory($type, $val)
	{
		$cate = false;
		if (!Zend_Registry::isRegistered('category_tree'))
		{
			$categoryTree = Dao_Node_Category::getInstance()->getCategoryTree(array(), 
					'0', 1, '');
			Zend_Registry::set('category_tree', $categoryTree);
		}
		$categoryTree = Zend_Registry::get('category_tree');
		foreach($categoryTree as $cate)
		{
			if ($cate[$type] == $val)
			{
				return $cate;	
			}
		}
	}
	public function getCategoryBySlug($categorySlug = '')
	{
	        if($categorySlug == '')
	            $r = array('success' => false, 'result' => '');
	        else
	            $r = $this->findOne(array('slug' => $categorySlug));
	        return $r;
	}
}
