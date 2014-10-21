<?php
class ModelCatalogCategory extends Model {
	public function getCategory($category_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getCategoriesToCshow($cshow) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.cshow = '" . $cshow . "' ORDER BY c.sort_order");

		return $query->rows;
	}
	
	public function getManufacturerByCategoryId($category_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (m.manufacturer_id = md.manufacturer_id) LEFT JOIN " . DB_PREFIX . "category_to_manufacturer m2c ON (m.manufacturer_id = m2c.manufacturer_id) WHERE m2c.category_id = '" . (int)$category_id . "' ORDER BY m2c.sort_order");

		return $query->rows;
	}
	
	public function getCategoriesManufacturers($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.cshow LIKE '%menu=1%' ORDER BY c.sort_order");

		return $query->rows;
	}
	
	public function getManufacturerIdAndCategoryId($category_id = 0, $manufacturer_id = 0) {
		$query = $this->db->query("SELECT *, c2m.ex_name AS name FROM " . DB_PREFIX . "category_to_manufacturer c2m WHERE c2m.category_id = '" . (int)$category_id . "' AND c2m.manufacturer_id = '" . (int)$manufacturer_id . "'");

		return $query->row;
	}
	
	public function getCategoriesByManufacturerId($manufacturer_id = 0) {
		$query = $this->db->query("SELECT *, cd.name AS name FROM " . DB_PREFIX . "category_to_manufacturer c2m LEFT JOIN " . DB_PREFIX . "manufacturer m ON (c2m.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (c2m.manufacturer_id = md.manufacturer_id) LEFT JOIN " . DB_PREFIX . "category_description cd ON (cd.category_id = c2m.category_id) LEFT JOIN " . DB_PREFIX . "category c ON (cd.category_id = c.category_id) WHERE c2m.manufacturer_id = '" . (int)$manufacturer_id . "' AND c.parent_id ='0' ORDER BY c.sort_order");

		return $query->rows;
	}
	
	public function getCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order");

		return $query->rows;
	}
	
	public function getCategoriesMenu($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.cshow NOT LIKE '%menu=1%' ORDER BY c.sort_order");

		return $query->rows;
	}
	
	public function getTotalCategoriesByCategoryId($parent_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category WHERE parent_id = '" . (int)$parent_id . "'");
		
		return $query->row['total'];
	}
	
	public function getTotalCategoryManufacturer($category_id, $manufacturer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category_to_manufacturer WHERE category_id = '" . (int)$category_id . "' AND manufacturer_id = '" . (int)$manufacturer_id . "'");
		
		return $query->row['total'];
	}
}
?>