<?php
class ModelToolTime extends Model {
	public function timevn($date) {
		if(empty($date)) {
			return "No date provided";
		}
		$periods         = array("giây", "phút", "giờ", "ngày", "tuần", "tháng", "năm", "thập kỷ");
		$lengths         = array("60","60","24","7","4.35","12","10");

		$now             = time();
		$unix_date         = strtotime($date);

		   // check validity of date
		if(empty($unix_date)) {   
			return "Bad date";
		}

		// is it future date or past date
		if(abs($now - $unix_date) < 82740) {
			$difference    = abs($now - $unix_date);
			$tense         = "trước";
		} elseif(abs($now - $unix_date) > 82740 && abs($now - $unix_date) < 169140) {
			$difference    = 0;
			$tense         = "hôm qua lúc " . date('H:m',$unix_date);
		} else {
			$difference    = abs($now - $unix_date);
			$tense         = "trước";
		}

		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}
		if($difference) {
		$difference = round($difference);
		return "$difference $periods[$j] {$tense}";
		} else {
		return "{$tense}";
		}

		
	}
}
?>