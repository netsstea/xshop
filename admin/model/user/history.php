<?php
class ModelUserHistory extends Model {
	public function addHistory($generic, $code) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "history SET user_id = '" . (int)$this->user->getId() . "', username = '" . $this->db->escape($this->user->getUserName()) . "', generic = '" . $this->db->escape($generic) . "', code = '" . $this->db->escape($code) . "', date_added = NOW()");
	}
	
	public function deleteHistory($history_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "history` WHERE history_id = '" . (int)$history_id . "'");
	}
	
	public function getHistoris($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "history`";
			
		$sql .= " ORDER BY history_id";
			
		$sql .= " DESC";
		
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
	}

	public function getTotalHistoris() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "history`");
		
		return $query->row['total'];
	}
}
