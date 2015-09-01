<?php

namespace Dev\SousTitreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Dev\SousTitreBundle\Formulaires\Objets\ObjSousTitre;

use Dev\SousTitreBundle\Form\Type\UploadSrtType;
use Dev\SousTitreBundle\Form\Data\UploadSrt;
use Symfony\Component\HttpFoundation\Request;

use Dev\SousTitreBundle\Form\Type\FusionSrtType;
use Dev\SousTitreBundle\Form\Data\FusionSrt;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;// hmmm utile??

class SousTitreController extends Controller
{
    public function traduireAction(Request $request)
    {

    	$traductionEnCours 		= false;
    	$traductionEnCoursOk 	= false;
		$msgError				= "";
		$trad 					= "";
		$urlSrt					= "";

		$dataView=[];

        $dataView['name'] = "BacchusSam";


	    // On crée un objet UploadSrt
	    $uploadSrt = new UploadSrt();

	    // // On bind l'objet uploadSrt à notre formulaire uploadSrtType
	    $form = $this->get('form.factory')->create(new UploadSrtType(), $uploadSrt);



	    // *************verifie s'il y a une requete **************
	    if ($request->getMethod() == 'POST') {

		    // On fait le lien Requête <-> Formulaire
	    	// À partir de maintenant, la variable $uploadSrt contient les valeurs entrées dans le formulaire par le visiteur
	    	$form->handleRequest($request);  	//bindrequest()??
	    	  
	    	// verifie si les entrées sont correctes
	    	if ($form->isValid()) {
	    		$traductionEnCours=true;
	     		$file=$form['file']->getData();
	 			$file->move("tmpFiles",  $file->getClientOriginalName());


				$servTradST = $this->container->get('traduiresoustitreservice');

				$trad=$servTradST->traduire("tmpFiles\\".$file->getClientOriginalName(), $form['langueSource']->getData(), $form['langueDestination']->getData(), $uploadSrt->getModeHybride());

				// on signal si la traduction c'est bien deroulé
				if( $trad[0] ){
					$traductionEnCoursOk=true;

					// ecriture de la traduction dans un fichier
					$fileName="tmpFiles\\".$file->getClientOriginalName();				//uniqid().".srt";
					$fp = fopen($fileName,"w+"); // ouverture du fichier en écriture
					fputs($fp, $trad[1] ); // on écrit dans le fichier
					fclose($fp);

					$dataView['fileName'] = "tmpFiles/".$file->getClientOriginalName();
				}else{
					$msgError=$trad[2];
				}


				$dataView['trad'] = $trad[1];

			}
		}


		$dataView['formUpload'] = $form->createView();
		$dataView['traductionEnCours'] = $traductionEnCours;
		$dataView['traductionEnCoursOk'] = $traductionEnCoursOk;
		$dataView['msgError'] = $msgError;


        return $this->render('DevSousTitreBundle:SousTitre:traduire.html.twig',
        		$dataView
        	);
    }




    public function fusionnerAction(Request $request)
    {

    	$fusionEnCours 		= false;
    	$fusionEnCoursOk 	= false;
		$msgError			= "";
		$fusion 			= "";
		$urlSrt				= "";

		$dataView=[];

        $dataView['name'] = "BacchusSam";


	    // On crée un objet FusionSrt
	    $fusionSrt = new FusionSrt();

	    // // On bind l'objet fusionSrt à notre formulaire fusionSrtType
	    $form = $this->get('form.factory')->create(new FusionSrtType(), $fusionSrt);



	    // *************verifie s'il y a une requete **************
	    if ($request->getMethod() == 'POST') {

		    // On fait le lien Requête <-> Formulaire
	    	// À partir de maintenant, la variable $fusionSrt contient les valeurs entrées dans le formulaire par le visiteur
	    	$form->handleRequest($request);  	//bindrequest()??
	    	  
	    	// verifie si les entrées sont correctes
	    	if ($form->isValid()) {
	    		$fusionEnCours=true;

	    		// upload des fichiers
	     		$file1=$form['file1']->getData();
	 			$file1->move("tmpFiles",  $file1->getClientOriginalName());
				$file2=$form['file2']->getData();
	 			$file2->move("tmpFiles",  $file2->getClientOriginalName());

	 			// 


				$servFusionST = $this->container->get('fusionnersoustitreservice');

				// FUUUUUUUUUUUUU SION !! YAAH
				$fusion=$servFusionST->fusionner(	"tmpFiles\\".$file1->getClientOriginalName(),
													"tmpFiles\\".$file2->getClientOriginalName(),
													$form['couleur1']->getData(),
													$form['couleur2']->getData(),
													$form['taille1']->getData(),
													$form['taille2']->getData() 				);



				// on signal si la fusion c'est bien deroulé
				if( $fusion[0] ){
					$fusionEnCoursOk=true;

					// ecriture de la fusion dans un fichier
					$fileName="tmpFiles/".uniqid().".srt";
					//!\ suprimer regulierement
					
					$fp = fopen($fileName,"w+"); // ouverture du fichier en écriture
					fputs($fp, $fusion[1] ); // on écrit dans le fichier
					fclose($fp);

					$dataView['fileName'] = $fileName;
					$dataView['resultatFusion'] = $fusion[1];
					
				}else{
					$msgError=$fusion[1];
				}


				$dataView['fusion'] = $fusion[1];

			}
		}


		$dataView['formFusion'] = $form->createView();
		$dataView['fusionEnCours'] = $fusionEnCours;
		$dataView['fusionEnCoursOk'] = $fusionEnCoursOk;
		$dataView['msgError'] = $msgError;


        return $this->render('DevSousTitreBundle:SousTitre:fusionner.html.twig',
        		$dataView
        	);
    }



}
