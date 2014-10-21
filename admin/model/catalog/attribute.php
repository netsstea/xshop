<?php
class ModelCatalogattribute extends Model {
	public function addattribute($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "attribute SET sort_order = '" . (int)$data['sort_order'] . "', name = '" . $this->db->escape($data['name']) . "', text_default = '" . $this->db->escape($data['text_default']) . "', attribute_group_id = '" . (int)$data['attribute_group_id'] . "'");
		
		$attribute_id = $this->db->getLastId();
		
		$this->cache->delete('attribute');
	}
	
	public function editattribute($attribute_id, $data) {
      	$this->db->query("UPDATE " . DB_PREFIX . "attribute SET sort_order = '" . (int)$data['sort_order'] . "', name = '" . $this->db->escape($data['name']) . "', text_default = '" . $this->db->escape($data['text_default']) . "', attribute_group_id = '" . (int)$data['attribute_group_id'] . "' WHERE attribute_id = '" . (int)$attribute_id . "'");
		
		$this->cache->delete('attribute');
	}
	
	public function deleteattribute($attribute_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "attribute WHERE attribute_id = '" . (int)$attribute_id . "'");
			
		$this->cache->delete('attribute');
	}	
	
	public function getattribute($attribute_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "attribute WHERE attribute_id = '" . (int)$attribute_id . "'");
		
		return $query->row;
	}
	
	public function getattributes($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "attribute a";
			
			$sort_data = array(
				'a.name',
				'a.sort_order'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY a.attribute_group_id";	
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
			$attribute_data = $this->cache->get('attribute');
		
			if (!$attribute_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute a ORDER BY a.attribute_group_id");
	
				$attribute_data = $query->rows;
			
				$this->cache->set('attribute', $attribute_data);
			}
		 
			return $attribute_data;
		}
	}
	
	public function getAttributesByAttributeGroupId($attribute_group_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "attribute a WHERE a.attribute_group_id = '" . (int)$attribute_group_id . "' ORDER BY a.sort_order";			
		
		$query = $this->db->query($sql);
	
		return $query->rows;
	}
	
	public function getTotalAttributesByAttributeGroupId($attribute_group_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "attribute WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");

		return $query->row['total'];
	}

	public function getTotalattributes() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "attribute");
		
		return $query->row['total'];
	}
}
?>