<?php
class ModelCatalogProduct extends Model {
	public function addProduct($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "product SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', stock_status_id_hc = '" . (int)$data['stock_status_id_hc'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', price_hc = '" . (float)$data['price_hc'] . "', total_promotion = '" . (int)$data['total_promotion'] . "', total_promotion_hc = '" . (int)$data['total_promotion_hc'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', measurement_class_id = '" . (int)$data['measurement_class_id'] . "', status = '" . (int)$data['status'] . "', warranty = '" . (int)$data['warranty'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', template = '" . $this->db->escape($data['template']) . "', date_added = NOW()");
		
		$product_id = $this->db->getLastId();
		
		if (isset($data['image'])) {
			$first_img = $this->db->escape($data['image']);
			$checkurl = str_replace(HTTP_CATALOG,' dunglalinkdomain ',$first_img);
			if(strpos($checkurl,'dunglalinkdomain')) {
				$first_img = str_replace(HTTP_IMAGE,'',$first_img);
			}
			
			$this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $first_img . "' WHERE product_id = '" . (int)$product_id . "'");
		}
		
		foreach ($data['product_description'] as $language_id => $value) {
		
			$this->load->model('tool/downloadimage');
			
			$description = preg_replace("/<\\/?a(\\s+.*?>|>)/", "", html_entity_decode($value['description'], ENT_QUOTES, 'UTF-8'));
			$brief_description = preg_replace("/<\\/?a(\\s+.*?>|>)/", "", html_entity_decode($value['brief_description'], ENT_QUOTES, 'UTF-8'));
			$technical_description = preg_replace("/<\\/?a(\\s+.*?>|>)/", "", html_entity_decode($value['technical_description'], ENT_QUOTES, 'UTF-8'));
				
			if($value['description']) {				
				$description = $this->model_tool_downloadimage->downloadImage($description, $product_id, 'product', false, 'img');
			}
			
			if($value['brief_description']) {			
				$brief_description = $this->model_tool_downloadimage->downloadImage($brief_description, $product_id, 'product', false, 'bdimg');
			}
			
			if($value['technical_description']) {		
				$technical_description = $this->model_tool_downloadimage->downloadImage($technical_description, $product_id, 'product', false, 'tdimg');
			}
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', name_seo = '" . $this->db->escape($value['name_seo']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($description) . "', brief_description = '" . $this->db->escape($brief_description) . "', technical_description = '" . $this->db->escape($technical_description) . "', promotion = '" . $this->db->escape($value['promotion']) . "', promotion_hc = '" . $this->db->escape($value['promotion_hc']) . "', tags = '" . $this->db->escape($value['tags'])  . "'");
		}
		
		if (isset($data['product_option'])) {
			foreach ($data['product_option'] as $product_option) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', sort_order = '" . (int)$product_option['sort_order'] . "', color_status = '" . (int)$product_option['color_status'] . "'");
				
				$product_option_id = $this->db->getLastId();
				
				foreach ($product_option['language'] as $language_id => $language) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_description SET product_option_id = '" . (int)$product_option_id . "', language_id = '" . (int)$language_id . "', product_id = '" . (int)$product_id . "', name = '" . $this->db->escape($language['name']) . "'");
				}				
				
				if (isset($product_option['product_option_value'])) {
					foreach ($product_option['product_option_value'] as $product_option_value) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', prefix = '" . $this->db->escape($product_option_value['prefix']) . "', sort_order = '" . (int)$product_option_value['sort_order'] . "', color_id = '" . (int)$product_option_value['color_id'] . "'");
				
						$product_option_value_id = $this->db->getLastId();
				
						foreach ($product_option_value['language'] as $language_id => $language) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value_description SET product_option_value_id = '" . (int)$product_option_value_id . "', language_id = '" . (int)$language_id . "', product_id = '" . (int)$product_id . "', name = '" . $this->db->escape($language['name']) . "'");
						}					
					}
				}
			}
		}
		
		if (isset($data['product_discount'])) {
			foreach ($data['product_discount'] as $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$value['customer_group_id'] . "', quantity = '" . (int)$value['quantity'] . "', priority = '" . (int)$value['priority'] . "', price = '" . (float)$value['price'] . "', date_start = '" . $this->db->escape($value['date_start']) . "', date_end = '" . $this->db->escape($value['date_end']) . "'");
			}
		}

		if (isset($data['product_special'])) {
			foreach ($data['product_special'] as $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$value['customer_group_id'] . "', priority = '" . (int)$value['priority'] . "', price = '" . (float)$value['price'] . "', date_start = '" . $this->db->escape($value['date_start']) . "', date_end = '" . $this->db->escape($value['date_end']) . "'");
			}
		}
		
		if (isset($data['product_image'])) {
			foreach ($data['product_image'] as $value) {
				$first_img = $this->db->escape($value['image']);
				$checkurl = str_replace(HTTP_CATALOG,' dunglalinkdomain ',$first_img);
				if(strpos($checkurl,'dunglalinkdomain')) {
					$first_img = str_replace(HTTP_IMAGE,'',$first_img);
				}
				
        		$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $first_img . "', color_id = '" . (int)$value['color_id'] . "', title_image = '" . $this->db->escape($value['title_image']) . "', description_image = '" . $this->db->escape($value['description_image']) . "', slide_status = '" . (int)$value['slide_status'] . "', sort_order = '" . (int)$value['sort_order'] . "'");
			}
		}
		
		if (isset($data['product_video'])) {
			foreach ($data['product_video'] as $video) {
        		$this->db->query("INSERT INTO " . DB_PREFIX . "product_video SET product_id = '" . (int)$product_id . "', video = '" . $this->db->escape($video) . "'");
			}
		}
		
		if (isset($data['product_download'])) {
			foreach ($data['product_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
			}
		}
		
		if (isset($data['product_category'])) {
			$i = 0;
			foreach ($data['product_category'] as $category_id) {
				$i++;
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
				
				if ($i == sizeof($data['product_category'])) {
					$this->db->query("UPDATE " . DB_PREFIX . "product SET category_id = '" . (int)$category_id . "' WHERE product_id = '" . (int)$product_id . "'");
				}
			}		
		}
		
		if (isset($data['product_chome'])) {
			$parent_id = "";
			foreach ($data['product_chome'] as $chome_id) {
				$parent_id = $parent_id . (int)$category_id . "_";
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_chome SET product_id = '" . (int)$product_id . "', chome_id = '" . (int)$chome_id . "'");
			}
		}
		
		if (isset($data['product_phukien'])) {
			foreach ($data['product_phukien'] as $phukien_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_phukien SET product_id = '" . (int)$product_id . "', phukien_id = '" . (int)$phukien_id . "'");
			}
		}
		
		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
			}
		}
		
		if (isset($data['product_phanloai'])) {
			$phanloai = "pl";
			foreach ($data['product_phanloai'] as $phanloai_id) {
				$pl = '';
				if($phanloai_id < 10) {
					$pl = '00' . $phanloai_id;
				} elseif($phanloai_id < 100 && $phanloai_id >= 10) {
					$pl = '0' . $phanloai_id;
				} else {
					$pl = $phanloai_id;
				}
				$phanloai .= "_" . $pl;
				
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_phanloai SET product_id = '" . (int)$product_id . "', phanloai_id = '" . (int)$phanloai_id . "'");
			}
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_search_phanloai SET product_id = '" . (int)$product_id . "', plid = '" . $this->db->escape($phanloai) . "'");
		}
		
		if (isset($data['product_attribute'])) {
			foreach ($data['product_attribute'] as $value) {
        		$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$value['attribute_id'] . "', text = '" . $value['text'] . "'");
			}
		}
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "history SET user_id = '" . (int)$this->user->getId() . "', username = '" . $this->db->escape($this->user->getUserName()) . "', generic = 'product_add', code = 'product_id=" . (int)$product_id . "', date_added = NOW()");
		
		$this->cache->delete('product');
	}
	
	public function editProduct($product_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "product SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', stock_status_id_hc = '" . (int)$data['stock_status_id_hc'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', price_hc = '" . (float)$data['price_hc'] . "', total_promotion = '" . (int)$data['total_promotion'] . "', total_promotion_hc = '" . (int)$data['total_promotion_hc'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', measurement_class_id = '" . (int)$data['measurement_class_id'] . "', status = '" . (int)$data['status'] . "', warranty = '" . (int)$data['warranty'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', template = '" . $this->db->escape($data['template']) . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['image'])) {
			$first_img = $this->db->escape($data['image']);
			$checkurl = str_replace(HTTP_CATALOG,' dunglalinkdomain ',$first_img);
			if(strpos($checkurl,'dunglalinkdomain')) {
				$first_img = str_replace(HTTP_IMAGE,'',$first_img);
			}
			
			$this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $first_img . "' WHERE product_id = '" . (int)$product_id . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($data['product_description'] as $language_id => $value) {
			
			$this->load->model('tool/downloadimage');
			
			$description = preg_replace("/<\\/?a(\\s+.*?>|>)/", "", html_entity_decode($value['description'], ENT_QUOTES, 'UTF-8'));
			$brief_description = preg_replace("/<\\/?a(\\s+.*?>|>)/", "", html_entity_decode($value['brief_description'], ENT_QUOTES, 'UTF-8'));
			$technical_description = preg_replace("/<\\/?a(\\s+.*?>|>)/", "", html_entity_decode($value['technical_description'], ENT_QUOTES, 'UTF-8'));
			
			$product_info = $this->getProduct($product_id);
			
			if($product_info) { $date_added = $product_info['date_added']; } else { $date_added = false; }
				
			if($value['description']) {
				$description = $this->model_tool_downloadimage->downloadImage($description, $product_id, 'product',$date_added, 'img');
			}
			
			if($value['brief_description']) {			
				$brief_description = $this->model_tool_downloadimage->downloadImage($brief_description, $product_id, 'product',$date_added, 'bdimg');
			}
			
			if($value['technical_description']) {		
				$technical_description = $this->model_tool_downloadimage->downloadImage($technical_description, $product_id, 'product',$date_added, 'tdimg');
			}
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', name_seo = '" . $this->db->escape($value['name_seo']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($description) . "', brief_description = '" . $this->db->escape($brief_description) . "', technical_description = '" . $this->db->escape($technical_description) . "', promotion = '" . $this->db->escape($value['promotion']) . "', promotion_hc = '" . $this->db->escape($value['promotion_hc']) . "', tags = '" . $this->db->escape($value['tags'])  . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_description WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value_description WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_option'])) {
			foreach ($data['product_option'] as $product_option) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', sort_order = '" . (int)$product_option['sort_order'] . "', color_status = '" . (int)$product_option['color_status'] . "'");
				
				$product_option_id = $this->db->getLastId();
				
				foreach ($product_option['language'] as $language_id => $language) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_description SET product_option_id = '" . (int)$product_option_id . "', language_id = '" . (int)$language_id . "', product_id = '" . (int)$product_id . "', name = '" . $this->db->escape($language['name']) . "'");
				}				
				
				if (isset($product_option['product_option_value'])) {
					foreach ($product_option['product_option_value'] as $product_option_value) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', prefix = '" . $this->db->escape($product_option_value['prefix']) . "', sort_order = '" . (int)$product_option_value['sort_order'] . "', color_id = '" . (int)$product_option_value['color_id'] . "'");
				
						$product_option_value_id = $this->db->getLastId();
				
						foreach ($product_option_value['language'] as $language_id => $language) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value_description SET product_option_value_id = '" . (int)$product_option_value_id . "', language_id = '" . (int)$language_id . "', product_id = '" . (int)$product_id . "', name = '" . $this->db->escape($language['name']) . "'");
						}					
					}
				}
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_discount'])) {
			foreach ($data['product_discount'] as $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$value['customer_group_id'] . "', quantity = '" . (int)$value['quantity'] . "', priority = '" . (int)$value['priority'] . "', price = '" . (float)$value['price'] . "', date_start = '" . $this->db->escape($value['date_start']) . "', date_end = '" . $this->db->escape($value['date_end']) . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_special'])) {
			foreach ($data['product_special'] as $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$value['customer_group_id'] . "', priority = '" . (int)$value['priority'] . "', price = '" . (float)$value['price'] . "', date_start = '" . $this->db->escape($value['date_start']) . "', date_end = '" . $this->db->escape($value['date_end']) . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_image'])) {
			foreach ($data['product_image'] as $value) {
				$first_img = $this->db->escape($value['image']);
				$checkurl = str_replace(HTTP_CATALOG,' dunglalinkdomain ',$first_img);
				if(strpos($checkurl,'dunglalinkdomain')) {
					$first_img = str_replace(HTTP_IMAGE,'',$first_img);
				}
				
        		$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $first_img . "', color_id = '" . (int)$value['color_id'] . "', title_image = '" . $this->db->escape($value['title_image']) . "', description_image = '" . $this->db->escape($value['description_image']) . "', slide_status = '" . (int)$value['slide_status'] . "', sort_order = '" . (int)$value['sort_order'] . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_video WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_video'])) {
			foreach ($data['product_video'] as $video) {
        		$this->db->query("INSERT INTO " . DB_PREFIX . "product_video SET product_id = '" . (int)$product_id . "', video = '" . $this->db->escape($video) . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_download'])) {
			foreach ($data['product_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_category'])) {
			$i = 0;
			foreach ($data['product_category'] as $category_id) {
				$i++;
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
				
				if ($i == sizeof($data['product_category'])) {
					$this->db->query("UPDATE " . DB_PREFIX . "product SET category_id = '" . (int)$category_id . "' WHERE product_id = '" . (int)$product_id . "'");
				}
			}		
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_chome WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_chome'])) {
			$parent_id = "";
			foreach ($data['product_chome'] as $chome_id) {
				$parent_id = $parent_id . (int)$category_id . "_";
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_chome SET product_id = '" . (int)$product_id . "', chome_id = '" . (int)$chome_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_phukien WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_phukien'])) {
			foreach ($data['product_phukien'] as $phukien_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_phukien SET product_id = '" . (int)$product_id . "', phukien_id = '" . (int)$phukien_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_phanloai WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_search_phanloai WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_phanloai'])) {
			$phanloai = "pl";
			foreach ($data['product_phanloai'] as $phanloai_id) {
				$pl = '';
				if($phanloai_id < 10) {
					$pl = '00' . $phanloai_id;
				} elseif($phanloai_id < 100 && $phanloai_id >= 10) {
					$pl = '0' . $phanloai_id;
				} else {
					$pl = $phanloai_id;
				}
				$phanloai .= "_" . $pl;
				
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_phanloai SET product_id = '" . (int)$product_id . "', phanloai_id = '" . (int)$phanloai_id . "'");
			}
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_search_phanloai SET product_id = '" . (int)$product_id . "', plid = '" . $this->db->escape($phanloai) . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_attribute'])) {
			foreach ($data['product_attribute'] as $value) {
        		$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$value['attribute_id'] . "', text = '" . $value['text'] . "'");
			}
		}
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "history SET user_id = '" . (int)$this->user->getId() . "', username = '" . $this->db->escape($this->user->getUserName()) . "', generic = 'product_edit', code = 'product_id=" . (int)$product_id . "', date_added = NOW()");
		
		$this->cache->delete('product');
	}

	public function deleteProduct($product_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_description WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value_description WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_video WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_phukien WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_chome WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_phanloai WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_search_phanloai WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE product_id = '" . (int)$product_id . "'");
		
		$this->cache->delete('product');
	}
	
	public function copyProduct($product_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data['viewed'] = '0';
			$data['status'] = '1';
						
			$data = array_merge($data, array('product_description' => $this->getProductDescriptions($product_id)));			
			$data = array_merge($data, array('product_discount' => $this->getProductDiscounts($product_id)));
			$data = array_merge($data, array('product_image' => $this->getProductImages($product_id)));
			$data = array_merge($data, array('product_video' => $this->getProductVideos($product_id)));	
			$data = array_merge($data, array('product_option' => $this->getProductOptions($product_id)));
			$data = array_merge($data, array('product_related' => $this->getProductRelated($product_id)));
			$data = array_merge($data, array(' product_phukien' => $this->getProductPhukien($product_id)));
			$data = array_merge($data, array('product_special' => $this->getProductSpecials($product_id)));
			$data = array_merge($data, array('product_category' => $this->getProductCategories($product_id)));
			$data = array_merge($data, array('product_attribute' => $this->getProductAttributes($product_id)));
			$data = array_merge($data, array('product_to_phanloai' => $this->getProductPhanloais($product_id)));
			$data = array_merge($data, array('product_search_phanloai_data' => $this->getProductSearchPhanloais($product_id)));
			 
			$this->addProduct($data);
		}
	}
	
	public function getProduct($product_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
				
		return $query->row;
	}
	
	public function getProducts($data = array()) {
		if ($data) {
			// phân loại danh mục và giá model/product, catalog/product, product.tpl, header.tpl
			$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";
			
			if (isset($data['cat_id']) && $data['cat_id'] != 0 ) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category ph ON (p.product_id = ph.product_id)";
			}

			$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
			if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
				$sql .= " AND pd.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
			}

			if (isset($data['filter_model']) && !is_null($data['filter_model'])) {
				$sql .= " AND p.model LIKE '%" . $this->db->escape($data['filter_model']) . "%'";
			}
			
			if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
				$sql .= " AND p.quantity = '" . $this->db->escape($data['filter_quantity']) . "'";
			}
			
			if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
				$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
			}
			
            if (isset($data['cat_id']) && $data['cat_id'] != 0 ) {
			
				$checkmanu = str_replace('_',' comanu ',$data['cat_id']);
				
				if(strpos($checkmanu,'comanu')) {
				
					$cat_info =  explode('_', $data['cat_id']);
					
					if(isset($cat_info[1])) {
				
						$sql .= " AND ph.category_id = '" . (int)$data['cat_id'] . "' AND p.manufacturer_id = '" . (int)$cat_info[1] . "'";
					}
				
				} else {
				
					$sql .= " AND ph.category_id = '" . (int)$data['cat_id'] . "'";
				}
			}

			$sort_data = array(
				'pd.name',
				'p.model',
				'p.quantity',
				'p.status',
				'p.sort_order'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY p.product_id";	
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
			$product_data = $this->cache->get('product.' . $this->config->get('config_language_id'));
		
			if (!$product_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY p.product_id ASC");
	
				$product_data = $query->rows;
			
				$this->cache->set('product.' . $this->config->get('config_language_id'), $product_data);
			}	
	
			return $product_data;
		}
	}
	public function getProductsByCategoryId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "' ORDER BY pd.name ASC");
								  
		return $query->rows;
	} 
	
	public function getProductsByPhanloaiId($phanloai_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_phanloai p2p ON (p.product_id = p2p.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2p.phanloai_id = '" . (int)$phanloai_id . "' ORDER BY pd.name ASC");
								  
		return $query->rows;
	} 
	
	public function getProductDescriptions($product_id) {
		$product_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_description_data[$result['language_id']] = array(
				'name'             		=> $result['name'],
				'name_seo'             	=> $result['name_seo'],
				'promotion'        		=> $result['promotion'],
				'promotion_hc'          => $result['promotion_hc'],
				'tags'             		=> $result['tags'],
				'brief_description'     => $result['brief_description'],
				'technical_description' => $result['technical_description'],
				'meta_description' 		=> $result['meta_description'],
				'description'      		=> $result['description']
			);
		}
		
		return $product_description_data;
	}
	
	public function getProductOptions($product_id) {
		$product_option_data = array();
		
		$product_option = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order");
		
		foreach ($product_option->rows as $product_option) {
			$product_option_value_data = array();
			
			$product_option_value = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "' ORDER BY sort_order");
			
			foreach ($product_option_value->rows as $product_option_value) {
				$product_option_value_description_data = array();
				
				$product_option_value_description = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value_description WHERE product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "'");

				foreach ($product_option_value_description->rows as $result) {
					$product_option_value_description_data[$result['language_id']] = array('name' => $result['name']);
				}
			
				$product_option_value_data[] = array(
					'product_option_value_id' => $product_option_value['product_option_value_id'],
					'language'                => $product_option_value_description_data,
         			'quantity'                => $product_option_value['quantity'],
					'subtract'                => $product_option_value['subtract'],
					'price'                   => $product_option_value['price'],
         			'prefix'                  => $product_option_value['prefix'],
					'sort_order'              => $product_option_value['sort_order'],
					'color_id'                => $product_option_value['color_id']
				);
			}
			
			$product_option_description_data = array();
			
			$product_option_description = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_description WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "'");

			foreach ($product_option_description->rows as $result) {
				$product_option_description_data[$result['language_id']] = array('name' => $result['name']);
			}
		
        	$product_option_data[] = array(
        		'product_option_id'    => $product_option['product_option_id'],
				'language'             => $product_option_description_data,
				'product_option_value' => $product_option_value_data,
				'sort_order'           => $product_option['sort_order'],
				'color_status'         => $product_option['color_status']
        	);
      	}	
		
		return $product_option_data;
	}
	
	public function getProductImages($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
		
		return $query->rows;
	}
	
	public function getProductVideos($product_id) {
		$product_video_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_video WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_video_data[] = $result['video'];
		}
		
		return $product_video_data;
	}
	
	public function getProductVideos1($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_video WHERE product_id = '" . (int)$product_id . "'");
		
		return $query->rows;
	}
	
	public function getProductDiscounts($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' ORDER BY quantity, priority, price");
		
		return $query->rows;
	}
	
	public function getProductSpecials($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' ORDER BY priority, price");
		
		return $query->rows;
	}
	
	public function getProductDownloads($product_id) {
		$product_download_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_download_data[] = $result['download_id'];
		}
		
		return $product_download_data;
	}

	public function getProductCategories($product_id) {
		$product_category_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_category_data[] = $result['category_id'];
		}

		return $product_category_data;
	}
	
	public function getProductChomes($product_id) {
		$product_chome_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_chome WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_chome_data[] = $result['chome_id'];
		}

		return $product_chome_data;
	}
	
	public function getProductCategoryId($product_id) {

		$query = $this->db->query("SELECT DISTINCT *, c.category_id AS category_id FROM " . DB_PREFIX . "product_to_category p2c LEFT JOIN " . DB_PREFIX . "category c ON (c.category_id = p2c.category_id) WHERE p2c.product_id = '" . (int)$product_id . "' AND c.parent_id = '0'");

		return $query->row;
	}
	
	public function getProductPhukien($product_id) {
		$product_phukien_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_phukien WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_phukien_data[] = $result['phukien_id'];
		}
		
		return $product_phukien_data;
	}

	public function getProductRelated($product_id) {
		$product_related_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_related_data[] = $result['related_id'];
		}
		
		return $product_related_data;
	}
	
	public function getProductPhanloais($product_id) {
		$product_phanloai_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_phanloai WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_phanloai_data[] = $result['phanloai_id'];
		}

		return $product_phanloai_data;
	}
	
	public function getProductSearchPhanloais($product_id) {
		$product_search_phanloai_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_search_phanloai WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_search_phanloai_data[] = $result['plid'];
		}

		return $product_search_phanloai_data;
	}
	
	public function getProductAttributes($product_id) {
		$product_attribute_data = array();

		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product_attribute pa WHERE pa.product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_attribute_data[] = array(
				'attribute_id' => $result['attribute_id'],
				'text' => $result['text']
			);
		}

		return $product_attribute_data;
	}
	
	public function getProductAttributeId($product_id,$attribute_id) {

		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product_attribute pa WHERE pa.product_id = '" . (int)$product_id . "' AND pa.attribute_id = '" . (int)$attribute_id . "'");

		return $query->row;
	}
	
	public function getTotalProducts($data = array()) {
		// phân loại danh mục và giá model/product, catalog/product, product.tpl, header.tpl
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";

		if (isset($data['cat_id']) && $data['cat_id'] != 0 ) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category ph ON (p.product_id = ph.product_id)";
		}
		
		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_model']) && !is_null($data['filter_model'])) {
			$sql .= " AND p.model LIKE '%" . $this->db->escape($data['filter_model']) . "%'";
		}
		
		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
			$sql .= " AND p.quantity = '" . $this->db->escape($data['filter_quantity']) . "'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}
		
		if (isset($data['cat_id']) && $data['cat_id'] != 0 ) {
		
			$checkmanu = str_replace('_',' comanu ',$data['cat_id']);
			
			if(strpos($checkmanu,'comanu')) {
			
				$cat_info =  explode('_', $data['cat_id']);
				
				if(isset($cat_info[1])) {
			
					$sql .= " AND ph.category_id = '" . (int)$data['cat_id'] . "' AND p.manufacturer_id = '" . (int)$cat_info[1] . "'";
				}
			
			} else {
			
				$sql .= " AND ph.category_id = '" . (int)$data['cat_id'] . "'";
			}
		}

		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}	
	
	public function getTotalProductsByStockStatusId($stock_status_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE stock_status_id = '" . (int)$stock_status_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalProductsByImageId($image_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE image_id = '" . (int)$image_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalProductsByTaxClassId($tax_class_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE tax_class_id = '" . (int)$tax_class_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalProductsByWeightClassId($weight_class_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE weight_class_id = '" . (int)$weight_class_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalProductsByMeasurementClassId($measurement_class_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE measurement_class_id = '" . (int)$measurement_class_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalProductsByOptionId($option_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_option WHERE option_id = '" . (int)$option_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByDownloadId($download_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_download WHERE download_id = '" . (int)$download_id . "'");
		
		return $query->row['total'];
	}
	
	public function getTotalProductsByManufacturerId($manufacturer_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalProductsBychomeId($chome_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE chome_id = '" . (int)$chome_id . "'");

		return $query->row['total'];
	}
	
	public function updateProPrice($pro_id, $price){
		$listprice = str_split($price);      
		$prorprice = ""; 
		foreach($listprice as $row){
			if(is_numeric($row)){ 
			$prorprice  .= intval($row);
			}
		}
		
		$this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . (int)$prorprice . "' WHERE product_id = '" . (int)$pro_id . "'");
	}
	
	public function updateProPriceHc($pro_id, $price){
		$listprice = str_split($price);      
		$prorprice = ""; 
		foreach($listprice as $row){
			if(is_numeric($row)){ 
			$prorprice  .= intval($row);
			}
		}
		
		$this->db->query("UPDATE " . DB_PREFIX . "product SET price_hc = '" . (int)$prorprice . "' WHERE product_id = '" . (int)$pro_id . "'");
	}
}
?>