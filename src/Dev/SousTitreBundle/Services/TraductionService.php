<?php

namespace Dev\SousTitreBundle\Services;


class TraductionService{


	
	private $langues;

	public function __construct(){
		$this->langues=$this->recupLangues();
	}

	public function googleTraduction ( $text, $langueSource, $langueDestination ){
		//
		
		$api_key = 'AIzaSyD1ei4OjsmM2sD2XeHbalLEamMPdXOdfpU';
		
		$url = 'https://www.googleapis.com/language/translate/v2?key=' . $api_key . '&q=' . rawurlencode($text);
		$url .= '&target='.$langueDestination;
		$url .= '&source='.$langueSource;

		 


		$response = file_get_contents(/*urlencode*/($url) );
		$obj =json_decode($response,true);

		if($obj != null)
		{
		    if(isset($obj['error'])){
		    	return false;
		        //echo "Error is : ".$obj['error']['message'];
		    }else{

		    	//echo "trad : ".$obj['data']['translations'][0]['translatedText']."-->"./*htmlentities*/($obj['data']['translations'][0]['translatedText'])."<br>";
		    	return $obj['data']['translations'][0]['translatedText'];
		        //echo "Translsated Text: ".$obj['data']['translations'][0]['translatedText']."n";
		    }
		}
		else
		
		
	    return false;
	}


	public function googleTraduction2 ( $text, $langueSource, $langueDestination ){
		//
		
		$api_key = 'AIzaSyD1ei4OjsmM2sD2XeHbalLEamMPdXOdfpU';
		 
		$url = 'https://www.googleapis.com/language/translate/v2?key=' . $api_key . '&q=' . rawurlencode($text);
		$url .= '&target='.$langueDestination;
		$url .= '&source='.$langueSource;

		
		$response = file_get_contents($url);
		$obj =json_decode($response,true); //true converts stdClass to associative array.

		if($obj != null)
		{
		    if(isset($obj['error']))
		    {
		    	return false;
		        //echo "Error is : ".$obj['error']['message'];
		    }
		    else
		    {
		    	return $obj['data']['translations'][0]['translatedText'];
		        //echo "Translsated Text: ".$obj['data']['translations'][0]['translatedText']."n";
		    }
		}
		else return false;
	}



	public function recupLangues(){

		$langues=json_decode(file_get_contents("https://www.googleapis.com/language/translate/v2/languages?key=AIzaSyD1ei4OjsmM2sD2XeHbalLEamMPdXOdfpU"));
		
		if(!empty($langues)){
			$languesTab=[];
			foreach ($langues->data->languages  as $obj) {
				$languesTab[]=$obj->language;
			}
			return $languesTab;
		}else{	//erreur
			return [];
		}
	}



	public function langueSupportee($langueTst){

			$langues=[];
			foreach ($this->langues  as $langue) {
				if ($langueTst==$langue) {
					return true;
				}
			}
			return false;
		
	}



}
