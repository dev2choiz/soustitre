<?php

namespace Dev\SousTitreBundle\Services;


class FusionnerSoustitreService{


	private $serviceFusion;

	public function __construct(){
		//
	}


	public function fusionner ( $fileName1, $fileName2,  $couleur1, $couleur2 , $taille1, $taille2){
		echo "ddddddddddddddddddddddddddddddddd".$couleur1;
		$erreurs=[];
		$contenu1 = file_get_contents($fileName1);
		$contenu2 = file_get_contents($fileName2);
		$contenuFusion = "[Script Info]
ScriptType: v4.00+
Collisions: Normal
PlayDepth: 0
Timer: 100,0000
Video Aspect Ratio: 0
WrapStyle: 0
ScaledBorderAndShadow: no

[V4+ Styles]
Format: Name,Fontname,Fontsize,PrimaryColour,SecondaryColour,OutlineColour,BackColour,Bold,Italic,Underline,StrikeOut,ScaleX,ScaleY,Spacing,Angle,BorderStyle,Outline,Shadow,Alignment,MarginL,MarginR,MarginV,Encoding
Style: Default,Arial,28,&H00FFFFFF,&H00FFFFFF,&H80000000,&H80000000,-1,0,0,0,100,100,0,0,1,3,0,2,10,10,10,0
Style: Top,Arial,$taille1,&H00".substr($couleur1, 1).",&H0074FF7A,&H80000000,&H80000000,-1,0,0,0,100,100,0,0,1,3,0,8,10,10,10,0
Style: Mid,Arial,28,&H0000FFFF,&H00FFFFFF,&H80000000,&H80000000,-1,0,0,0,100,100,0,0,1,3,0,5,10,10,10,0
Style: Bot,Arial,$taille2,&H00".substr($couleur2, 1).",&H00FFFFFF,&H80000000,&H80000000,-1,0,0,0,100,100,0,0,1,3,0,2,10,10,10,0

[Events]
Format: Layer, Start, End, Style, Name, MarginL, MarginR, MarginV, Effect, Text
"; //$contenu;
		
		

		for ($i=0; $i < count([$contenu1, $contenu2]) ; $i++) { 
			//$contenu=[$contenu1, $contenu2][$i];
			$contenu=${"contenu".($i+1)};
			$pos=0;
		
			// on verifie le format du fichier
			$tst=preg_match(
				'|(\d)+(\s)+([0-9]){2}:([0-9]){2}:([0-9]){2},([0-9]){3}(\s)-->(\s)([0-9]){2}:([0-9]){2}:([0-9]){2},([0-9]){3}(\s)*|',
				$contenu, $res, PREG_OFFSET_CAPTURE, $pos);

			if ($tst) {
				//$pos=$res[0][1]+strlen($res[0][0]);		// $pos au niveau de la premiere replique
				while($tst){
					$tst=preg_match(
						'|(\d)+(\s)+([0-9]){2}:([0-9]){2}:([0-9]){2},([0-9]){3}(\s)-->(\s)([0-9]){2}:([0-9]){2}:([0-9]){2},([0-9]){3}(\s)*|',
						$contenu, $leTemps, PREG_OFFSET_CAPTURE, $pos);

					if ($tst) {
						$posAvant=$pos;
						$pos=$leTemps[0][1]+strlen($leTemps[0][0]);	// $pos au niveau du debut de la replique
						
						$tst=preg_match(
							'|(\d)+(\s)+([0-9]){2}:([0-9]){2}:([0-9]){2},([0-9]){3}(\s)-->(\s)([0-9]){2}:([0-9]){2}:([0-9]){2},([0-9]){3}(\s)*|',
							$contenu, $lesRepl, PREG_OFFSET_CAPTURE, $pos);

						
						if ($tst) {	// si c'est pas la derniere ligne
							$replique= substr( $contenu, $pos, $lesRepl[0][1]-$pos-2 );	//-2 pour le retour a la ligne
						} else {	//si c'est la derniere ligne
							$replique= substr( $contenu, $pos);
						}
						
						






						//on va prendre la ligne avec le temps puis la purger de tout caracteres non-attendu
						$tst=preg_match(
							'|([0-9]){2}:([0-9]){2}:([0-9]){2},([0-9]){3}(\s)-->(\s)([0-9]){2}:([0-9]){2}:([0-9]){2},([0-9]){3}|',
						$leTemps[0][0], $delais, PREG_OFFSET_CAPTURE, 0);

						//$delais=purgerTemps($delais[0][0]);
						$delais=str_replace(' ', '', $delais[0][0]);
						$delais=str_replace(',', '.', $delais);
						$delais=str_replace('-->', ',', $delais);


						//$delais vaut quelque chose comme ca: 00:00:07.500,00:00:09.200
						$contenuFusion .= "Dialogue: 0,".substr($delais, 1,10);
						$contenuFusion .= ",".substr($delais, 14,10);
						$contenuFusion .= ",".(['Top','Bot'][$i]).",,0000,0000,0000,,";
						$contenuFusion .= $replique;

					}
				
				}

			}else{
				return [false, 'Le fichier $i ne semble pas etre au format .srt'];
			}

		}	// end for




		// tout s'est bien passé, on retour le resulat de la fusion sous forme de tableau bi-dimensionnel
		return [true, $contenuFusion];

	    
	}




private function purgerTemps($string){

}

}
