<?php
class ModelAccountNewsletter extends Model {
	public function addNewsletter($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "newsletter SET gender = '" . $this->db->escape($data['gender']) . "', email = '" . $this->db->escape($data['email']) . "', date_added = NOW()");
	}
	
	public function getTotalNewslettersByEmail($email) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "newsletter WHERE email = '" . $this->db->escape($email) . "'");
		
		return $query->row['total'];
	}
}
?>