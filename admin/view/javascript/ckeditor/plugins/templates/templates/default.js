﻿/*
 Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or http://ckeditor.com/license
*/
CKEDITOR.addTemplates("default",{imagesPath:CKEDITOR.getUrl(CKEDITOR.plugins.getPath("templates")+"templates/images/"),templates:[
	{
		title:"Mẫu điện thoại",
		image:"template1.gif",
		description:"Mẫu đăng thông số kỹ thuật cho điện thoại.",
		html:
			'<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;" class="product-compare"><tbody><tr class="r"><td rowspan="2" valign="top" class="g"><div class="gh">Thông tin chung</div></td><td id="prop_72" class="p f eph" onclick="ShowHelp(72, 2);">Hệ điều hành</td><td id="c72_1" class="v f">Android 4.3 (Jelly Bean)</td></tr><tr><td class="p"><div id="prop_75" class="ph eph" onclick="ShowHelp(75, 2);">Ngôn ngữ</div></td><td id="c75_1" class="v">Tiếng Anh, Tiếng Việt</td></tr><tr class="r"><td rowspan="6" valign="top" class="g"><div class="gh">Màn hình</div></td><td class="p f">Loại màn hình</td><td id="c6459_1" class="v f">-</td></tr><tr><td class="p"><div class="ph">Màu màn hình</div></td><td id="c6239_1" class="v">16 triệu màu</td></tr><tr><td class="p"><div id="prop_77" class="ph eph" onclick="ShowHelp(77, 2);">Chuẩn màn hình</div></td><td id="c77_1" class="v">Full HD</td></tr><tr><td class="p"><div id="prop_78" class="ph eph" onclick="ShowHelp(78, 2);">Độ phân giải</div></td><td id="c78_1" class="v">1080 x 1920 pixels</td></tr><tr><td class="p"><div id="prop_79" class="ph eph" onclick="ShowHelp(79, 2);">Màn hình rộng</div></td><td id="c79_1" class="v">5.9"</td></tr><tr><td class="p"><div id="prop_80" class="ph eph" onclick="ShowHelp(80, 2);">Công nghệ cảm ứng</div></td><td id="c80_1" class="v">Cảm ứng điện dung đa điểm</td></tr><tr class="r"><td rowspan="6" valign="top" class="g"><div class="gh">Chụp hình &amp; Quay phim</div></td><td id="prop_27" class="p f eph" onclick="ShowHelp(27, 2);">Camera sau</td><td id="c27_1" class="v f">4,0 UltraPixel</td></tr><tr><td class="p"><div id="prop_29" class="ph eph" onclick="ShowHelp(29, 2);">Camera trước</div></td><td id="c29_1" class="v">2.1 MP</td></tr><tr><td class="p"><div class="ph">Đèn Flash</div></td><td id="c6460_1" class="v">Có</td></tr><tr><td class="p"><div id="prop_28" class="ph eph" onclick="ShowHelp(28, 2);">Tính năng camera</div></td><td id="c28_1" class="v">Đèn Led Flash<br>Tự động lấy nét, chạm lấy nét<br>Nhận diện khuôn mặt, nụ cười</td></tr><tr><td class="p"><div id="prop_31" class="ph eph" onclick="ShowHelp(31, 2);">Quay phim</div></td><td id="c31_1" class="v">Quay phim FullHD 1080p@30fps</td></tr><tr><td class="p"><div id="prop_30" class="ph eph" onclick="ShowHelp(30, 2);">Videocall</div></td><td id="c30_1" class="v">Hỗ trợ VideoCall qua Skype</td></tr><tr class="r"><td rowspan="5" valign="top" class="g"><div class="gh">CPU &amp; RAM</div></td><td id="prop_51" class="p f eph" onclick="ShowHelp(51, 2);">Tốc độ CPU</td><td id="c51_1" class="v f">1.7 GHz</td></tr><tr><td class="p"><div class="ph">Số nhân</div></td><td id="c6461_1" class="v">4 nhân</td></tr><tr><td class="p"><div id="prop_6059" class="ph eph" onclick="ShowHelp(6059, 2);">Chipset</div></td><td id="c6059_1" class="v">Qualcomm Snapdragon 600</td></tr><tr><td class="p"><div class="ph">RAM</div></td><td id="c50_1" class="v">RAM: 2 GB</td></tr><tr><td class="p"><div id="prop_6079" class="ph eph" onclick="ShowHelp(6079, 2);">Chip đồ họa (GPU)</div></td><td id="c6079_1" class="v">Adreno 320</td></tr><tr class="r"><td rowspan="4" valign="top" class="g"><div class="gh">Bộ nhớ &amp; Lưu trữ</div></td><td id="prop_54" class="p f eph" onclick="ShowHelp(54, 2);">Danh bạ</td><td id="c54_1" class="v f">Không giới hạn</td></tr><tr><td class="p"><div id="prop_49" class="ph eph" onclick="ShowHelp(49, 2);">Bộ nhớ trong (ROM)</div></td><td id="c49_1" class="v">16 GB</td></tr><tr><td class="p"><div id="prop_52" class="ph eph" onclick="ShowHelp(52, 2);">Thẻ nhớ ngoài</div></td><td id="c52_1" class="v">MicroSD (T-Flash)</td></tr><tr><td class="p"><div id="prop_53" class="ph eph" onclick="ShowHelp(53, 2);">Hỗ trợ thẻ tối đa</div></td><td id="c53_1" class="v">64 GB</td></tr><tr class="r"><td rowspan="3" valign="top" class="g"><div class="gh">Thiết kế &amp; Trọng lượng</div></td><td id="prop_73" class="p f eph" onclick="ShowHelp(73, 2);">Kiểu dáng</td><td id="c73_1" class="v f">Thanh + Cảm ứng</td></tr><tr><td class="p"><div id="prop_88" class="ph eph" onclick="ShowHelp(88, 2);">Kích thước</div></td><td id="c88_1" class="v">164.5 x 82.5 x 10.3 mm</td></tr><tr><td class="p"><div id="prop_100" class="ph eph" onclick="ShowHelp(100, 2);">Trọng lượng (g)</div></td><td id="c100_1" class="v">217</td></tr><tr class="r"><td rowspan="3" valign="top" class="g"><div class="gh">Thông tin pin</div></td><td class="p f">Loại pin</td><td id="c83_1" class="v f">Pin chuẩn Li-Ion</td></tr><tr><td class="p"><div id="prop_84" class="ph eph" onclick="ShowHelp(84, 2);">Dung lượng pin</div></td><td id="c84_1" class="v">3300 mAh</td></tr><tr><td class="p"><div class="ph">Pin có thể tháo rời</div></td><td id="c6462_1" class="v">&nbsp;</td></tr><tr class="r"><td rowspan="13" valign="top" class="g"><div class="gh">Kết nối &amp; Cổng giao tiếp</div></td><td id="prop_65" class="p f eph" onclick="ShowHelp(65, 2);">3G</td><td id="c65_1" class="v f">HSPA+ (DL 42 Mbps/ UL 5.8 Mbps); LTE Cat3, (DL 100 Mbps/ UL 50 Mbps)</td></tr><tr><td class="p"><div class="ph">4G</div></td><td id="c6463_1" class="v">Có</td></tr><tr><td class="p"><div class="ph">Loại Sim</div></td><td id="c6339_1" class="v">Micro SIM</td></tr><tr><td class="p"><div id="prop_60" class="ph eph" onclick="ShowHelp(60, 2);">Khe gắn Sim</div></td><td id="c60_1" class="v">1 Sim</td></tr><tr><td class="p"><div id="prop_66" class="ph eph" onclick="ShowHelp(66, 2);">Wifi</div></td><td id="c66_1" class="v">Wi-Fi 802.11 a/b/g/n/ac, Wi-Fi Direct, DLNA, Wi-Fi hotspot</td></tr><tr><td class="p"><div id="prop_68" class="ph eph" onclick="ShowHelp(68, 2);">GPS</div></td><td id="c68_1" class="v">A-GPS và GLONASS</td></tr><tr><td class="p"><div id="prop_69" class="ph eph" onclick="ShowHelp(69, 2);">Bluetooth</div></td><td id="c69_1" class="v">V4.0 with A2DP</td></tr><tr><td class="p"><div id="prop_61" class="ph eph" onclick="ShowHelp(61, 2);">GPRS/EDGE</div></td><td id="c61_1" class="v">Có</td></tr><tr><td class="p"><div id="prop_48" class="ph eph" onclick="ShowHelp(48, 2);">Jack tai nghe</div></td><td id="c48_1" class="v">3.5 mm</td></tr><tr><td class="p"><div class="ph">NFC</div></td><td id="c6464_1" class="v">Có</td></tr><tr><td class="p"><div id="prop_71" class="ph eph" onclick="ShowHelp(71, 2);">Kết nối USB</div></td><td id="c71_1" class="v">Micro USB</td></tr><tr><td class="p"><div class="ph">Kết nối khác</div></td><td id="c5199_1" class="v">NFC</td></tr><tr><td class="p"><div class="ph">Cổng sạc</div></td><td id="c85_1" class="v">Micro USB</td></tr><tr class="r"><td rowspan="6" valign="top" class="g"><div class="gh">Giải trí &amp; Ứng dụng</div></td><td id="prop_32" class="p f eph" onclick="ShowHelp(32, 2);">Xem phim</td><td id="c32_1" class="v f">WMV, Xvid, H.264(MPEG4-AVC), DivX, MP4, H.263</td></tr><tr><td class="p"><div id="prop_33" class="ph eph" onclick="ShowHelp(33, 2);">Nghe nhạc</div></td><td id="c33_1" class="v">FLAC, eAAC+, WMA, MP3, WAV</td></tr><tr><td class="p"><div id="prop_36" class="ph eph" onclick="ShowHelp(36, 2);">Ghi âm</div></td><td id="c36_1" class="v">Có</td></tr><tr><td class="p"><div id="prop_6039" class="ph eph" onclick="ShowHelp(6039, 2);">Giới hạn cuộc gọi</div></td><td id="c6039_1" class="v">Không</td></tr><tr><td class="p"><div id="prop_34" class="ph eph" onclick="ShowHelp(34, 2);">FM radio</div></td><td id="c34_1" class="v">FM radio với RDS</td></tr><tr><td class="p"><div class="ph">Chức năng khác</div></td><td id="c43_1" class="v">Mạng xã hội ảo<br>Google Play, Google Search, Google Now, Maps, Gmail, YouTube, Lịch<br>Micro chuyên dụng chống ồn</td></tr></tbody></table>'
	},
	{
		title:"Mẫu máy tính bảng",
		image:"template2.gif",
		description:"Mẫu thông số kỹ thuật cho máy tính bảng.",
		html:
			'<table cellspacing="0" cellpadding="0" border="0" class="product-compare" style="width: 100%;"><tbody><tr class="r"><td valign="top" class="g" rowspan="6"><div class="gh">Màn hình</div></td><td class="p f">Loại</td><td class="v f" id="c2439_1">LED-backlit IPS LCD</td></tr><tr><td class="p"><div class="ph">Kích thước</div></td><td class="v" id="c2440_1">9.7 inch</td></tr><tr><td class="p"><div class="ph">Độ phân giải</div></td><td class="v" id="c3019_1">1536 x 2048 pixels</td></tr><tr><td class="p"><div onclick="ShowHelp(2441, 2);" class="ph eph" id="prop_2441">Cảm ứng</div></td><td class="v" id="c2441_1">Điện dung,đa điểm</td></tr><tr><td class="p"><div class="ph">Cảm biến</div></td><td class="v" id="c5019_1">Gia tốc, Con quay hồi chuyển 3 chiều, La bàn</td></tr><tr><td class="p"><div class="ph">Thông tin khác</div></td><td class="v" id="c2443_1">Màn hình 16 triệu màu.</td></tr><tr class="r"><td valign="top" class="g" rowspan="9"><div class="gh">Vi xử lí &amp; Bộ nhớ</div></td><td onclick="ShowHelp(2468, 2);" class="p f eph" id="prop_2468">Loại CPU</td><td class="v f" id="c2468_1">Apple A6x</td></tr><tr><td class="p"><div class="ph">Tốc độ</div></td><td class="v" id="c2469_1">1.4 GHz</td></tr><tr><td class="p"><div onclick="ShowHelp(3059, 2);" class="ph eph" id="prop_3059">Ram</div></td><td class="v" id="c3059_1">1 GB</td></tr><tr><td class="p"><div class="ph">Chipset</div></td><td class="v" id="c5039_1">Apple A6X</td></tr><tr><td class="p"><div class="ph">Xử lý đồ họa</div></td><td class="v" id="c5059_1">PowerVR SGX543MP4</td></tr><tr><td class="p"><div onclick="ShowHelp(3060, 2);" class="ph eph" id="prop_3060">Bộ nhớ trong</div></td><td class="v" id="c3060_1">32 GB</td></tr><tr><td class="p"><div onclick="ShowHelp(2474, 2);" class="ph eph" id="prop_2474">Thẻ nhớ ngoài</div></td><td class="v" id="c2474_1">Không</td></tr><tr><td class="p"><div class="ph">Hỗ trợ thẻ tối đa</div></td><td class="v" id="c5079_1">Không</td></tr><tr><td class="p"><div class="ph">Thông tin khác</div></td><td class="v" id="c3040_1">Không</td></tr><tr class="r"><td valign="top" class="g" rowspan="11"><div class="gh">Giải trí &amp; Ứng dụng</div></td><td class="p f">Camera trước</td><td class="v f" id="c2444_1">1.2 MP</td></tr><tr><td class="p"><div class="ph">Camera sau</div></td><td class="v" id="c2445_1">5 MP(2592 x 1944 pixels)</td></tr><tr><td class="p"><div class="ph">Đặc tính camera</div></td><td class="v" id="c3020_1">Tự động lấy nét,nhận diện khuôn mặt,HDR</td></tr><tr><td class="p"><div class="ph">Quay phim</div></td><td class="v" id="c2446_1">Full HD 1080p(1920x1080 pixels)</td></tr><tr><td class="p"><div class="ph">Xem phim</div></td><td class="v" id="c2448_1">MPEG-4, AAC, MOV, MP4</td></tr><tr><td class="p"><div class="ph">Nghe nhạc</div></td><td class="v" id="c3021_1">WAV, MP3, AAC</td></tr><tr><td class="p"><div class="ph">Ghi âm</div></td><td class="v" id="c3022_1">Không</td></tr><tr><td class="p"><div class="ph">Radio FM</div></td><td class="v" id="c5099_1">Không</td></tr><tr><td class="p"><div class="ph">Văn phòng</div></td><td class="v" id="c3023_1">Hỗ trợ Word, Excel, PPT,PDF, MSN</td></tr><tr><td class="p"><div class="ph">Chỉnh sửa hình ảnh</div></td><td class="v" id="c3024_1">Không</td></tr><tr><td class="p"><div class="ph">Ứng dụng khác</div></td><td class="v" id="c2481_1">Lịch, Đồng hồ, Báo thức, Mail, Sổ tay</td></tr><tr class="r"><td valign="top" class="g" rowspan="14"><div class="gh">Kết nối dữ liệu</div></td><td class="p f">Băng tần 2G</td><td class="v f" id="c2458_1">GSM 850/900/1800/1900</td></tr><tr><td class="p"><div class="ph">Băng tần 3G</div></td><td class="v" id="c2459_1">HSDPA 850/900/1900/2100,băng tần 4G(LTE 700 MHz Class 17 / 2100)</td></tr><tr><td class="p"><div onclick="ShowHelp(2460, 2);" class="ph eph" id="prop_2460">Hỗ trợ sim</div></td><td class="v" id="c2460_1">Miro sim</td></tr><tr><td class="p"><div class="ph">Đàm thoại</div></td><td class="v" id="c3025_1">Không</td></tr><tr><td class="p"><div class="ph">Tin nhắn</div></td><td class="v" id="c5100_1">Email, IM, iMessage, Push Email</td></tr><tr><td class="p"><div onclick="ShowHelp(3099, 2);" class="ph eph" id="prop_3099">3G</div></td><td class="v" id="c3099_1">HSDPA, 21 Mbps; HSUPA, 5.76 Mbps</td></tr><tr><td class="p"><div onclick="ShowHelp(2454, 2);" class="ph eph" id="prop_2454">WiFi</div></td><td class="v" id="c2454_1">802.11 b/g/n</td></tr><tr><td class="p"><div class="ph">Trình duyệt</div></td><td class="v" id="c5101_1">Safari</td></tr><tr><td class="p"><div onclick="ShowHelp(2455, 2);" class="ph eph" id="prop_2455">GPS</div></td><td class="v" id="c2455_1">Có</td></tr><tr><td class="p"><div onclick="ShowHelp(2456, 2);" class="ph eph" id="prop_2456">Bluetooth</div></td><td class="v" id="c2456_1">4.0 with A2DP</td></tr><tr><td class="p"><div onclick="ShowHelp(2451, 2);" class="ph eph" id="prop_2451">HDMI</div></td><td class="v" id="c2451_1">Không</td></tr><tr><td class="p"><div class="ph">Cổng USB</div></td><td class="v" id="c2450_1">2.0</td></tr><tr><td class="p"><div class="ph">Jack tai nghe</div></td><td class="v" id="c5119_1">3.5 mm</td></tr><tr><td class="p"><div class="ph">Kết nối khác</div></td><td class="v" id="c2457_1">Lightning, LTE</td></tr><tr class="r"><td valign="top" class="g" rowspan="3"><div class="gh">Nguồn</div></td><td onclick="ShowHelp(2475, 2);" class="p f eph" id="prop_2475">Loại pin</td><td class="v f" id="c2475_1">Lithium - Polymer</td></tr><tr><td class="p"><div class="ph">Dung lượng pin</div></td><td class="v" id="c3039_1">11.560 mAh</td></tr><tr><td class="p"><div class="ph">Thời gian sử dụng thường</div></td><td class="v" id="c2476_1">10 giờ</td></tr><tr class="r"><td valign="top" class="g" rowspan="5"><div class="gh">Thông tin chung</div></td><td onclick="ShowHelp(2477, 2);" class="p f eph" id="prop_2477">Hệ điều hành</td><td class="v f" id="c2477_1">iOS 6</td></tr><tr><td class="p"><div class="ph">Nâng cấp</div></td><td class="v" id="c5139_1">Đây là phiên bản iOS mới nhất.</td></tr><tr><td class="p"><div class="ph">Ngôn ngữ</div></td><td class="v" id="c2499_1">Tiếng Việt, Tiếng Anh</td></tr><tr><td class="p"><div class="ph">Kích thước (DxRxC)</div></td><td class="v" id="c2479_1">241.2 x 185.7 x 9.4</td></tr><tr><td class="p"><div class="ph">Trọng lượng (g)</div></td><td class="v" id="c2480_1">662</td></tr></tbody></table>'
	},
	{
		title:"Mẫu Laptop",
		image:"template3.gif",
		description:"Mẫu đăng thông số kỹ thuật cho Laptop.",
		html:
			'<table class="product-compare"><tbody><tr class="r"><td rowspan="6" class="g"><div class="gh">Bộ xử lý</div></td><td class="p f">Hãng CPU</td><td id="c95_1" class="v f">Intel</td></tr><tr><td class="p"><div class="ph">Công nghệ CPU</div></td><td id="c92_1" class="v">Core i3</td></tr><tr><td class="p"><div class="ph">Loại CPU</div></td><td id="c94_1" class="v">3217U</td></tr><tr><td class="p"><div id="prop_93" class="ph eph" onclick="ShowHelp(93, 2);">Tốc độ CPU</div></td><td id="c93_1" class="v">1.80 GHz</td></tr><tr><td class="p"><div id="prop_96" class="ph eph" onclick="ShowHelp(96, 2);">Bộ nhớ đệm</div></td><td id="c96_1" class="v">3 MB, L3 Cache</td></tr><tr><td class="p"><div id="prop_97" class="ph eph" onclick="ShowHelp(97, 2);">Tốc độ tối đa</div></td><td id="c97_1" class="v">Không</td></tr><tr class="r"><td rowspan="3" class="g"><div class="gh">Bo mạch</div></td><td id="prop_127" class="p f eph" onclick="ShowHelp(127, 2);">Chipset</td><td id="c127_1" class="v f">Intel® HM76 Express Chipset</td></tr><tr><td class="p"><div id="prop_134" class="ph eph" onclick="ShowHelp(134, 2);">Tốc độ Bus</div></td><td id="c134_1" class="v">1600 MHz</td></tr><tr><td class="p"><div class="ph">Hỗ trợ RAM tối đa</div></td><td id="c137_1" class="v">8 GB</td></tr><tr class="r"><td rowspan="3" class="g"><div class="gh">Bộ nhớ</div></td><td id="prop_146" class="p f eph" onclick="ShowHelp(146, 2);">Dung lượng RAM</td><td id="c146_1" class="v f">2 GB</td></tr><tr><td class="p"><div id="prop_149" class="ph eph" onclick="ShowHelp(149, 2);">Loại RAM</div></td><td id="c149_1" class="v">DDR3 (2 khe RAM)</td></tr><tr><td class="p"><div id="prop_155" class="ph eph" onclick="ShowHelp(155, 2);">Tốc độ Bus</div></td><td id="c155_1" class="v">1600 MHz</td></tr><tr class="r"><td rowspan="2" class="g"><div class="gh">Đĩa cứng</div></td><td id="prop_183" class="p f eph" onclick="ShowHelp(183, 2);">Loại ổ đĩa</td><td id="c183_1" class="v f">HDD</td></tr><tr><td class="p"><div class="ph">Dung lượng đĩa cứng</div></td><td id="c184_1" class="v">500 GB</td></tr><tr class="r"><td rowspan="4" class="g"><div class="gh">Màn hình</div></td><td class="p f">Kích thước màn hình</td><td id="c187_1" class="v f">14 inch</td></tr><tr><td class="p"><div class="ph">Độ phân giải (W x H)</div></td><td id="c189_1" class="v">HD (1366 x 768 pixels)</td></tr><tr><td class="p"><div id="prop_186" class="ph eph" onclick="ShowHelp(186, 2);">Công nghệ MH</div></td><td id="c186_1" class="v">LED Blacklit, Reality, chế độ (Vivid, Natural, Text)</td></tr><tr><td class="p"><div class="ph">Cảm ứng</div></td><td id="c480_1" class="v">Không</td></tr><tr class="r"><td rowspan="3" class="g"><div class="gh">Đồ họa</div></td><td class="p f">Chipset đồ họa</td><td id="c191_1" class="v f">Intel® HD Graphics 4000</td></tr><tr><td class="p"><div class="ph">Bộ nhớ đồ họa</div></td><td id="c192_1" class="v">Share</td></tr><tr><td class="p"><div class="ph">Thiết kế card</div></td><td id="c193_1" class="v">Tích hợp</td></tr><tr class="r"><td rowspan="3" class="g"><div class="gh">Âm thanh</div></td><td class="p f">Kênh âm thanh</td><td id="c194_1" class="v f">2.0</td></tr><tr><td class="p"><div class="ph">Công nghệ</div></td><td id="c195_1" class="v">High Quality Stereo Speakers, ClearAudio+ mode (Music, Video), S-FORCE Front Surround 3D</td></tr><tr><td class="p"><div class="ph">Thông tin thêm</div></td><td id="c196_1" class="v">Headphones, Microphone</td></tr><tr class="r"><td rowspan="2" class="g"><div class="gh">Đĩa quang</div></td><td class="p f">Tích hợp</td><td id="c2939_1" class="v f">Có</td></tr><tr><td class="p"><div class="ph">Loại đĩa quang</div></td><td id="c197_1" class="v">DVD Super Multi Double Layer</td></tr><tr class="r"><td rowspan="2" class="g"><div class="gh">Tính năng mở rộng &amp; cổng giao tiếp</div></td><td class="p f">Cổng giao tiếp</td><td id="c200_1" class="v f">2 x USB 2.0, 2 x USB 3.0, HDMI, LAN (RJ45)</td></tr><tr><td class="p"><div class="ph">Tính năng mở rộng</div></td><td id="c201_1" class="v">One Key Recovery, Rapid Wake + Eco, USB Charge, Multi TouchPad</td></tr><tr class="r"><td rowspan="3" class="g"><div class="gh">Giao tiếp mạng</div></td><td id="prop_204" class="p f eph" onclick="ShowHelp(204, 2);">LAN</td><td id="c204_1" class="v f">10/100/1000 Mbps Ethernet LAN (RJ-45 connector)</td></tr><tr><td class="p"><div id="prop_205" class="ph eph" onclick="ShowHelp(205, 2);">Chuẩn WiFi</div></td><td id="c205_1" class="v">802.11b/g/n</td></tr><tr><td class="p"><div id="prop_206" class="ph eph" onclick="ShowHelp(206, 2);">Kết nối không dây khác</div></td><td id="c206_1" class="v">Bluetooth® (4.0 + HS), NFC (Công nghệ giao tiếp tầm ngắn)</td></tr><tr class="r"><td rowspan="2" class="g"><div class="gh">PIN/Battery</div></td><td class="p f">Thông tin Pin</td><td id="c228_1" class="v f">VGP-BPS35A</td></tr><tr><td class="p"><div id="prop_230" class="ph eph" onclick="ShowHelp(230, 2);">Thời gian sử dụng thường</div></td><td id="c230_1" class="v">3.5 giờ</td></tr><tr class="r"><td rowspan="2" class="g"><div class="gh">Hệ điều hành, phần mềm sẵn có/OS</div></td><td class="p f">HĐH kèm theo máy</td><td id="c240_1" class="v f">Windows 8 Single Language,64-bit</td></tr><tr><td class="p"><div class="ph">Phần mềm sẵn có</div></td><td id="c242_1" class="v">Microsoft Office bản dùng thử, VAIO Care, VAIO Transfer Support, VAIO Update, Trend Micro™ Titanium Maximum Security bản dùng thử</td></tr><tr class="r"><td rowspan="4" class="g"><div class="gh">Kích thước &amp; trọng lượng</div></td><td class="p f">Chiều dài (mm)</td><td id="c252_1" class="v f">342</td></tr><tr><td class="p"><div class="ph">Chiều rộng (mm)</div></td><td id="c253_1" class="v">242.5</td></tr><tr><td class="p"><div class="ph">Chiều cao (mm)</div></td><td id="c254_1" class="v">24.9</td></tr><tr><td class="p"><div class="ph">Trọng lượng (kg)</div></td><td id="c255_1" class="v">2.20</td></tr></tbody></table>'
	}
]});