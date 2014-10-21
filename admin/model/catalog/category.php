<?php
class ModelCatalogCategory extends Model {
	public function addCategory($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW(), date_added = NOW()");
	
		$category_id = $this->db->getLastId();
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category SET image = '" . $this->db->escape($data['image']) . "' WHERE category_id = '" . (int)$category_id . "'");
		}
		
		if (isset($data['banner'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category SET banner = '" . $this->db->escape($data['banner']) . "' WHERE category_id = '" . (int)$category_id . "'");
		}
		
		if (isset($data['icon_menu'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category SET icon_menu = '" . $this->db->escape($data['icon_menu']) . "' WHERE category_id = '" . (int)$category_id . "'");
		}
		
		if (isset($data['icon_mobile'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category SET icon_mobile = '" . $this->db->escape($data['icon_mobile']) . "' WHERE category_id = '" . (int)$category_id . "'");
		}

		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', name_seo = '" . $this->db->escape($value['name_seo']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', keywords = '" . $this->db->escape($value['keywords']) . "'");
		}
		
		if (isset($data['category_manufacturer'])) {
			foreach ($data['category_manufacturer'] as $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_manufacturer SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$this->config->get('config_language_id') . "', manufacturer_id = '" . (int)$value['manufacturer_id'] . "', name_seo = '" . $this->db->escape($value['name_seo']) . "', ex_name = '" . $this->db->escape($value['ex_name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', keywords = '" . $this->db->escape($value['keywords']) . "', sort_order = '" . $this->db->escape($value['sort_order']) . "'");
			}
		}
		
		$cshow_data = '';
		
		if (isset($data['cshow'])) {
			foreach ($data['cshow'] as $cshow) {
				if ($cshow_data) {
					$cshow_data = $cshow_data . ',' . $cshow;
				} else {
					$cshow_data = $cshow;
				}
			}		
		}
		
		$this->db->query("UPDATE " . DB_PREFIX . "category SET cshow = '" . $this->db->escape($cshow_data) . "' WHERE category_id = '" . (int)$category_id . "'");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "history SET user_id = '" . (int)$this->user->getId() . "', username = '" . $this->db->escape($this->user->getUserName()) . "', generic = 'category_add', code = 'category_id=" . (int)$category_id . "', date_added = NOW()");
		
		$this->cache->delete('category');
	}
	
	public function editCategory($category_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE category_id = '" . (int)$category_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category SET image = '" . $this->db->escape($data['image']) . "' WHERE category_id = '" . (int)$category_id . "'");
		}
		
		if (isset($data['banner'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category SET banner = '" . $this->db->escape($data['banner']) . "' WHERE category_id = '" . (int)$category_id . "'");
		}
		
		if (isset($data['icon_menu'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category SET icon_menu = '" . $this->db->escape($data['icon_menu']) . "' WHERE category_id = '" . (int)$category_id . "'");
		}
		
		if (isset($data['icon_mobile'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category SET icon_mobile = '" . $this->db->escape($data['icon_mobile']) . "' WHERE category_id = '" . (int)$category_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");

		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', name_seo = '" . $this->db->escape($value['name_seo']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', keywords = '" . $this->db->escape($value['keywords']) . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_manufacturer WHERE category_id = '" . (int)$category_id . "'");
		
		if (isset($data['category_manufacturer'])) {
			foreach ($data['category_manufacturer'] as $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_manufacturer SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$this->config->get('config_language_id') . "', manufacturer_id = '" . (int)$value['manufacturer_id'] . "', name_seo = '" . $this->db->escape($value['name_seo']) . "', ex_name = '" . $this->db->escape($value['ex_name']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', keywords = '" . $this->db->escape($value['keywords']) . "', sort_order = '" . $this->db->escape($value['sort_order']) . "'");
			}
		}
		
		$cshow_data = '';
		
		if (isset($data['cshow'])) {
			foreach ($data['cshow'] as $cshow) {
				if ($cshow_data) {
					$cshow_data = $cshow_data . ',' . $cshow;
				} else {
					$cshow_data = $cshow;
				}
			}		
		}
		
		$this->db->query("UPDATE " . DB_PREFIX . "category SET cshow = '" . $this->db->escape($cshow_data) . "' WHERE category_id = '" . (int)$category_id . "'");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "history SET user_id = '" . (int)$this->user->getId() . "', username = '" . $this->db->escape($this->user->getUserName()) . "', generic = 'category_edit', code = 'category_id=" . (int)$category_id . "', date_added = NOW()");
		
		$this->cache->delete('category');
	}
	
	public function deleteCategory($category_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_manufacturer WHERE category_id = '" . (int)$category_id . "'");
		
		$query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "category WHERE parent_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteCategory($result['category_id']);
		}
		
		$this->cache->delete('category');
	} 

	public function getCategory($category_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$category_id . "'");
		
		return $query->row;
	}
	
	public function getCategoryDesc($category_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");
		
		return $query->row;
	}
	
	public function getCategories1($parent_id) {

			$category_data = array();
		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");
		
			foreach ($query->rows as $result) {
				$category_data[] = array(
					'category_id' => $result['category_id'],
					'name'        => $result['name'],
					'sort_order'  => $result['sort_order']
				);
			}

		return $category_data;
	}
	
	public function getCategories($parent_id) {
		$category_data = $this->cache->get('category.' . $this->config->get('config_language_id') . '.' . $parent_id);
	
		if (!$category_data) {
			$category_data = array();
		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");
		
			foreach ($query->rows as $result) {
				$category_data[] = array(
					'category_id' => $result['category_id'],
					'name'        => $this->getPath($result['category_id'], $this->config->get('config_language_id')),
					'sort_order'  => $result['sort_order']
				);
			
				$category_data = array_merge($category_data, $this->getCategories($result['category_id']));
			}	
	
			$this->cache->set('category.' . $this->config->get('config_language_id') . '.' . $parent_id, $category_data);
		}
		
		return $category_data;
	}
	
	public function getCategories2($parent_id) {

		$category_data = array();
		
		$query1 = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.category_id = '" . (int)$parent_id . "'");
		
		$category_info = $query1->row;
		if($category_info) {
			$category_data[] = array(
				'category_id' => $category_info['category_id'],
				'name'        => $category_info['name'],
				'sort_order'  => $category_info['sort_order']
			);
		}
	
		$query2 = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");
	
		foreach ($query2->rows as $result) {
			$category_data[] = array(
				'category_id' => $result['category_id'],
				'name'        => $this->getPath($result['category_id'], $this->config->get('config_language_id')),
				'sort_order'  => $result['sort_order']
			);
		
			$category_data = array_merge($category_data, $this->getCategories($result['category_id']));
		}	

		
		return $category_data;
	}
	
	public function getCategoriesFilter($parent_id) {

		$category_data = array();
	
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");
	
		foreach ($query->rows as $result) {
		
			$cshow_info = str_replace('thuonghieu=1',' thuonghieu=1 ',$result['cshow']);
			
			if(strpos($cshow_info,"thuonghieu=1")) {
				$category_data[] = array(
					'category_id' => $result['category_id'],
					'name'        => $result['name'],
					'sort_order'  => $result['sort_order']
				);
				
				$manufacturers = $this->getManufacturerByCategoryId($result['category_id']);
				
				foreach($manufacturers as $manufacturer) {
					$category_data[] = array(
						'category_id' => $result['category_id'] . '_' . $manufacturer['manufacturer_id'],
						'name'        => $result['name'] . ' > ' . $manufacturer['name'],
						'sort_order'  => $result['sort_order']
					);
				}
			} else {
				$category_data[] = array(
					'category_id' => $result['category_id'],
					'name'        => $this->getPath($result['category_id'], $this->config->get('config_language_id')),
					'sort_order'  => $result['sort_order']
				);
			}
		
			$category_data = array_merge($category_data, $this->getCategories($result['category_id']));
		}
		
		return $category_data;
	}
	
	public function getManufacturerByCategoryId($category_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (m.manufacturer_id = md.manufacturer_id) LEFT JOIN " . DB_PREFIX . "category_to_manufacturer m2c ON (m.manufacturer_id = m2c.manufacturer_id) WHERE m2c.category_id = '" . (int)$category_id . "' ORDER BY m2c.sort_order");

		return $query->rows;
	}
	
	public function getPath($category_id) {
		$query = $this->db->query("SELECT name, parent_id FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");
		
		$category_info = $query->row;
		
		if ($category_info['parent_id']) {
			return $this->getPath($category_info['parent_id'], $this->config->get('config_language_id')) . $this->language->get('text_separator') . $category_info['name'];
		} else {
			return $category_info['name'];
		}
	}
	
	public function getCategoryDescriptions($category_id) {
		$category_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");
		
		foreach ($query->rows as $result) {
			$category_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'keywords'         => $result['keywords'],
				'name_seo'         => $result['name_seo'],
				'meta_description' => $result['meta_description'],
				'description'      => $result['description']
			);
		}
		
		return $category_description_data;
	}

	public function getCategoryManufacturer($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_manufacturer WHERE category_id = '" . (int)$category_id . "'");
		
		return $query->rows;
	}
		
	public function getTotalCategories() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category");
		
		return $query->row['total'];
	}	
		
}
?>