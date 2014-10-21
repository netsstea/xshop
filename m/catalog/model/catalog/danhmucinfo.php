<?php
class ModelCatalogdanhmucinfo extends Model {
	public function getdanhmucinfo($danhmucinfo_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "danhmucinfo WHERE danhmucinfo_id = '" . (int)$danhmucinfo_id . "'");
	
		return $query->row;	
	}
	
	public function getdanhmucinfos($limit) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "danhmucinfo WHERE sort_order != 100 ORDER BY sort_order ASC LIMIT " . (int)$limit);
			$danhmucinfo = $query->rows;
		return $danhmucinfo;
	}
	
	public function getdanhmucinfos100($limit) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "danhmucinfo WHERE sort_order = 100 ORDER BY sort_order ASC LIMIT " . (int)$limit);
			$danhmucinfo = $query->rows;
		return $danhmucinfo;
	} 
}
?>