<?php
class ModelCatalogredirecturl extends Model {
	public function addredirect_url($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "redirect_url SET url_goc = '" . $this->db->escape($data['url_goc']) . "', url_dich = '" . $this->db->escape($data['url_dich']) . "'");
		
		$redirect_url_id = $this->db->getLastId();
		
		$this->cache->delete('redirect_url');
	}
	
	public function editredirect_url($redirect_url_id, $data) {
      	$this->db->query("UPDATE " . DB_PREFIX . "redirect_url SET url_goc = '" . $this->db->escape($data['url_goc']) . "', url_dich = '" . $this->db->escape($data['url_dich']) . "' WHERE redirect_url_id = '" . (int)$redirect_url_id . "'");
		
		$this->cache->delete('redirect_url');
	}
	
	public function deleteredirect_url($redirect_url_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "redirect_url WHERE redirect_url_id = '" . (int)$redirect_url_id . "'");
			
		$this->cache->delete('redirect_url');
	}	
	
	public function getredirect_url($redirect_url_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "redirect_url WHERE redirect_url_id = '" . (int)$redirect_url_id . "'");
		
		return $query->row;
	}
	
	public function getredirect_urls($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "redirect_url";
			
			$sort_data = array(
				'url_goc',
				'url_dich'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY redirect_url_id";	
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
			$redirect_url_data = $this->cache->get('redirect_url');
		
			if (!$redirect_url_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "redirect_url ORDER BY redirect_url_id");
	
				$redirect_url_data = $query->rows;
			
				$this->cache->set('redirect_url', $redirect_url_data);
			}
		 
			return $redirect_url_data;
		}
	}

	public function getTotalredirect_urls() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "redirect_url");
		
		return $query->row['total'];
	}	
}
?>