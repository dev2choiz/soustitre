<?php

namespace Dev\SousTitreBundle\Services;


class FusionnerSoustitreService{

	public function __construct(){
		//
	}

	public function fusionner ( $psFileName1, $psFileName2,  $psCouleur1, $psCouleur2 , $piTaille1, $piTaille2){
		$lsContenu1 = file_get_contents($psFileName1);
		$lsContenu2 = file_get_contents($psFileName2);
		$lsContenuFusion = "[Script Info]
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
Style: Top,Arial,$piTaille1,&H00".strtolower(substr($psCouleur1, 1)).",&H0074FF7A,&H80000000,&H80000000,-1,0,0,0,100,100,0,0,1,3,0,8,10,10,10,0
Style: Mid,Arial,28,&H0000FFFF,&H00FFFFFF,&H80000000,&H80000000,-1,0,0,0,100,100,0,0,1,3,0,5,10,10,10,0
Style: Bot,Arial,$piTaille2,&H00".strtolower(substr($psCouleur2, 1)).",&H00FFFFFF,&H80000000,&H80000000,-1,0,0,0,100,100,0,0,1,3,0,2,10,10,10,0

[Events]
Format: Layer, Start, End, Style, Name, MarginL, MarginR, MarginV, Effect, Text
"; //$lsContenu;
		
		
		/*---- parcours chaque fichier ----*/
		for ($li=0; $li < count([$lsContenu1, $lsContenu2]) ; $li++) {
			$lsContenu=${"lsContenu".($li+1)};

		 	$laRepliques = preg_split ( "|\d+\s*(\d\d:\d\d:\d\d,\d\d\d)\s*-->\s*(\d\d:\d\d:\d\d,\d\d\d)\s|ius", $lsContenu, -1,  PREG_SPLIT_DELIM_CAPTURE);

			if($laRepliques[0] === $lsContenu){
				return [false, 'Le fichier '.(${'psFileName'.($li+1)}).' ne semble pas etre au format .srt'];
			}
		 	unset($laRepliques[0]);

			/*---- parsing du fichier actuel ----*/
 			for ($lj = 3; $lj <count($laRepliques) - 1 ; $lj = $lj + 3) { 

				$laRepliques[$lj]   = str_replace("\r\n", "\\N", trim($laRepliques[$lj]));
				$laRepliques[$lj]   = str_replace("\n", "\\N", trim($laRepliques[$lj]));
				$laRepliques[$lj-2] = substr($laRepliques[$lj-2], 0, 11);
				$laRepliques[$lj-2] = str_replace(',', '.', $laRepliques[$lj-2]);
				$laRepliques[$lj-1] = substr($laRepliques[$lj-1], 0, 11);
				$laRepliques[$lj-1] = str_replace(',', '.', $laRepliques[$lj-1]);
				
				$lsReplique = "Dialogue: 0,".$laRepliques[$lj-2] 
				. ",".$laRepliques[$lj-1] 
				. ",".(['Top','Bot'][$li]).",,0000,0000,0000,," 
				. $laRepliques[$lj]."\n";
				$lsContenuFusion .= $lsReplique;
 			}
		}	// end for

		return [true, $lsContenuFusion];
	}
}
