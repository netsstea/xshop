<?php
class ModelCatalogCategory extends Model {
	public function getCategory($category_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getCategories_menu($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.menu = 1 ORDER BY c.sort_order");

		return $query->rows;
	}
	
	public function getCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.hienthi != 'column_right_product' ORDER BY c.sort_order");

		return $query->rows;
	}
	
	public function getCategories_cright() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.hienthi = 'column_right_product' ORDER BY c.sort_order");

		return $query->rows;
	}
	
	public function getTotalCategoriesByCategoryId($parent_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category WHERE parent_id = '" . (int)$parent_id . "'");
		
		return $query->row['total'];
	}
	
	public function getCategoryPhanloais($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "phanloai p LEFT JOIN " . DB_PREFIX . "phanloai_info pd ON (p.phanloai_id = pd.phanloai_id) LEFT JOIN " . DB_PREFIX . " category_to_phanloai c2p ON (p.phanloai_id = c2p.phanloai_id) WHERE c2p.category_id = '" . (int)$category_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id')  . "' ORDER BY p.sort_order");

		return $query->rows;
	}
}
?>