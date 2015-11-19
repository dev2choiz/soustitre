<?php

namespace Dev\SousTitreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SousTitre
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Dev\SousTitreBundle\Entity\SousTitreRepository")
 */
class SousTitre
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="text")
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="addBy", type="string", length=99)
     */
    private $addBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="intitule", type="string", length=255)
     */
    private $intitule;


    /**
     * @var string
     *
     * @ORM\Column(name="langue", type="string", length=99)
     */
    private $langue;



    /**
     * @ORM\ManyToOne(targetEntity="Dev\SousTitreBundle\Entity\Categorie", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false, name="idCategorie", referencedColumnName="id")
     */
    private $categorie;



    public function __construct(\Doctrine\ORM\EntityManager $em){
        $this->em=$em;
        
        $this->date=new \Datetime();


    }








    /**
     * Set id
     *
     * @param integer $id
     * @return SousTitre
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return SousTitre
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set addBy
     *
     * @param string $addBy
     * @return SousTitre
     */
    public function setAddBy($addBy)
    {
        $this->addBy = $addBy;

        return $this;
    }

    /**
     * Get addBy
     *
     * @return string 
     */
    public function getAddBy()
    {
        return $this->addBy;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return SousTitre
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set intitule
     *
     * @param string $intitule
     * @return SousTitre
     */
    public function setIntitule($intitule)
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * Get intitule
     *
     * @return string 
     */
    public function getIntitule()
    {
        return $this->intitule;
    }


    /**
     * Set langue
     *
     * @param string $langue
     * @return SousTitre
     */
    public function setLangue($langue)
    {
        $this->langue = $langue;
        return $this;
    }

    /**
     * Get langue
     *
     * @return string 
     */
    public function getLangue()
    {
        return $this->langue;
    }


    /**
     * Set categorie
     *
     * @param integer $categorie
     * @return SousTitre
     */
    public function setCategorie(Categorie $categorie)
    {
        $this->categorie = $categorie;
        return $this;
    }

    /**
     * Get categorie
     *
     * @return integer 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }






    //###### partie qui ne concerne pas la base #########
    
    private $file;
    private $categorieValue;
    private $em;
    




    /**
     * Set file
     *
     * @param file $file
     * @return SousTitre
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * Get file
     *
     * @return file 
     */
    public function getFile()
    {
        return $this->file;
    }






    /*public function getCategorieValue(){
        //injection dependance
        $rm=$this->em->getRepository('DevSousTitreBundle:Categorie');
        $rm->find();
    }*/






}
