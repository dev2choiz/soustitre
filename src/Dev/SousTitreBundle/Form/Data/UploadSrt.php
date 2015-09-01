<?php
namespace Dev\SousTitreBundle\Form\Data;

//use Doctrine\Common\Collections\ArrayCollection;


//objet qui permettra de faire le formulaire
class UploadSrt
{
  private $id;
  private $file;
  private $langueSource;
  private $langueDestination;
  private $modeHybride;

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

  public function getFile(){
    return $this->file;
  }
  public function setFile($file){
    $this->file=$file;
    return true;
  }

  public function getLangueSource(){
    return $this->langueSource;
  }
  public function setLangueSource($langueSource){
    $this->langueSource=$langueSource;
    return true;
  }

  public function getLangueDestination(){
    return $this->langueDestination;
  }
  public function setLangueDestination($langueDestination){
    $this->langueDestination=$langueDestination;
    return true;
  }

  public function getModeHybride(){
    return $this->modeHybride;
  }
  public function setModeHybride($bool){
    $this->modeHybride=$bool;
    return true;
  }  

}