<?php
class ModelCatalogInformation extends Model {
	public function getInformation($information_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE i.information_id = '" . (int)$information_id . "' AND id.language_id = '" . (int)$this->config->get('config_language_id') . "'");
	
		return $query->row;
	}
	public function getInformations() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY i.sort_order DESC");
	
		return $query->rows;
	}
	public function getInformationsSortOrder($sort_order) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i.sort_order = '" . (int)$sort_order . "' ORDER BY i.sort_order DESC LIMIT 5");
	
		return $query->rows;
	}

	public function getinformationbydanhmucinfo($danhmucinfo_id, $limit = 20) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i.danhmucinfo_id ='" . (int)$danhmucinfo_id . "' ORDER BY i.sort_order ASC LIMIT " . (int)$limit);
	
		return $query->rows;
	}
}
?>