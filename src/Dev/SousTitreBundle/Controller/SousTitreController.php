<?php

namespace Dev\SousTitreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Dev\SousTitreBundle\Formulaires\Objets\ObjSousTitre;
use Dev\SousTitreBundle\Classes\ObjetForm\ObjSousTitre;
use Symfony\Component\HttpFoundation\Request;


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


	    // On crée un objet SousTitre
	    $objSousTitre = new ObjSousTitre();

	    // On crée le FormBuilder grâce au service form factory
	    $form = $this->get('form.factory')->createBuilder('form', $objSousTitre);

	    // On ajoute les champs de l'entité que l'on veut à notre formulaire
	    $form
	      ->add('file',     'file', array('required' => true))
	      ->add('langueSource',      'language', array('required' => true))
	      ->add('langueDestination',      'language', array('required' => true))
	      ->add('modeHybride',      'checkbox', array('required' => false))
	      ->add('OK', 'submit');

	    // À partir du formBuilder, on génère le formulaire
	    $form = $form->getForm();
	    

	    // *************verifie s'il y a une requete **************
	    
	    // On fait le lien Requête <-> Formulaire
    	// À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
    	$form->handleRequest($request);
    	  
    	// verifie si les entrées sont correctes
    	if ($form->isValid()) {
    		$traductionEnCours=true;
     		$file=$form['file']->getData();
 			$file->move("tmpFiles",  $file->getClientOriginalName());


			$servTradST = $this->container->get('traduiresoustitreservice');

			$trad=$servTradST->traduire("tmpFiles\\".$file->getClientOriginalName(), $form['langueSource']->getData(), $form['langueDestination']->getData(), $objSousTitre->getModeHybride());

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



			
			
			//var_dump($_SERVER['HTTP_REFERER']);

			$dataView['trad'] = $trad[1];

		}
		

		$dataView['formUpload'] = $form->createView();
		$dataView['traductionEnCours'] = $traductionEnCours;
		$dataView['traductionEnCoursOk'] = $traductionEnCoursOk;
		$dataView['msgError'] = $msgError;


        return $this->render('DevSousTitreBundle:SousTitre:traduire.html.twig',
        		$dataView
        	);
    }
}
