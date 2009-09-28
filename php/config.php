<?php

    $conf = array(
	'site' => array(
		'baseurl'	=> 'http://localhost:8888/BonesTemplate/',
		'navigation' => array(
			'HOME' 		=> 'http://www.kientran.com',
			'RESUME' 	=> 'http://www.kientran.com/resume',
			'BLOG' 		=> 'http://blog.kientran.com',
			'PORTFOLIO' => 'http://www.kientran.com',
			'SOCIAL' 	=> 'http://www.kientran.com'
		)
	),
	'template' => array(
		'active'	=> 'kientran2009',
		'base'		=> '',
		'baseurl'	=> ''
	)
    );

    $conf['template']['base'] = "templates/".$conf['template']['active'].'/';
    $conf['template']['baseurl'] = $conf['site']['baseurl'].$conf['template']['base'];


?>
