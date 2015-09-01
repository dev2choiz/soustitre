<?php
namespace Dev\SousTitreBundle\Form\Data;

//use Doctrine\Common\Collections\ArrayCollection;


//objet qui hydratera ou qui sera hydraté par le formulaire
class FusionSrt
{
  private $id;
  private $file1;
  private $file2;
  private $couleur1;
  private $couleur2;
  private $taille1;
  private $taille2;

  public function __construct()
  {
    $this->id   = 3; //round(rand(100),0);
  }
  
  
  public function getId(){
    return $this->id;
  }
  public function setId($id){
    $this->id=$id;
    return true;
  }

  public function getFile1(){
    return $this->file1;
  }
  public function setFile1($file){
    $this->file1=$file;
    return true;
  }

  public function getFile2(){
    return $this->file2;
  }
  public function setFile2($file){
    $this->file2=$file;
    return true;
  }

  public function getCouleur1(){
    return $this->couleur1;
  }
  public function setCouleur1($couleur){
    $this->couleur1=$couleur;
    return true;
  }

public function getCouleur2(){
    return $this->couleur2;
  }
  public function setCouleur2($couleur){
    $this->couleur2=$couleur;
    return true;
  }




  public function getTaille1(){
    return $this->taille1;
  }
  public function setTaille1($taille){
    $this->taille1=$taille;
    return true;
  }

public function getTaille2(){
    return $this->taille2;
  }
  public function setTaille2($taille){
    $this->taille2=$taille;
    return true;
  }

}