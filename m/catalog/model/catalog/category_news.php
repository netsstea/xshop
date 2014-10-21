<?php
class ModelCatalogCategoryNews extends Model {
	public function getCategory($category_news_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "category_news c LEFT JOIN " . DB_PREFIX . "category_news_description cd ON (c.category_news_id = cd.category_news_id) WHERE c.category_news_id = '" . (int)$category_news_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getCategories($parent_news_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_news c LEFT JOIN " . DB_PREFIX . "category_news_description cd ON (c.category_news_id = cd.category_news_id) WHERE c.parent_news_id = '" . (int)$parent_news_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order");

		return $query->rows;
	}
				
	public function getTotalCategoriesByCategoryId($parent_news_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category_news WHERE parent_news_id = '" . (int)$parent_news_id . "'");

		return $query->row['total'];
	}
	
}
?>