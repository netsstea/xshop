<?php
class ModelCatalogManufacturer extends Model {
	public function addManufacturer($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer SET sort_order = '" . (int)$data['sort_order'] . "', menu_status = '" . (int)$data['menu_status'] . "'");
		
		$manufacturer_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET image = '" . $this->db->escape($data['image']) . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		}
		
		if (isset($data['banner'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET banner = '" . $this->db->escape($data['banner']) . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		}
		
		if (isset($data['icon_menu'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET icon_menu = '" . $this->db->escape($data['icon_menu']) . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		}
		
		foreach ($data['manufacturer_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_description SET manufacturer_id = '" . (int)$manufacturer_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "history SET user_id = '" . (int)$this->user->getId() . "', username = '" . $this->db->escape($this->user->getUserName()) . "', generic = 'manufacturer_add', code = 'manufacturer_id=" . (int)$manufacturer_id . "', date_added = NOW()");
		
		$this->cache->delete('manufacturer');
	}
	
	public function editManufacturer($manufacturer_id, $data) {
      	$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET sort_order = '" . (int)$data['sort_order'] . "', menu_status = '" . (int)$data['menu_status'] . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET image = '" . $this->db->escape($data['image']) . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		}
		
		if (isset($data['banner'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET banner = '" . $this->db->escape($data['banner']) . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		}
		
		if (isset($data['icon_menu'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET icon_menu = '" . $this->db->escape($data['icon_menu']) . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_description WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		foreach ($data['manufacturer_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_description SET manufacturer_id = '" . (int)$manufacturer_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "history SET user_id = '" . (int)$this->user->getId() . "', username = '" . $this->db->escape($this->user->getUserName()) . "', generic = 'manufacturer_edit', code = 'manufacturer_id=" . (int)$manufacturer_id . "', date_added = NOW()");
		
		$this->cache->delete('manufacturer');
	}
	
	public function deleteManufacturer($manufacturer_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_description WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
			
		$this->cache->delete('manufacturer');
	}	
	
	public function getManufacturer($manufacturer_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		
		return $query->row;
	}
	
	public function getManufacturers($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (m.manufacturer_id = md.manufacturer_id) WHERE md.language_id = '" . (int)$this->config->get('config_language_id') . "'";
			
			$sort_data = array(
				'md.name',
				'm.sort_order'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY md.name";	
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
			$manufacturer_data = $this->cache->get('manufacturer');
		
			if (!$manufacturer_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (m.manufacturer_id = md.manufacturer_id) WHERE md.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY md.name");
	
				$manufacturer_data = $query->rows;
			
				$this->cache->set('manufacturer', $manufacturer_data);
			}
		 
			return $manufacturer_data;
		}
	}
	
	public function getManufacturersByCategoryId($category_id) {
			$sql = "SELECT * FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (m.manufacturer_id = md.manufacturer_id) LEFT JOIN " . DB_PREFIX . "category_to_manufacturer c2m ON (m.manufacturer_id = c2m.manufacturer_id) WHERE md.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2m.category_id = '" . (int)$category_id . "'";
			
			$sql .= " ORDER BY md.name ASC";
			
			$query = $this->db->query($sql);
		
			return $query->rows;
	}
	
	public function getmanufacturerDescriptions($manufacturer_id) {
		$manufacturer_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer_description WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		foreach ($query->rows as $result) {
			$manufacturer_description_data[$result['language_id']] = array(
				'name'            => $result['name']
			);
		}
		
		return $manufacturer_description_data;
	}

	public function getTotalManufacturers() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "manufacturer");
		
		return $query->row['total'];
	}
	
	public function khongdau($text){
	//global $ibforums;
	//Charachters must be in ASCII and certain ones aint allowed
	$text = html_entity_decode ($text, ENT_QUOTES, 'UTF-8');
	$text = preg_replace("/(ä|à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $text);
	$text = str_replace("ç","c",$text);
	$text = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $text);
	$text = preg_replace("/(ì|í|î|ị|ỉ|ĩ)/", 'i', $text);
	$text = preg_replace("/(ö|ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $text);
	$text = preg_replace("/(ü|ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $text);
	$text = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $text);
	$text = preg_replace("/(đ)/", 'd', $text);
	//CHU HOA
	$text = preg_replace("/(Ä|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $text);
	$text = str_replace("Ç","C",$text);
	$text = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $text);
	$text = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $text);
	$text = preg_replace("/(Ö|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $text);
	$text = preg_replace("/(Ü|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $text);
	$text = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $text);
	$text = preg_replace("/(Đ)/", 'D', $text);
	$text = preg_replace("/[^a-zA-Z0-9\-\_]/", ' ', $text);
	$text = str_replace("     ", ' ', $text);
	$text = str_replace("    ", ' ', $text);
	$text = str_replace("   ", ' ', $text);
	$text = str_replace("  ", ' ', $text);
	$text = str_replace(" - ", ' ', trim($text));
	$text = str_replace(" -", ' ', trim($text));
	$text = str_replace("- ", ' ', trim($text));
	$text = str_replace(" ", '-', trim($text));
	return strtolower($text);
	}
}
?>