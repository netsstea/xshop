<?php
class ModelCatalogshowroom extends Model {	
	public function getshowroomsByZoneId($zone_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "showroom WHERE zone_id = '" . (int)$zone_id . "' ORDER BY sort_order");

		return $query->rows;
	}
	
	public function getshowrooms() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "showroom ORDER BY sort_order");

		return $query->rows;
	}
	
	public function getshowroom($showroom_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "showroom WHERE showroom_id = '" . (int)$showroom_id . "'");

		return $query->row;
	}
}
?>