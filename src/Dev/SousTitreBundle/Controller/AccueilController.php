<?php

namespace Dev\SousTitreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccueilController extends Controller
{
    public function indexAction()
    {
        return $this->render('DevSousTitreBundle:Accueil:index.html.twig', array('name' => "BacchusSam"));
    }
}
