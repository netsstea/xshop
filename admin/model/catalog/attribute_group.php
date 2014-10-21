<?php
class ModelCatalogattributegroup extends Model {
	public function addattributegroup($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_group SET sort_order = '" . (int)$data['sort_order'] . "', name = '" . $this->db->escape($data['name']) . "'");
		
		$attribute_group_id = $this->db->getLastId();
		
		$cat = '';
		
		if (isset($data['category_id'])) {
			foreach ($data['category_id'] as $category_id) {
				if ($cat) {
					$cat = $cat . ',' . $category_id;
				} else {
					$cat = $category_id;
				}
			}		
		}
		
		$this->db->query("UPDATE " . DB_PREFIX . "attribute_group SET category_id = '" . $this->db->escape($cat) . "' WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");
		
		$this->cache->delete('attribute_group');
	}
	
	public function editattributegroup($attribute_group_id, $data) {
      	$this->db->query("UPDATE " . DB_PREFIX . "attribute_group SET sort_order = '" . (int)$data['sort_order'] . "', name = '" . $this->db->escape($data['name']) . "' WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");
		
		$cat = '';
		
		if (isset($data['category_id'])) {
			foreach ($data['category_id'] as $category_id) {
				if ($cat) {
					$cat = $cat . ',' . $category_id;
				} else {
					$cat = $category_id;
				}
			}		
		}
		
		$this->db->query("UPDATE " . DB_PREFIX . "attribute_group SET category_id = '" . $this->db->escape($cat) . "' WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");
		
		$this->cache->delete('attribute_group');
	}
	
	public function deleteattributegroup($attribute_group_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "attribute_group WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");
			
		$this->cache->delete('attribute_group');
	}	
	
	public function getattributegroup($attribute_group_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "attribute_group WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");
		
		return $query->row;
	}
	
	public function getattributegroups($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "attribute_group ag";
			
			$sort_data = array(
				'ag.name',
				'ag.sort_order'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY ag.category_id";	
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
			$attribute_group_data = $this->cache->get('attribute_group');
		
			if (!$attribute_group_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute_group ag ORDER BY ag.category_id");
	
				$attribute_group_data = $query->rows;
			
				$this->cache->set('attribute_group', $attribute_group_data);
			}
		 
			return $attribute_group_data;
		}
	}
	
	public function getAttributeGroupsByCategoryId($category_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "attribute_group ag WHERE ag.category_id LIKE '%" . (int)$category_id . "%' ORDER BY ag.sort_order";			
		
		$query = $this->db->query($sql);
	
		return $query->rows;
	}
	
	public function getTotalAttributeGroupsByCategoryId($category_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "attribute_group WHERE category_id = '" . (int)$category_id . "'");

		return $query->row['total'];
	}

	public function getTotalattributegroups() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "attribute_group");
		
		return $query->row['total'];
	}
}
?>