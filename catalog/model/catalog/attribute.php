<?php
class ModelCatalogAttribute extends Model {
	public function getAttribute($attribute_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute WHERE attribute_id = '" . (int)$attribute_id . "'");

		return $query->row;
	}
	
	public function getAttributeGroupsByCategoryId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute_group ag WHERE ag.category_id LIKE '%" . (int)$category_id . "%' ORDER BY ag.sort_order");

		return $query->rows;
	}
	
	public function getAttributesByAttributeGroupId($attribute_group_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "attribute a WHERE a.attribute_group_id = '" . (int)$attribute_group_id . "' ORDER BY a.sort_order";			
		
		$query = $this->db->query($sql);
	
		return $query->rows;
	}
	
	public function getProductAttributeId($product_id,$attribute_id) {

		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product_attribute pa WHERE pa.product_id = '" . (int)$product_id . "' AND pa.attribute_id = '" . (int)$attribute_id . "'");

		return $query->row;
	}
	
	public function getAttributesByCategoryId($category_id, $product_id, $option = '') {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute_display ad WHERE ad.category_id LIKE '%" . (int)$category_id . "%' AND ad.ashow = '" . $option . "' ORDER BY ad.sort_order");
		
		$attributes = array();
		
		if (isset($query->rows)) {
			foreach ($query->rows as $attribute_data) {
				$attributeId_info = explode(',', $attribute_data['attribute_data']);
				$attributeId_text = '';
				foreach ($attributeId_info as $attribute_id) {
					$resultsAtt = $this->getProductAttributeId($product_id,$attribute_id);
					
					if($resultsAtt && $resultsAtt['text']) {
						if($attributeId_text) {
							$attributeId_text = $attributeId_text . ', ' . $resultsAtt['text'];
						} else {
							$attributeId_text = $resultsAtt['text'];
						}
					}
				}
				
				$attributes[] = array(
					'name' 		   => $attribute_data['name'],
					'text' 		   => $attributeId_text
				);
			}
		}

		return $attributes;
	}
}
?>