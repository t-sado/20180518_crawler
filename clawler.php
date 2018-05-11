<?php
	$url = 'https://no1s.biz/';
	mb_language('Japanese');
	$data = mb_convert_encoding(file_get_contents($url), "utf8", "auto");
	$data = str_replace(array("\r\n","\r","\n"), '', $data);	
	$data = explode('<a href=', $data);

	$lists = [];
	foreach ($data as $key => $value) {
		$site_url = getUrl('"', '"', $value);
		if (strpos($site_url, 'https://no1s.biz/') === false) {
			continue;
		}
		$lists[]['url'] = $site_url;
	}
	
	// 各URL先のタイトルを取得してくる
	foreach ($lists as $list) {
		$src = mb_convert_encoding(file_get_contents($list['url']), "utf8", "auto");
		$src = str_replace(array("\r\n","\r","\n"), '', $src);
		$title = between('<title>', '</title>', $src);
		echo "{$list['url']}\t{$title}\n";
	}

	// サイトURL取得関数
	function getUrl($beg, $end, $str) {
	  $result = '';
	  $arr_url = explode($beg, $str);
	  $result = ($arr_url) ? $arr_url[1] : '';
	  return $result;
	}
	
	// 特定文字の間にある文字列を取得する
	function between($beg, $end, $str) {
	  $result = '';
	  $arr_url = explode($beg,$str);
	  if ($arr_url) {
	  	$pos = strpos($arr_url[1],$end);
	    if( false !== $pos ) {
	      $result = substr($arr_url[1],0,$pos);
	    }
	  }
	  return $result;
	}
