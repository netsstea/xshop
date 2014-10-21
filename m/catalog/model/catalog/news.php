<?php
class ModelCatalogNews extends Model {
	public function getnews($news_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "news i LEFT JOIN " . DB_PREFIX . "news_description id ON (i.news_id = id.news_id) WHERE i.news_id = '" . (int)$news_id . "' AND id.language_id = '" . (int)$this->config->get('config_language_id') . "'");
	
		return $query->row;
	}

	public function getnewss($start = 0, $limit = 20) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news i LEFT JOIN " . DB_PREFIX . "news_description id ON (i.news_id = id.news_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY i.date_added DESC " . " LIMIT " . (int)$start . "," . (int)$limit);
	
		return $query->rows;
	}
	public function gettotalnewss() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news");
		
		return $query->row['total'];
	}
	public function tinmoinhat($limit) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news i LEFT JOIN " . DB_PREFIX . "news_description id ON (i.news_id = id.news_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY i.date_added DESC LIMIT " . (int)$limit);
	
		return $query->rows;
	}
	public function getnewssbyCatalogs($category_news_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news i LEFT JOIN " . DB_PREFIX . "news_description id ON (i.news_id = id.news_id) LEFT JOIN " . DB_PREFIX . "news_to_category m ON (i.news_id = m.news_id) WHERE m.category_news_id =".$category_news_id." ORDER BY i.date_added DESC");
		
		return $query->rows;
	}
	public function getnewssbySortOrder($sort_order,$start,$limit) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) WHERE n.sort_order = " . $sort_order . " ORDER BY n.date_added DESC LIMIT " . (int)$start . "," . $limit);
		
		return $query->rows;
	}
	public function getnewssbyCatalog($category_news_id, $start = 0, $limit = 20) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news i LEFT JOIN " . DB_PREFIX . "news_description id ON (i.news_id = id.news_id) LEFT JOIN " . DB_PREFIX . "news_to_category m ON (i.news_id = m.news_id) WHERE m.category_news_id =".$category_news_id." ORDER BY i.date_added DESC" . " LIMIT " . (int)$start . "," . (int)$limit);
		
		return $query->rows;
	}
	public function getnewsslienquanbyCatalog($category_news_id, $start, $limit) {
	if (isset($this->request->get['news_id'])) {
		$news_id = $this->request->get['news_id'];
	} else {
		$news_id = 0;
	}
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news i LEFT JOIN " . DB_PREFIX . "news_description id ON (i.news_id = id.news_id) LEFT JOIN " . DB_PREFIX . "news_to_category m ON (i.news_id = m.news_id) WHERE m.category_news_id =".$category_news_id." AND i.news_id != " .$news_id. " ORDER BY i.date_added DESC" . " LIMIT " . (int)$start . "," . (int)$limit);
		
		return $query->rows;
	}
	public function getTotalnewsByCategoryId($category_news_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news i LEFT JOIN " . DB_PREFIX . "news_description id ON (i.news_id = id.news_id) LEFT JOIN " . DB_PREFIX . "news_to_category m ON (i.news_id = m.news_id) WHERE m.category_news_id =".$category_news_id." ORDER BY i.date_added ASC");

		return $query->row['total'];
	}
	public function getcategoryRelated($news_id) {

		$result = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_to_category WHERE news_id = '" . (int)$news_id . "'");
		if (isset($result->rows)) {
			foreach($result->rows  as $row ) {
				if(!strpos($row['parent_news_id'],"_")){
					return $row['category_news_id'];
				}
			}
		} else {
			return 0;	
		}
	
	}
	public function getNewsToCategory($news_id) {
		$product_data = array();

		$result = $this->db->query("SELECT parent_news_id FROM " . DB_PREFIX . "news_to_category WHERE news_id = '" . (int)$news_id . "'");
		$parent_news_id = array();
		if (isset($result->rows)) {
			foreach($result->rows  as $row ) {
				$parent_news_id[] = array($row['parent_news_id']);
			}
			if ($parent_news_id) {
			return max($parent_news_id);
			} else {
			return 0;
			}
		} else {
			return 0;
		}
	}	
}
?>