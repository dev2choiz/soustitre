<?php

namespace Dev\SousTitreBundle\Services;


class OutilsElasticService{


	private $serviceTrad;


	public function __construct(){
		$this->serviceTrad = $st;
	}


	public function recupResultat ($results){
		$tabRes=[];
		foreach ($results as $key => $result) {
			$tabRes[]=$result;
		}
	}

	public function testErreurResult (){
		return true;
	}





}

















