<?php
class ModelCatalogphanloai extends Model {
	public function addphanloai($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "phanloai SET parent_id = '" . (int)$data['parent_id'] . "', sort_order = '" . (int)$data['sort_order'] . "'");
		
		$phanloai_id = $this->db->getLastId();
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "phanloai SET image = '" . $this->db->escape($data['image']) . "' WHERE phanloai_id = '" . (int)$phanloai_id . "'");
		}
		
		foreach ($data['phanloai_info'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "phanloai_info SET phanloai_id = '" . (int)$phanloai_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");	
		}
		
		if (isset($data['phanloai_category'])) {
			foreach ($data['phanloai_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "phanloai_to_category SET phanloai_id = '" . (int)$phanloai_id . "', category_id = '" . (int)$category_id . "'");
			}		
		}
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "history SET user_id = '" . (int)$this->user->getId() . "', username = '" . $this->db->escape($this->user->getUserName()) . "', generic = 'phanloai_add', code = 'phanloai_id=" . (int)$phanloai_id . "', date_added = NOW()");
		
		$this->cache->delete('phanloai');
	}
	
	public function editphanloai($phanloai_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "phanloai SET parent_id = '" . (int)$data['parent_id'] . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE phanloai_id = '" . (int)$phanloai_id . "'");
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "phanloai SET image = '" . $this->db->escape($data['image']) . "' WHERE phanloai_id = '" . (int)$phanloai_id . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "phanloai_info WHERE phanloai_id = '" . (int)$phanloai_id . "'");
		
		foreach ($data['phanloai_info'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "phanloai_info SET phanloai_id = '" . (int)$phanloai_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "phanloai_to_category WHERE phanloai_id = '" . (int)$phanloai_id . "'");
		
		if (isset($data['phanloai_category'])) {
			foreach ($data['phanloai_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "phanloai_to_category SET phanloai_id = '" . (int)$phanloai_id . "', category_id = '" . (int)$category_id . "'");
			}		
		}
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "history SET user_id = '" . (int)$this->user->getId() . "', username = '" . $this->db->escape($this->user->getUserName()) . "', generic = 'phanloai_edit', code = 'phanloai_id=" . (int)$phanloai_id . "', date_added = NOW()");
		
		$this->cache->delete('phanloai');
	}
	
	public function deletephanloai($phanloai_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "phanloai WHERE phanloai_id = '" . (int)$phanloai_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "phanloai_info WHERE phanloai_id = '" . (int)$phanloai_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "phanloai_to_category WHERE phanloai_id = '" . (int)$phanloai_id . "'");
		$query = $this->db->query("SELECT phanloai_id FROM " . DB_PREFIX . "phanloai WHERE parent_id = '" . (int)$phanloai_id . "'");

		foreach ($query->rows as $result) {
			$this->deletephanloai($result['phanloai_id']);
		}
		$this->cache->delete('phanloai');
	}	
	
	public function getphanloai($phanloai_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . " phanloai WHERE phanloai_id = '" . (int)$phanloai_id . "'");
		
		return $query->row;
	}
	
	public function getPhanloais1($parent_id) {
		$phanloai_data = array();
	
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "phanloai p LEFT JOIN " . DB_PREFIX . "phanloai_info pi ON (p.phanloai_id = pi.phanloai_id) WHERE p.parent_id = '" . (int)$parent_id . "' AND pi.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY p.sort_order, pi.name ASC");
	
		foreach ($query->rows as $result) {
			$phanloai_data[] = array(
				'phanloai_id' => $result['phanloai_id'],
				'name'        => $result['name'],
				'sort_order'  => $result['sort_order']
			);
		}
		
		return $phanloai_data;
	}
	
	public function getPhanloais($parent_id) {
		$phanloai_data = array();
	
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "phanloai p LEFT JOIN " . DB_PREFIX . "phanloai_info pi ON (p.phanloai_id = pi.phanloai_id) WHERE p.parent_id = '" . (int)$parent_id . "' AND pi.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY p.sort_order, pi.name ASC");
	
		foreach ($query->rows as $result) {
			$phanloai_data[] = array(
				'phanloai_id' => $result['phanloai_id'],
				'name'        => $this->getPath($result['phanloai_id'], $this->config->get('config_language_id')),
				'sort_order'  => $result['sort_order']
			);
		
			$phanloai_data = array_merge($phanloai_data, $this->getphanloais($result['phanloai_id']));
		}
		
		return $phanloai_data;
	}
	
	public function getPhanloaiCat() {

			$phanloai_data = array();
		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "phanloai p LEFT JOIN " . DB_PREFIX . "phanloai_info pi ON (p.phanloai_id = pi.phanloai_id) WHERE pi.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY p.sort_order, pi.name ASC");
		
			foreach ($query->rows as $result) {
				if(!$this->getPathCat($result['phanloai_id'], $this->config->get('config_language_id'))) {
					$phanloai_data[] = array(
						'phanloai_id' => $result['phanloai_id'],
						'name'        => $result['name'],
						'sort_order'  => $result['sort_order']
					);
				}
			}
			
		return $phanloai_data;
	}
	
	public function getPath($phanloai_id) {
		$query = $this->db->query("SELECT name, parent_id FROM " . DB_PREFIX . "phanloai p LEFT JOIN " . DB_PREFIX . "phanloai_info pi ON (p.phanloai_id = pi.phanloai_id) WHERE p.phanloai_id = '" . (int)$phanloai_id . "' AND pi.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY p.sort_order, pi.name ASC");
		
		$phanloai_info = $query->row;
		
		if ($phanloai_info['parent_id']) {
			return $this->getPath($phanloai_info['parent_id'], $this->config->get('config_language_id')) . $this->language->get('text_separator') . $phanloai_info['name'];
		} else {
			return $phanloai_info['name'];
		}
	}
	
	public function getPathCat($phanloai_id) {
		$query = $this->db->query("SELECT name, parent_id FROM " . DB_PREFIX . "phanloai p LEFT JOIN " . DB_PREFIX . "phanloai_info pi ON (p.phanloai_id = pi.phanloai_id) WHERE p.phanloai_id = '" . (int)$phanloai_id . "' AND pi.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY p.sort_order, pi.name ASC");
		
		$phanloai_info = $query->row;
		
		if ($phanloai_info['parent_id']) {
			return True;
		} else {
			return False;
		}
	}
	
	public function getphanloaiss($phanloai_id) {
		$phanloai_info_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "phanloai_info WHERE phanloai_id = '" . (int)$phanloai_id . "'");
		
		foreach ($query->rows as $result) {
			$phanloai_info_data[$result['language_id']] = array(
				'name'             => $result['name']
			);
		}
		
		return $phanloai_info_data;
	}
	
	public function getPhanloaiCategories($phanloai_id) {
		$phanloai_category_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "phanloai_to_category WHERE phanloai_id = '" . (int)$phanloai_id . "'");
		
		foreach ($query->rows as $result) {
			$phanloai_category_data[] = $result['category_id'];
		}

		return $phanloai_category_data;
	}

	public function getTotalphanloaiByImageId($image_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "phanloai WHERE image_id = '" . (int)$image_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalphanloais() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "phanloai");
		
		return $query->row['total'];
	}	
}
?>