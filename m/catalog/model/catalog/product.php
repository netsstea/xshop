<?php
class ModelCatalogProduct extends Model {
	public function getProduct($product_id) {
		$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");
	
		return $query->row;
	}

	public function getProducts() {
		$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");
	
		return $query->rows;
	}
	
	public function getProductsByCategoryId($category_id, $sort = 'p.sort_order', $order = 'DESC', $start = 0, $limit = 20) {
		$sql = "SELECT *, pd.name AS name, p.sort_order, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "'";

		$sort_data = array(
			'pd.name',
			'p.sort_order',
			'p.price',
			'rating'
		);	
			
		if (in_array($sort, $sort_data)) {
			$sql .= " ORDER BY " . $sort;
		} else {
			$sql .= " ORDER BY p.sort_order";	
		}
			
		if ($order == 'DESC') {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		if ($start < 0) {
			$start = 0;
		}
		
		$sql .= " LIMIT " . (int)$start . "," . (int)$limit;
		
		$query = $this->db->query($sql);
								  
		return $query->rows;
	} 
	
	public function getTotalProductsByCategoryId($category_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_category p2c LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2c.category_id = '" . (int)$category_id . "'");

		return $query->row['total'];
	}

	public function getProductsByManufacturerId($manufacturer_id, $sort = 'p.viewed', $order = 'DESC', $start = 0, $limit = 20) {
		$sql = "SELECT *, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' AND m.manufacturer_id = '" . (int)$manufacturer_id. "'";

		$sort_data = array(
			'pd.name',
			'p.viewed',
			'p.price',
			'rating'
		);	
			
		if (in_array($sort, $sort_data)) {
			$sql .= " ORDER BY " . $sort;
		} else {
			$sql .= " ORDER BY p.viewed";	
		}
			
		if ($order == 'DESC') {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if ($start < 0) {
			$start = 0;
		}
		
		$sql .= " LIMIT " . (int)$start . "," . (int)$limit;
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}

	public function getProductsByManufacturerIdBanggia($manufacturer_id, $sort = 'p.viewed', $order = 'DESC') {
		$sql = "SELECT *, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' AND m.manufacturer_id = '" . (int)$manufacturer_id. "'";

		$sort_data = array(
			'pd.name',
			'p.viewed',
			'p.price',
			'rating'
		);	
			
		if (in_array($sort, $sort_data)) {
			$sql .= " ORDER BY " . $sort;
		} else {
			$sql .= " ORDER BY p.viewed";	
		}
			
		if ($order == 'DESC') {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
	public function getTotalProductsByManufacturerId($manufacturer_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE status = '1' AND date_available <= NOW() AND manufacturer_id = '" . (int)$manufacturer_id . "'");
		
		return $query->row['total'];
	}

	public function getProductsBydanhmuchomeId($danhmuchome_id, $start = 0, $limit = 20) {
		$sql = "SELECT *, pd.name AS name, p.image, p.sort_order, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.danhmuchome_id = '" . (int)$danhmuchome_id. "'";

		$sql .= " ORDER BY p.sort_order ASC";

		if ($start < 0) {
			$start = 0;
		}
		
		$sql .= " LIMIT " . (int)$start . "," . (int)$limit;
		
		$query = $this->db->query($sql);
		
		return $query->rows;
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
$text = str_replace(" ", '-', trim($text));
return trim($text);
}
	public function getProductsByKeyword($keyword, $sort = 'p.viewed', $order = 'DESC', $start = 0, $limit = 20) {
		if ($keyword) {
			$sql = "SELECT *, pd.name AS name,p.viewed, pd.name_search AS name_search, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "'";
			
			$sql .= " AND (pd.name_search LIKE '%" . $this->model_catalog_product->khongdau($this->request->get['keyword']) . "%' OR pd.name LIKE '%" . $this->db->escape($keyword) . "%' OR pd.tags LIKE '%" . $this->db->escape($keyword) . "%' OR pd.tags_search LIKE '%" .  $this->model_catalog_product->khongdau($this->request->get['keyword']) . "%' OR pd.description LIKE '%" . $this->db->escape($keyword) . "%' OR pd.description_search LIKE '%" . $this->model_catalog_product->khongdau($this->request->get['keyword']) . "%')";
		
			$sql .= " AND p.status = '1' AND p.date_available <= NOW()";
		
			$sort_data = array(
				'pd.name',
				'p.viewed',
				'p.price',
				'rating'
			);	
			
			if (in_array($sort, $sort_data)) {
				$sql .= " ORDER BY " . $sort;
			} else {
				$sql .= " ORDER BY p.viewed";	
			}
			
			if ($order == 'DESC') {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}

			if ($start < 0) {
				$start = 0;
			}
		
			$sql .= " LIMIT " . (int)$start . "," . (int)$limit;

			$query = $this->db->query($sql);
		
			return $query->rows;
		} else {
			return 0;	
		}
	}
	
	public function getTotalProductsByKeyword($keyword) {
		if ($keyword) {
			$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
			
			$sql .= " AND (pd.name_search LIKE '%" . $this->model_catalog_product->khongdau($this->request->get['keyword']) . "%' OR pd.name LIKE '%" . $this->db->escape($keyword) . "%' OR pd.tags LIKE '%" . $this->db->escape($keyword) . "%' OR pd.tags_search LIKE '%" .  $this->model_catalog_product->khongdau($this->request->get['keyword']) . "%' OR pd.description LIKE '%" . $this->db->escape($keyword) . "%' OR pd.description_search LIKE '%" . $this->model_catalog_product->khongdau($this->request->get['keyword']) . "%')";
			
			$sql .= " AND p.status = '1' AND p.date_available <= NOW()";
			
			$query = $this->db->query($sql);
		
			if ($query->num_rows) {
				return $query->row['total'];	
			} else {
				return 0;
			}
		} else {
			return 0;	
		}		
	}
	
	public function getPath($category_id) {
		$string = $category_id . ',';
		
		$results = $this->model_catalog_category->getCategories($category_id);

		foreach ($results as $result) {
			$string .= $this->getPath($result['category_id']);
		}
		
		return $string;
	}	
	
	public function getLatestProducts($limit) {
		$product_data = $this->cache->get('product.latest.' . $this->config->get('config_language_id') . '.' . $limit);

		if (!$product_data) { 
			$query = $this->db->query("SELECT *, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$limit);
		 	 
			$product_data = $query->rows;

			$this->cache->set('product.latest.' . $this->config->get('config_language_id') . '.' . $limit, $product_data);
		}
		
		return $product_data;
	}

	public function getBestSellerProducts($limit) {
		$product_data = $this->cache->get('product.bestseller.' . $this->config->get('config_language_id') . '.' . $limit);

		if (!$product_data) { 
			$product_data = array();
			
			$query = $this->db->query("SELECT op.product_id, SUM(op.quantity) AS total FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) WHERE o.order_status_id > '0' GROUP BY op.product_id ORDER BY total DESC LIMIT " . (int)$limit);
			
			foreach ($query->rows as $result) {
				$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$result['product_id'] . "' AND p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
				
				if ($product_query->num_rows) {
					$product_data[] = $product_query->row;
				}
			}

			$this->cache->set('product.bestseller.' . $this->config->get('config_language_id') . '.' . $limit, $product_data);
		}
		
		return $product_data;
	}
		
	public function updateViewed($product_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "product SET viewed = viewed + 1 WHERE product_id = '" . (int)$product_id . "'");
	}
	
	public function getProductOptions($product_id) {
		$product_option_data = array();
		
		$product_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order");
		
		foreach ($product_option_query->rows as $product_option) {
			$product_option_value_data = array();
			
			$product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "' ORDER BY sort_order");
			
			foreach ($product_option_value_query->rows as $product_option_value) {
				$product_option_value_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value_description WHERE product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
			
				$product_option_value_data[] = array(
					'product_option_value_id' => $product_option_value['product_option_value_id'],
					'name'                    => $product_option_value_description_query->row['name'],
         			'price'                   => $product_option_value['price'],
         			'prefix'                  => $product_option_value['prefix']
				);
			}
						
			$product_option_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_description WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
						
        	$product_option_data[] = array(
        		'product_option_id' => $product_option['product_option_id'],
				'name'              => $product_option_description_query->row['name'],
				'option_value'      => $product_option_value_data,
				'sort_order'        => $product_option['sort_order']
        	);
      	}	
		
		return $product_option_data;
	}
	
	public function getProductImages($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");

		return $query->rows;
	}
	
	public function getProductVideos($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_video WHERE product_id = '" . (int)$product_id . "'");

		return $query->rows;
	}
	
	public function getProductDiscount($product_id) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
		
		$query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND quantity = '1' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");
		
		if ($query->num_rows) {
			return $query->row['price'];
		} else {
			return FALSE;
		}
	}

	public function getProductDiscounts($product_id) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND quantity > 1 AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity ASC, priority ASC, price ASC");

		return $query->rows;		
	}
	
	public function getProductSpecial($product_id) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
		
		$query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");
		
		if ($query->num_rows) {
			return $query->row['price'];
		} else {
			return FALSE;
		}
	}
	
	public function getProductSpecials($sort = 'p.viewed', $order = 'DESC', $start = 0, $limit = 20) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}		

		$sql = "SELECT *, pd.name AS name, p.price, (SELECT ps2.price FROM " . DB_PREFIX . "product_special ps2 WHERE p.product_id = ps2.product_id AND ps2.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps2.date_start = '0000-00-00' OR ps2.date_start < NOW()) AND (ps2.date_end = '0000-00-00' OR ps2.date_end > NOW())) ORDER BY ps2.priority ASC, ps2.price ASC LIMIT 1) AS special, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_special ps ON (p.product_id = ps.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW())AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) AND ps.product_id NOT IN (SELECT pd2.product_id FROM " . DB_PREFIX . "product_discount pd2 WHERE p.product_id = pd2.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW()))) GROUP BY p.product_id";

		$sort_data = array(
			'pd.name',
			'p.viewed',
			'special',
			'rating'
		);
			
		if (in_array($sort, $sort_data)) {
			$sql .= " ORDER BY " . $sort;
		} else {
			$sql .= " ORDER BY p.viewed";
		}
			
		if ($order == 'DESC') {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		if ($start < 0) {
			$start = 0;
		}
		
		$sql .= " LIMIT " . (int)$start . "," . (int)$limit;

		$query = $this->db->query($sql);
		
		return $query->rows;
	}	

	public function getTotalProductSpecials() {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}		
		
		$query = $this->db->query("SELECT COUNT(DISTINCT ps.product_id) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_special ps ON (p.product_id = ps.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) AND ps.product_id NOT IN (SELECT pd2.product_id FROM " . DB_PREFIX . "product_discount pd2 WHERE p.product_id = pd2.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())))");
		
		if (isset($query->row['total'])) {
			return $query->row['total'];
		} else {
			return 0;	
		}
	}	

	public function getProductRelatedByCategoryId($product_id, $category_id, $sort = 'p.viewed', $order = 'DESC', $start = 0, $limit = 20) {
		$sql = "SELECT *, pd.name AS name, p.viewed, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "' AND p.product_id != '" . (int)$product_id . "'";

		$sort_data = array(
			'pd.name',
			'p.viewed',
			'p.price',
			'rating'
		);	
			
		if (in_array($sort, $sort_data)) {
			$sql .= " ORDER BY " . $sort;
		} else {
			$sql .= " ORDER BY p.viewed";	
		}
			
		if ($order == 'DESC') {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		if ($start < 0) {
			$start = 0;
		}
		
		$sql .= " LIMIT " . (int)$start . "," . (int)$limit;
		
		$query = $this->db->query($sql);
								  
		return $query->rows;
	} 
	
	public function getProductToCategory($product_id = 0) {
		$this->load->model('catalog/category');
		$result = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		$category_id = array();
		if (isset($result->rows)) {
			foreach($result->rows  as $row ) {
				$category = $this->model_catalog_category->getCategory($row['category_id']);
				if($category) {
					$path = $row['category_id'];
					while ($category['parent_id'] != 0) {
						$path = $category['parent_id'] . '_' . $path;
						$category = $this->model_catalog_category->getCategory($category['parent_id']);
					}
				}
				$category_id[] = array(
					'strlen_path'      => strlen($path),
					'category_id'      => $row['category_id']
				);
			}
			if ($category_id) {
				$categoryid =  max($category_id);
				return $categoryid['category_id'];
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	}
	public function getCategories($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		
		return $query->rows;
	}
	
	public function getProductPhukien($product_id) {
		$product_data = array();

		$product_phukien_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_phukien WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($product_phukien_query->rows as $result) { 
			$product_query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE p.product_id = '" . (int)$result['phukien_id'] . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");
			
			if ($product_query->num_rows) {
				$product_data[$result['phukien_id']] = $product_query->row;
			}
		}
		
		return $product_data;
	}
	
	public function getProductsByphanloaiId($phanloai_id, $category_id, $sort = 'p.viewed', $order = 'DESC', $start = 0, $limit = 20) {
		$sql = "SELECT *, pd.name AS name, p.viewed, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) LEFT JOIN " . DB_PREFIX . "product_to_phanloai p2p ON (p.product_id = p2p.product_id) LEFT JOIN " . DB_PREFIX . " product_to_category p2c ON (p.product_id = p2c.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2p.phanloai_id = '" . (int)$phanloai_id . "' AND p2c.category_id = '" . (int)$category_id . "'";

		$sort_data = array(
			'pd.name',
			'p.viewed',
			'p.price',
			'rating'
		);	
			
		if (in_array($sort, $sort_data)) {
			$sql .= " ORDER BY " . $sort;
		} else {
			$sql .= " ORDER BY p.viewed";	
		}
			
		if ($order == 'DESC') {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		if ($start < 0) {
			$start = 0;
		}
		
		$sql .= " LIMIT " . (int)$start . "," . (int)$limit;
		
		$query = $this->db->query($sql);
								  
		return $query->rows;
	} 

	public function getTotalProductsByphanloaiId($phanloai_id = 0, $category_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_phanloai p2p LEFT JOIN " . DB_PREFIX . "product p ON (p2p.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . " product_to_category p2c ON (p.product_id = p2c.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2p.phanloai_id = '" . (int)$phanloai_id . "' AND p2c.category_id = '" . (int)$category_id . "'");

		return $query->row['total'];
	}
	
	public function getPhanloais($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_phanloai WHERE product_id = '" . (int)$product_id . "'");
		
		return $query->rows;
	}
	
	public function getProductToPhanloai($product_id) {
		$result = $this->db->query("SELECT parent_id FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		return $result->rows;
	}
	
	public function getProductsByCategoryIdDonggia($category_id, $price = 0, $product_id, $limit = 20) {
		if($price <= 1000000) {
			$price_start = 0;
			$price_end   = 1000000;
		} elseif ($price > 1000000 && $price <= 3000000) {
			$price_start = $price - 900000;
			$price_end   = $price + 1000000;
		} elseif ($price > 3000000 && $price <= 6000000) {
			$price_start = $price - 1500000;
			$price_end   = $price + 1500000;
		} elseif ($price > 6000000 && $price <= 10000000) {
			$price_start = $price - 1800000;
			$price_end   = $price + 1800000;
		} elseif ($price > 10000000 && $price <= 15000000) {
			$price_start = $price - 2000000;
			$price_end   = $price + 2000000;
		} elseif ($price > 15000000 && $price <= 25000000) {
			$price_start = $price - 3000000;
			$price_end   = $price + 3000000;
		} elseif ($price > 25000000 && $price <= 50000000) {
			$price_start = $price - 5000000;
			$price_end   = $price + 5000000;
		} elseif ($price > 50000000) {
			$price_start = $price - 10000000;
			$price_end   = $price + 10000000;
		}

		$sql = "SELECT *, pd.name AS name, p.sort_order, p.image, p.price, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE p.price >= '" . (int)$price_start . "' AND p.price <= '" . (int)$price_end . "' AND p.product_id != '" . (int)$product_id . "' AND p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "' ORDER BY p.price LIMIT " . (int)$limit;
		
		$query = $this->db->query($sql);
								  
		return $query->rows;
	}
}
?>