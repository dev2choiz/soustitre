<?php
namespace Dev\SousTitreBundle\Form\Data;

//use Doctrine\Common\Collections\ArrayCollection;


class SearchBar
{

  private String $search;

  public function __construct()
  {
private String $search;
  }
  
  
  public function getSearch(){
    return $this->search;
  }
  public function setSearch($search){
    $this->search=$search;
    // return $this;
  }

}