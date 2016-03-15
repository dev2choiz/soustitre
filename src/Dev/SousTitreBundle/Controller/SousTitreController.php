<?php

namespace Dev\SousTitreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Dev\SousTitreBundle\Formulaires\Objets\ObjSousTitre;

use Dev\SousTitreBundle\Form\Type\UploadSrtType;
use Dev\SousTitreBundle\Form\Data\UploadSrt;
use Symfony\Component\HttpFoundation\Request;

use Dev\SousTitreBundle\Form\Type\FusionSrtType;
use Dev\SousTitreBundle\Form\Data\FusionSrt;

use Dev\SousTitreBundle\Form\Type\SousTitreType;
use Dev\SousTitreBundle\Entity\SousTitre;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SousTitreController extends Controller
{
    public function traduireAction(Request $request)
    {

    	$traductionEnCours 		= false;
    	$traductionEnCoursOk 	= false;
		$msgErrors				= [];
		$trad 					= "";
		$urlSrt					= "";

		$dataView				= [];

        $dataView['name'] = "BacchusSam";


	    // On crée un objet UploadSrt
	    $uploadSrt = new UploadSrt();

	    // // On bind l'objet uploadSrt à notre formulaire uploadSrtType
	    $form = $this->get('form.factory')->create(new UploadSrtType(), $uploadSrt);



	    // *************verifie s'il y a une requete **************
	    if ($request->getMethod() == 'POST') {

		    // On fait le lien Requête <-> Formulaire
	    	// À partir de maintenant, la variable $uploadSrt contient les valeurs entrées dans le formulaire par le visiteur
	    	$form->handleRequest($request);
	    	  
	    	// verifie si les entrées sont correctes
	    	if ($form->isValid()) {
		    	$traductionEnCours=true;
		    	$dataView['trad'] = '';

	    		//vérifie si les langues sont supportées
				$servTrad = $this->container->get('traductionservice');
				if (!$servTrad->langueSupportee($uploadSrt->getLangueSource()) ){
					$msgErrors[]="La langue source n'est pas encore supportée";
				}
				if( !$servTrad->langueSupportee($uploadSrt->getLangueDestination()) ) {
					$msgErrors[]="La langue cible n'est pas encore supportée";

				}
				if(empty($msgErrors) ){	//les langues sont supportées
		     		$file=$form['file']->getData();
		 			$file->move("tmpFiles",  $file->getClientOriginalName());


					$servTradST = $this->container->get('traduiresoustitreservice');

					$trad=$servTradST->traduire("tmpFiles".DIRECTORY_SEPARATOR.$file->getClientOriginalName(), $form['langueSource']->getData(), $form['langueDestination']->getData()/*, $uploadSrt->getModeHybride()*/);

					//$trad[1]=html_entity_decode(htmlspecialchars_decode($trad[1]) );

					// on signal si la traduction c'est bien deroulé
					if( $trad[0] ){
						$traductionEnCoursOk=true;

						// ecriture de la traduction dans un fichier
						$fileName="tmpFiles".DIRECTORY_SEPARATOR.uniqid().".srt";

						$fp = fopen($fileName,"w+"); // ouverture du fichier en écriture
						fputs($fp, $trad[1] ); // on écrit dans le fichier
						fclose($fp);

						$dataView['fileName'] = str_replace('\\', '/', $fileName);		//necessaire pour dl
					}else{
						$msgErrors[]=$trad[2];
					}
				
					$dataView['trad'] = $trad[1];
				
				}	//fin test des langues

			}		//fin du traitement de validation
		}

		
		$dataView['formUpload'] = $form->createView();
		$dataView['traductionEnCours'] = $traductionEnCours;
		$dataView['traductionEnCoursOk'] = $traductionEnCoursOk;
		$dataView['msgErrors'] = $msgErrors;


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
				$fusion=$servFusionST->fusionner(	"tmpFiles".DIRECTORY_SEPARATOR.$file1->getClientOriginalName(),
													"tmpFiles".DIRECTORY_SEPARATOR.$file2->getClientOriginalName(),
													$form['couleur1']->getData(),
													$form['couleur2']->getData(),
													$form['taille1']->getData(),
													$form['taille2']->getData() 				);



				// on signale si la fusion s'est bien deroulée
				if( $fusion[0] ){
					$fusionEnCoursOk=true;

					// ecriture de la fusion dans un fichier
					$fileName="tmpFiles".DIRECTORY_SEPARATOR.uniqid().".srt";
					//!\ suprimer regulierement
					
					$fp = fopen($fileName,"w+"); // ouverture du fichier en écriture
					fputs($fp, $fusion[1] ); // on écrit dans le fichier
					fclose($fp);

					$dataView['fileName'] = str_replace('\\', '/', $fileName);	// necessaire pour dl
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









    public function sousTitresAction(Request $request)
    {

		$em = $this->getDoctrine()->getManager();
		$sousTitreRepository = $em->getRepository('DevSousTitreBundle:SousTitre');
		$categorieRepository = $em->getRepository('DevSousTitreBundle:Categorie');

    	$dataView=[];






    	$ajoutEnCours 		= false;
    	$ajoutEnCoursOk 	= false;
		$msgError			= "";





	    // On crée un objet FusionSrt
	    $sousTitre = new SousTitre($em);

	    // // On bind l'objet fusionSrt au formulaire 
	    $form = $this->get('form.factory')->create(new SousTitreType(), $sousTitre);


	    // *************verifie s'il y a une requete **************
	    if ($request->getMethod() == 'POST') {

		    // On fait le lien Requête <-> Formulaire
	    	// À partir de maintenant, la variable $fusionSrt contient les valeurs entrées dans le formulaire par le visiteur
	    	$form->handleRequest($request);  	//bindrequest()??
	    		    

	    	// verifie si les entrées sont correctes
	    	if ($form->isValid()) {
	    		$ajoutEnCours=true;


	    		$sousTitre->setDate(new \Datetime());

	    		// upload du fichier
	    		$fileName=uniqid().".srt";
	     		$file=$form['file']->getData();
	 			$file->move("tmpFiles",  $fileName);
				$fileName="tmpFiles".DIRECTORY_SEPARATOR.$fileName;
	 			

	 			var_dump($form['categorie']->getData()->getId() );
	 			//$sousTitre->setCategorie( $form['categorie']->getData()->getIdCategorie() );
	 			$sousTitre->setValue( file_get_contents($fileName) );

				$servST = $this->container->get('SousTitreService');
				$contenu=file_get_contents($fileName);

				if( $servST->isSrt($fileName) ){
					$ajoutEnCoursOk=true;

					//ecriture de $contenu en base
				    $em->persist($sousTitre);
				    $em->flush();
				}else{
					$msgError='monumental error !!';
				}

			}
		}




		// ON RECUPERE LES SOUS TITRES A AFFICHER



//		$stRepository=$this->container->get('fos_elastica.manager')->getRepository('DevSousTitreBundle:SousTitre');

		//examine l'eventuelle requete de tri ou de changement de page recues
		
		//$em =  $this->getDoctrine()->getEntityManager();
		//$st = $this->getRepository('DevSousTitreBundle:SousTitre');

		//fourni au repository les params necessaires
		//$st=$stRepository->findSousTitres("dev");
		//$soustitres = $sousTitreRepository->findAll();
		
		
	    
	    $query = $em->createQuery("SELECT s FROM DevSousTitreBundle:SousTitre s");
		try{
		    $paginator  = $this->get('knp_paginator');
		   // var_dump($paginator);
		    $pagination = $paginator->paginate(
		        $query,
		        $request->query->getInt('page', 1)/*page number*/,
		        3/*limit per page*/
		    );
		} catch(\Exception $e) {
				echo $e->getMessage();
				
		    // parameters to template
		}

		

    	//$dataView['sousTitres']=$soustitres;

		$dataView['pagination']=$pagination;


		$dataView['formAddSousTitre'] = $form->createView();
		$dataView['ajoutEnCours'] = $ajoutEnCours;
		$dataView['ajoutEnCoursOk'] = $ajoutEnCoursOk;
		$dataView['msgError'] = $msgError;


        return $this->render('DevSousTitreBundle:SousTitre:soustitres.html.twig',
        		$dataView
        	);
    }

	public function listAction(Request $request)
	{
		echo 'on y rentre ?';
	    $em    = $this->get('doctrine.orm.entity_manager');
	    $query = $em->createQuery("SELECT s FROM DevSousTitreBundle:SousTitre s");




		try{

		    $paginator  = $this->get('knp_paginator');
		   // var_dump($paginator);
		    $pagination = $paginator->paginate(
		        $query,
		        $request->query->getInt('page', 1)/*page number*/,
		        3/*limit per page*/
		    );
		} catch(\Exception $e) {
				echo $e->getMessage();
				
		    // parameters to template
		}
	  return $this->render('DevSousTitreBundle:SousTitre:list.html.twig', array('pagination' => $pagination));

	}



    public function afficherSousTitres(Request $request, $id)
    {


    	echo "ici";

		$em = $this->getDoctrine()->getManager();
		$sousTitreRepository = $em->getRepository('DevSousTitreBundle:SousTitre');
		$categorieRepository = $em->getRepository('DevSousTitreBundle:Categorie'); //A F A C

    	$dataView=[];


    	$ajoutEnCours 		= false;
    	$ajoutEnCoursOk 	= false;
		$msgError			= "";





	    // On crée un objet FusionSrt
	    $sousTitre = new SousTitre($em);

	    // // On bind l'objet fusionSrt au formulaire 
	    $form = $this->get('form.factory')->create(new SousTitreType(), $sousTitre);
	    //var_dump($sousTitre);


	    // *************verifie s'il y a une requete **************
	    if ($request->getMethod() == 'POST') {

		    // On fait le lien Requête <-> Formulaire
	    	// À partir de maintenant, la variable $fusionSrt contient les valeurs entrées dans le formulaire par le visiteur
	    	$form->handleRequest($request);  	//bindrequest()??
	    		    

	    	// verifie si les entrées sont correctes
	    	if ($form->isValid()) {
	    		$ajoutEnCours=true;


	    		$sousTitre->setDate(new \Datetime());

	    		// upload du fichier
	    		$fileName=uniqid().".srt";
	     		$file=$form['file']->getData();
	 			$file->move("tmpFiles",  $fileName);
				$fileName="tmpFiles".DIRECTORY_SEPARATOR.$fileName;
	 			

	 			var_dump($form['categorie']->getData()->getIdCategorie() );
	 			//$sousTitre->setCategorie( $form['categorie']->getData()->getIdCategorie() );
	 			$sousTitre->setValue( file_get_contents($fileName) );

				$servST = $this->container->get('SousTitreService');
				$contenu=file_get_contents($fileName);

				if( $servST->isSrt($fileName) ){
					$ajoutEnCoursOk=true;

					//ecriture de $contenu en base
				    $em->persist($sousTitre);
				    $em->flush();
				}else{
					$msgError='monumental error !!';
				}

			}
		}

		$st=$sousTitreRepository->findAll();
		//var_dump($st);

    	$dataView['sousTitres']=$st;

		$dataView['formAddSousTitre'] = $form->createView();
		$dataView['ajoutEnCours'] = $ajoutEnCours;
		$dataView['ajoutEnCoursOk'] = $ajoutEnCoursOk;
		$dataView['msgError'] = $msgError;
























        return $this->render('DevSousTitreBundle:SousTitre:soustitres.html.twig',
        		$dataView
        	);
    }



}
