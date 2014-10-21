<?php
class ModelCatalogtraodoilogo extends Model {
	public function gettraodoilogo($traodoilogo_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "traodoilogo i LEFT JOIN " . DB_PREFIX . "traodoilogo_description id ON (i.traodoilogo_id = id.traodoilogo_id) WHERE i.traodoilogo_id = '" . (int)$traodoilogo_id . "' AND id.language_id = '" . (int)$this->config->get('config_language_id') . "'");
	
		return $query->row;
	}
	
	public function gettraodoilogos($hienthi) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "traodoilogo i LEFT JOIN " . DB_PREFIX . "traodoilogo_description id ON (i.traodoilogo_id = id.traodoilogo_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i.hienthi ='" .$hienthi. "' ORDER BY i.sort_order ASC");
	
		return $query->rows;
	}
}
?>