<?php
class ModelCatalogphanloai extends Model {
	public function getphanloai($phanloai_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "phanloai p LEFT JOIN " . DB_PREFIX . "phanloai_info pi ON (p.phanloai_id = pi.phanloai_id) WHERE p.phanloai_id = '" . (int)$phanloai_id . "' AND pi.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getPhanloais($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "phanloai p LEFT JOIN " . DB_PREFIX . "phanloai_info pi ON (p.phanloai_id = pi.phanloai_id) WHERE p.parent_id = '" . (int)$parent_id . "' AND pi.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY p.sort_order");

		return $query->rows;
	}
	
	public function getPhanloaisByCategoryId($parent_id = 0, $category_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "phanloai p LEFT JOIN " . DB_PREFIX . "phanloai_info pi ON (p.phanloai_id = pi.phanloai_id) LEFT JOIN " . DB_PREFIX . "phanloai_to_category p2c ON (p.phanloai_id = p2c.phanloai_id) WHERE p.parent_id = '" . (int)$parent_id . "' AND p2c.category_id = '" . (int)$category_id . "' AND pi.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY p.sort_order");

		return $query->rows;
	}
				
	public function getTotalPhanloaisByphanloaiId($parent_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "phanloai WHERE parent_id = '" . (int)$parent_id . "'");
		
		return $query->row['total'];
	}
}
?>