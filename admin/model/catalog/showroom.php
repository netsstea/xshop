<?php
class ModelCatalogshowroom extends Model {
	public function addshowroom($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "showroom SET name = '" . $this->db->escape($data['name']) . "', address = '" . $this->db->escape($data['address']) . "', hotline = '" . $this->db->escape($data['hotline']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', sort_order = '" . (int)$data['sort_order'] . "', zone_id = '" . (int)$data['zone_id'] . "', google_maps = '" . $this->db->escape($data['google_maps']) . "'");
		
		$showroom_id = $this->db->getLastId();
		
		$this->cache->delete('showroom');
	}
	
	public function editshowroom($showroom_id, $data) {
      	$this->db->query("UPDATE " . DB_PREFIX . "showroom SET  name = '" . $this->db->escape($data['name']) . "', address = '" . $this->db->escape($data['address']) . "', hotline = '" . $this->db->escape($data['hotline']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', sort_order = '" . (int)$data['sort_order'] . "', zone_id = '" . (int)$data['zone_id'] . "', google_maps = '" . $this->db->escape($data['google_maps']) . "' WHERE showroom_id = '" . (int)$showroom_id . "'");
		
		$this->cache->delete('showroom');
	}
	
	public function deleteshowroom($showroom_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "showroom WHERE showroom_id = '" . (int)$showroom_id . "'");
			
		$this->cache->delete('showroom');
	}	
	
	public function getshowroom($showroom_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "showroom WHERE showroom_id = '" . (int)$showroom_id . "'");
		
		return $query->row;
	}
	
	public function getshowrooms() {
	
		$sql = "SELECT * FROM " . DB_PREFIX . "showroom";
		
		$sql .= " ORDER BY sort_order";	
		
		$sql .= " LIMIT  0,20";
		
		$query = $this->db->query($sql);
	
		return $query->rows;
	}

	public function getTotalshowrooms() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "showroom");
		
		return $query->row['total'];
	}	
}
?>