<?php
class ModelCatalogdanhmuchome extends Model {
	public function getdanhmuchome($danhmuchome_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "danhmuchome WHERE danhmuchome_id = '" . (int)$danhmuchome_id . "'");
	
		return $query->row;	
	}
	
	public function getdanhmuchomes() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "danhmuchome ORDER BY sort_order");
		 
		return $query->rows;
	} 
}
?>