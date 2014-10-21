<?php
class Dao_Node_Tag extends Cl_Dao_Node_Tag
{
	/**
	 * Matching keywords categories
	 * @return multitype:
	 */
	public function getKeywordsCategories()
	{
		$where = array('type' => 'story');
		$r = Dao_Node_Category::getInstance()->getCategoryTree($where);
		
		$ret = array();
		foreach ($r as $i => $cate)
		{
			$ret[$cate['slug']] = $cate['tree_name'];
		}
		
		return $ret;
	}   
}