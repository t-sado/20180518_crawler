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
	
	// �eURL��̃^�C�g�����擾���Ă���
	foreach ($lists as $list) {
		$src = mb_convert_encoding(file_get_contents($list['url']), "utf8", "auto");
		$src = str_replace(array("\r\n","\r","\n"), '', $src);
		$title = between('<title>', '</title>', $src);
		echo "{$list['url']}\t{$title}\n";
	}

	// �T�C�gURL�擾�֐�
	function getUrl($beg, $end, $str) {
	  $result = '';
	  $arr_url = explode($beg, $str);
	  $result = ($arr_url) ? $arr_url[1] : '';
	  return $result;
	}
	
	// ���蕶���̊Ԃɂ��镶������擾����
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
