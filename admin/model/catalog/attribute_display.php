<?php
class ModelCatalogattributedisplay extends Model {
	public function addattributedisplay($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_display SET sort_order = '" . (int)$data['sort_order'] . "', name = '" . $this->db->escape($data['name']) . "', ashow = '" . $this->db->escape($data['ashow']) . "'");
		
		$attribute_display_id = $this->db->getLastId();
		
		$category_data = '';
		
		if (isset($data['category_id'])) {
			foreach ($data['category_id'] as $category_id) {
				if ($category_data) {
					$category_data = $category_data . ',' . $category_id;
				} else {
					$category_data = $category_id;
				}
			}		
		}
		
		$this->db->query("UPDATE " . DB_PREFIX . "attribute_display SET category_id = '" . $this->db->escape($category_data) . "' WHERE attribute_display_id = '" . (int)$attribute_display_id . "'");
		
		$attribute_data = '';
		
		if (isset($data['attribute_data'])) {
			foreach ($data['attribute_data'] as $attribute_id) {
				if ($attribute_data) {
					$attribute_data = $attribute_data . ',' . $attribute_id;
				} else {
					$attribute_data = $attribute_id;
				}
			}		
		}
		
		$this->db->query("UPDATE " . DB_PREFIX . "attribute_display SET attribute_data = '" . $this->db->escape($attribute_data) . "' WHERE attribute_display_id = '" . (int)$attribute_display_id . "'");
		
		$this->cache->delete('attribute_display');
	}
	
	public function editattributedisplay($attribute_display_id, $data) {
      	$this->db->query("UPDATE " . DB_PREFIX . "attribute_display SET sort_order = '" . (int)$data['sort_order'] . "', name = '" . $this->db->escape($data['name']) . "', ashow = '" . $this->db->escape($data['ashow']) . "' WHERE attribute_display_id = '" . (int)$attribute_display_id . "'");
		
		$category_data = '';
		
		if (isset($data['category_id'])) {
			foreach ($data['category_id'] as $category_id) {
				if ($category_data) {
					$category_data = $category_data . ',' . $category_id;
				} else {
					$category_data = $category_id;
				}
			}		
		}
		
		$this->db->query("UPDATE " . DB_PREFIX . "attribute_display SET category_id = '" . $this->db->escape($category_data) . "' WHERE attribute_display_id = '" . (int)$attribute_display_id . "'");
		
		$attribute_data = '';
		
		if (isset($data['attribute_data'])) {
			foreach ($data['attribute_data'] as $attribute_id) {
				if ($attribute_data) {
					$attribute_data = $attribute_data . ',' . $attribute_id;
				} else {
					$attribute_data = $attribute_id;
				}
			}		
		}
		
		$this->db->query("UPDATE " . DB_PREFIX . "attribute_display SET attribute_data = '" . $this->db->escape($attribute_data) . "' WHERE attribute_display_id = '" . (int)$attribute_display_id . "'");
		
		$this->cache->delete('attribute_display');
	}
	
	public function deleteattributedisplay($attribute_display_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "attribute_display WHERE attribute_display_id = '" . (int)$attribute_display_id . "'");
			
		$this->cache->delete('attribute_display');
	}	
	
	public function getattributedisplay($attribute_display_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "attribute_display WHERE attribute_display_id = '" . (int)$attribute_display_id . "'");
		
		return $query->row;
	}
	
	public function getattributedisplays($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "attribute_display ad";
			
			$sort_data = array(
				'ad.name',
				'ad.sort_order'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY ad.ashow,ad.sort_order";	
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
			$attribute_display_data = $this->cache->get('attribute_display');
		
			if (!$attribute_display_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute_display ad ORDER BY ad.ashow,ad.sort_order");
	
				$attribute_display_data = $query->rows;
			
				$this->cache->set('attribute_display', $attribute_display_data);
			}
		 
			return $attribute_display_data;
		}
	}
	
	public function getattributedisplaysByCategoryId($category_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "attribute_display ad WHERE ad.category_id LIKE '%" . (int)$category_id . "%' ORDER BY ad.sort_order";			
		
		$query = $this->db->query($sql);
	
		return $query->rows;
	}

	public function getTotalattributedisplays() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "attribute_display");
		
		return $query->row['total'];
	}
}
?>