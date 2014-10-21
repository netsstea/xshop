<?php
final class Zone {
  	private $code;
  	private $zones = array();
  
  	public function __construct() {
		$this->config = Registry::get('config');
		$this->db = Registry::get('db');
		$this->language = Registry::get('language');
		$this->request = Registry::get('request');
		$this->session = Registry::get('session');
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone");

    	foreach ($query->rows as $result) {
      		$this->zones[$result['code']] = array(
        		'zone_id'      => $result['zone_id'],
        		'name'         => $result['name'],
				'code'         => $result['code']
      		); 
    	}

    	if ((isset($this->session->data['zone'])) && (array_key_exists($this->session->data['zone'], $this->zones))) {
      		$this->set($this->session->data['zone']);
    	} elseif ((isset($this->request->cookie['zone'])) && (array_key_exists($this->request->cookie['zone'], $this->zones))) {
      		$this->set($this->request->cookie['zone']);
    	} else {
      		$this->set($this->config->get('config_zone_code'));
    	}
  	}
	
  	public function set($zone) {
    	$this->code = $zone;

    	if ((!isset($this->session->data['zone'])) || ($this->session->data['zone'] != $zone)) {
      		$this->session->data['zone'] = $zone;
    	}

    	if ((!isset($this->request->cookie['zone'])) || ($this->request->cookie['zone'] != $zone)) {
	  		setcookie('zone', $zone, time() + 60 * 60 * 24 * 30, '/', $this->request->server['HTTP_HOST']);
    	}
  	}
	
  	public function getId() {
		return $this->zones[$this->code]['zone_id'];
  	}
	
  	public function getCode() {
    	return $this->code;
  	}
    
  	public function has($zone) {
    	return isset($this->zones[$zone]);
  	}
}
?>