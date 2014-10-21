<?php
class ModelSaleNewsletter extends Model {
	public function addNewsletter($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "newsletter SET gender = '" . $this->db->escape($data['gender']) . "', email = '" . $this->db->escape($data['email']) . "', date_added = NOW()");
	}
	
	public function editNewsletter($newsletter_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "newsletter SET email = '" . $this->db->escape($data['email']) . "', gender = '" . $this->db->escape($data['gender']) . "', date_added = NOW() WHERE newsletter_id = '" . (int)$newsletter_id . "'");
	}
	
	public function deleteNewsletter($newsletter_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "newsletter WHERE newsletter_id = '" . (int)$newsletter_id . "'");
	}
	
	public function getNewsletter($newsletter_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "newsletter WHERE newsletter_id = '" . (int)$newsletter_id . "'");
		
		return $query->row;
	}

	public function getNewsletters($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "newsletter";	
		
		$implode = array();
		
		if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
			$implode[] = "email = '" . $this->db->escape($data['filter_email']) . "'";
		}	
		
		if (isset($data['filter_gender']) && !is_null($data['filter_gender'])) {
			$implode[] = "gender = '" . $data['filter_gender'] . "'";
		}
		
		if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
		
		$sort_data = array(
			'gender',
			'email',
			'date_added'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY date_added";	
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
	}
	
	public function getTotalNewsletters() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "newsletter");
		
		return $query->row['total'];
	}
	
	public function getTotalNewslettersMale() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "newsletter WHERE gender = 'male'");
		
		return $query->row['total'];
	}
	
	public function getTotalNewslettersFamale() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "newsletter WHERE gender = 'famale'");
		
		return $query->row['total'];
	}
}
?>