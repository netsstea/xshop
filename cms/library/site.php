<?
function user_link($u = null, $absolute_url = false)
{
	if ($u == null)
		$u = Zend_Registry::get('user');

	$url = "/user/" . $u['iid'];
	if ($absolute_url)
	{
		return SITE_URL . $url;
	}
	else
		return $url;
}

/**
 * File browser directory configuration
 * @return multitype:multitype:string boolean  multitype:string mixed
 */
function mm_public_dirs()
{
	$lu = Zend_Registry::get('user');
	$roots = array(
			array(
					'id' => 'home',
					'name' => 'Home',
					'dir' => $lu['id'],
					'icon' => 'home',
					'title' => "Your files"
			),
			array(
					'id' => 'gallery',
					'name' => 'Gallery',
					'dir' => 'gallery',
					'icon' => 'picture',
					'title' => 'Public gallery made available by admins/modes',
					'create_dir' => false, //user can create dir
					'create_files' => false,
					'remove_files' => false, //user can remove files
			),
			array(
					'id' => 'public',
					'name' => 'Public',
					'dir' => 'public',
					'icon' => 'user',
					'title' => 'Files uploaded by users made publicly available',
					'create_dir' => true, //user can create dir
					'create_files' => true,
					'remove_files' => false, //user can remove files
			)
	);

	return $roots;
}

function available_themes()
{
	$default = array('default' => "Default", "vne" => "Vnexpress");
	return get_conf('theme:available_themes', $default);
}

function icon_class($name, $type = 'glyph')
{
    $map = array(
        'syllabus' => 'book',
        'course' => 'certificate',
        'unit' => 'list',
        'question' => 'question-sign',
        'concept' => 'tag',
        'idiom' => 'quote-right',
        'ebook' => 'book',
        'image' => 'picture',
        'quora' => 'question-sign',
        'recording' => 'music',
        'dictionary' => 'tag',
        'idioms' => 'tag',
         'sentence' => 'tag',
         'badge' => 'heart-empty',
         'subject' => 'globe',
         'finance' => 'usd',
         'money' => 'copyright-mark',
        'vmoney' => 'leaf',
         'take' => 'star',
         'exercise' => 'star',
          'unlock' => 'magnet',
         'annotation' => 'pencil',
         'dictation' => 'headphones',
         'oview' => 'bookmark',
         'overview' => 'bookmark',
         'vocabulary' => 'tag',
         'vocab' => 'tag',
         'lecture' => 'facetime-video',
    	'video' => 'facetime-video',
         'lesson' => 'facetime-video',
         'preview' => 'eye-open',
          'recharge' => 'plus',
         'transaction' => 'ok',
    	'news' => 'book',
    	'category' => 'tree-conifer',
    	'source' => 'cloud',
    	'story' => 'book',
    	'password' => 'ok',
    	'key' => 'ok',
    );

    if (isset($map[$name]))
        return get_icon($map[$name], $type);
    else 
        return get_icon($name, $type);
}

function redis_key($type, $params)
{
	if ($type == 'new_story_counter')
	{
		return "nsc:" . $params;
	}
	else if ($type == 'new_comment_counter')
	{
		return "ncc:" . $params;
	}
	else
		die("$type does not exist");
}

function country_list()
{
	return array('vn' => "Vietnam", 'us' => "U.S", 'jp' => "Japan" );
}

function language_list()
{
	return country_list();
}


function get_cache_dir()
{
    $dir = PUBLIC_PATH. '/cache/';//add folder caches
    if (getenv('SITE'))
        $dir = $dir . getenv('SITE') . '/';
    else
        $dir = $dir . CODENAME . '/';
    return $dir;
}

function get_cache_file_fullpath()
{
	$dir = get_cache_dir();

	if (strpos($_SERVER['REQUEST_URI'], '/story/view') === 0)
	{
		$id = get_value('id', 'invalid');
		$file = "story/view/$id";
	}
	else if(strpos($_SERVER['REQUEST_URI'], '/story/list') === 0)
	{
		$category = get_value('category', 'hot');
		if ($category == '')
			$category = 'hot';
				
		$page = get_value('page', 1);
		
		$items_per_page = get_value('items_per_page', 10);
		$file = "story/list/{$category}/{$page}_{$items_per_page}";
	}
	else if(strpos($_SERVER['REQUEST_URI'], '/story/hot-tags') === 0)
	{
		$file = "story/hot-tags";
	}
	if (isset($file))
	 return $dir . $file;
	else 
	return '';
}

function is_thuky()
{
    if (strpos($_SERVER['HTTP_HOST'], 'thuky') !== false)
        return true;
    return false;
}
function featured_tag()
{
	return '_featured';
}

function display_tag($tag)
{
	if ($tag['slug'] == featured_tag())
		return '';
	$count = isset($tag['counter']['s']) ? $tag['counter']['s']: 1;
	if ($count == 0)
		$count = 1;
	$ret = "<a href='" . node_link('tag', $tag) . "'>" .
			"<span class='tag label label-primary'><i class='" . get_icon('tag') . "'></i> " . $tag['name'] . "</span></a>" ;
	if ($count > 1) 
		$ret = $ret . "<font color='#C0C0C0'> × " . $count ."</font>";
	return $ret;
}

/*
//takes something like http://vnexpress.net/abc/xyz and return 'vne'
function newssite_info($url)
{
    $codenames = array(
        "vne" => "vnexpress",
        "cafeF" => "cafef",
        "tno" => "thanhnien",
        "dantri" => "dantri",
        'chinhphu' => "chinhphu",
        'nguoiduatin' => 'nguoiduatin',
        '24h' => '24h',
        'atgt' => 'atgt',
        'bld' => 'baolaodong',
        'na' => "NA"
    );
            
    $t = parse_url($url);
    
    $host = isset($t['host']) ? strtolower($t['host']) : 'na';
    $code = 'na';
    foreach($codenames as $i => $val)
    {
        if (strpos($host, $val) !== false)
        {
            $code = $i;
        }
    }

    $icon = newssite_icon($code);
    return array('code' => $code, 'name' => newssite_name($code), 'icon' => newssite_icon($code));
    
};

function newssite_names()
{
    return array(
			"vne" => "vnexpress.net",
			"cafeF" => "cafef.vn",
			"tno" => "thanhnien.com.vn",
			"dantri" => "dantri.com.vn",
	        'chinhphu' => 'chinhphu.vn',
	        'nguoiduatin' => 'nguoiduatin.vn',
	        '24h' => '24h.com.vn',
            'atgt' => 'atgt.vn',
            'bld' => 'laodong.com.vn'
	);
}
function newssite_name($code)
{
	$configs = newssite_names();
	if (isset($configs[$code]))
		return $configs[$code];
	else
		return '';
};

function newssite_icon($code)
{
    $configs = array(
            "vne" => "http://st.f1.vnecdn.net/i/v101/icons/logo_Vne.png",
            "cafeF" => "cafef.vn",
            "tno" => "thanhnien.com.vn",
            "dantri" => "http://halongcoal.com.vn/uploads/news/source/logo_dantri.png",
            'chinhphu' => 'http://news.chinhphu.vn/Themes/Default/Images/logo.jpg',
            'nguoiduatin' => 'http://static.nguoiduatin.vn/images/default/logo.jpg',
            '24h' => 'http://tindiem.com/mobile/images/24h.jpeg',
            'atgt' => 'http://tindiem.com/mobile/images/atgt.jpg',
            'bld' => 'http://tindiem.com/mobile/images/bld.jpg',
    );
    if (isset($configs[$code]))
        return $configs[$code];
    else 
        return '';
}
*/


function node_anchor($type, $node, $class='')
{
	return "<a class='" . $class . "' href='" . node_link($type, $node) . "'>{$node['name']}</a>";
}

function node_link($type, $node)
{
    //TODO: show news by category, if category is not found or equal 0, show news by ID 
	if ($type == 'category')
	{
		if (!isset($node['pid']) || $node['pid'] == '0')
		{
			return "/{$node['slug']}";
		}
		else 
		{
			$categoryTree = Dao_Node_Category::getInstance()->getCategoryTree(array('type' => 'story'));
			foreach ($categoryTree as $cate)
			{
				if ($cate['id'] == $node['pid'])
					return "/{$cate['slug']}/{$node['slug']}";
			}
		}
	}
    if ($type == 'tag')
        return '/tag/'.$node['slug'];
    if(!isset($node['category']) || $node['category'] == null || $node['category'] == '0')
        return "/{$type}/view?id={$node['id']}";
    else
        return "/{$node['category']}/{$node['slug']}-{$node['iid']}.html";
}

// custom functions for demo
function display_avatar ($imgUrl, $size = 50, $atype = AS3_AVATAR_FOLDER)
{
	if(empty($imgUrl)) {
		return ($atype == AS3_AVATAR_FOLDER ? DEFAULT_AVATAR_URL : DEFAULT_ITEM_AVATAR_URL);
	}

	//remote url
	if(preg_match("/^(http|https)/", $imgUrl)) {
		return $imgUrl;
	}

	//local url
	if(strpos($imgUrl, dirname(APPLICATION_PATH)) !== false) {
		//local file, then strip the root dir
		$root = dirname(APPLICATION_PATH) . "/public";
		return str_replace($root, '', $imgUrl);
	}

	//$avatar = $atype . '/' . $size .'/'. $imgUrl;
	$avatar = AS3_ITEM_IMAGE_FOLDER . '/' . $size .'/'. $imgUrl;

	return AVATAR_PREFIX . '/' . str_replace("//", "/", $avatar);
}

function sortWithStickedItems($a, $b)
{
    $r = array();
    $result = array_diff($a, $b);
    foreach ($b as $val)
        array_push($r, $val);
    foreach ($result as $val)
        array_push($r,$val);
    return $r;
}

//facebook parse int . comment,like,share
function fb_counter($url)
{
	/**
     * Add new node
     * @param $url : url of site that we need count likes,comments,shares
     * @return number of likes,comments,shares   
     * */
    $add = 'https://graph.facebook.com/fql?q=%20SELECT%20total_count,comment_count,like_count,share_count%20FROM%20link_stat%20WHERE%20url=%22'.$url.'%22';
    $json = json_decode( file_get_contents($add), true );
    return $json;
}

function calculate_story_point($like, $share, $comment, $time){
    //TODO. calculate story ponit with likes, shares, comments
    // 2 + log(like + share + comment)/ts
    $point = $like + $share + $comment;    
    
//    """The hot formula. Should match the equivalent function in postgres."""
            
    $order = log(max(abs($point), 1), 10);
    $sign = 0;
    if($order > 0)
        $sign = 1; 
    if($order < 0)
        $sign = -1;
    $seconds = $time;
    return round($order + $sign * $seconds / 45000, 7);
}
?>
