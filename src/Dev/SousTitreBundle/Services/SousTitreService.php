<?php

namespace Dev\SousTitreBundle\Services;


class SousTitreService{


	private $serviceTrad;


	public function __construct(){
	}


	public function isSrt ( $fileName){
		$contenu = file_get_contents($fileName);
		
		return preg_match(
			'|(\d)+(\s)+([0-9]){2}:([0-9]){2}:([0-9]){2},([0-9]){3}(\s)-->(\s)([0-9]){2}:([0-9]){2}:([0-9]){2},([0-9]){3}(\s)*|',
			$contenu, $res, PREG_OFFSET_CAPTURE, 0);

	}







}

















