<?php
class ModelToolInfo extends Model {
	public function infotocshow($cshow) {
		if($cshow=="header") {
			return "Header(Đầu trang)";
		} elseif($cshow=="footer") {
			return "Footer(Chân trang)";
		} elseif($cshow=="sidebar") {
			return "Sidebar(Thanh bên phải)";
		} elseif($cshow=="product") {
			return "Chi tiết sản phẩm";
		} elseif($cshow=="dichvu") {
			return "Dịch vụ";
		} elseif($cshow=="daotao") {
			return "Đào tạo";
		} else {
			return $cshow;
		}
	}
}
?>