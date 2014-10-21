<?php
class ModelCatalogcolor extends Model {
	public function addcolor($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "color SET language_id ='" . (int)$this->config->get('config_language_id') . "', name = '" . $this->db->escape($data['name']) . "', code = '" . $this->db->escape(trim($data['code'])) . "'");
		
		$color_id = $this->db->getLastId();
		
		$this->cache->delete('color');
	}
	
	public function editcolor($color_id, $data) {
      	$this->db->query("UPDATE " . DB_PREFIX . "color SET language_id ='" . (int)$this->config->get('config_language_id') . "', name = '" . $this->db->escape($data['name']) . "', code = '" . $this->db->escape(trim($data['code'])) . "' WHERE color_id = '" . (int)$color_id . "'");
		
		$this->cache->delete('color');
	}
	
	public function deletecolor($color_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "color WHERE color_id = '" . (int)$color_id . "'");
			
		$this->cache->delete('color');
	}	
	
	public function getcolor($color_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "color WHERE color_id = '" . (int)$color_id . "'");
		
		return $query->row;
	}
	
	public function getcolors($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "color";
			
			$sort_data = array(
				'name',
				'code'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY name";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
			
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}					

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}				
			
			$query = $this->db->query($sql);
		
			return $query->rows;
		} else {
			$color_data = $this->cache->get('color');
		
			if (!$color_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "color ORDER BY name");
	
				$color_data = $query->rows;
			
				$this->cache->set('color', $color_data);
			}
		 
			return $color_data;
		}
	}

	public function getTotalcolors() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "color");
		
		return $query->row['total'];
	}	
}
?>