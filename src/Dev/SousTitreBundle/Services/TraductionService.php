<?php

namespace Dev\SousTitreBundle\Services;


class TraductionService{

	
	private $langues;

	public function __construct(){
		$this->langues=$this->recupLangues();
	}

	public function googleTraduction ( $text, $langueSource, $langueDestination ){
		
		$api_key = 'AIzaSyD1ei4OjsmM2sD2XeHbalLEamMPdXOdfpU';
		
		$url = 'https://www.googleapis.com/language/translate/v2?key=' . $api_key . '&q=' . rawurlencode($text);
		$url .= '&target='.$langueDestination;
		$url .= '&source='.$langueSource;

//echo $url;

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);                 
		$response = json_decode($response, true);
		curl_close($curl);

		/*try{
			$response = file_get_contents($url);
		} catch(Exception $e){
			return false;
		}
		$response =json_decode($response,true);
		*/
		
		if ($response != null || !empty($response)) {
		    if (isset($response['error'])) {
		    	return $text . "({$response['error']['message']})";
		    } else {
		    	return $response['data']['translations'][0]['translatedText'];
		    }
		} else {
			return $text;
		}
		
		
	    
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
