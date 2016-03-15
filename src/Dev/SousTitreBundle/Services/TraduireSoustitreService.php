<?php

namespace Dev\SousTitreBundle\Services;


class TraduireSoustitreService{


	private $serviceTrad;


	public function __construct(\Doctrine\ORM\EntityManager $em, \Dev\SousTitreBundle\Services\TraductionService $st){
		$this->serviceTrad = $st;
	}


	public function traduire ( $fileName, $langueSource, $langueDestination /*, $modeHybride*/){

		$contenu = file_get_contents($fileName);
		$contenuTrad = $contenu;
		$pos=0;

		
		$tst=preg_match(
			'|(\d)+(\s)+([0-9]){2}:([0-9]){2}:([0-9]){2},([0-9]){3}(\s)-->(\s)([0-9]){2}:([0-9]){2}:([0-9]){2},([0-9]){3}(\s)*|',
			$contenu, $res, PREG_OFFSET_CAPTURE, $pos);

		if ($tst) {		// si le test passe, c'est qu'il s'agit d'un fichier au format srt
			$pos=$res[0][1]+strlen($res[0][0]);
			while($tst){
				$tst=preg_match(
					'|(\d)+(\s)+([0-9]){2}:([0-9]){2}:([0-9]){2},([0-9]){3}(\s)-->(\s)([0-9]){2}:([0-9]){2}:([0-9]){2},([0-9]){3}(\s)*|',
					$contenu, $res, PREG_OFFSET_CAPTURE, $pos);

				if ($tst) {	// ce n'est pas la derniere ligne
					$posAvant=$pos;
					$pos=$res[0][1]+strlen($res[0][0]);
					$replique= substr( $contenu, $posAvant,$res[0][1]-$posAvant );
					$trad = $this->serviceTrad->googleTraduction( $replique,$langueSource,$langueDestination );
					
					$contenuTrad=str_replace($replique, "".$trad."\r\n\r\n" , $contenuTrad);
					
				}else{		//derniere ligne
					$replique= substr( $contenu, $pos );	// de la position jusqu'a la fin du fichier
					$trad = $this->serviceTrad->googleTraduction( $replique,$langueSource,$langueDestination );
					$contenuTrad=str_replace($replique, "".$trad."\r\n\r\n" , $contenuTrad);
				}
			
			}

			return [true,$contenuTrad];

		}
		// s'il ne s'agit pas d'un fichier srt, on renvoi false, et le contenu initial
		return [false,$contenu, "le contenu du fichier ne semble pas etre des sous-titres au format srt"];
		



	    

	}







}

















