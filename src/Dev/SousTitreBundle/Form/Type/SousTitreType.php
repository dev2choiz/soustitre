<?php

namespace Dev\SousTitreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;

class SousTitreType extends AbstractType
{
    public function buildForm(FormBuilderInterface  $builder, array $options)
    {
        //max_length' => 20, 'required' => false, 'label' => 'Login', 'trim' => true, 'read_only' => false, 'error_bubbling' => false)
        $builder
          ->add('file',     'file', array('required' => true, 'label' => 'Fichier', 'trim' => true, 'read_only' => false, 'error_bubbling' => false))
          ->add('langue',      'language', array('required' => true, 'label'=>'Langue', 'attr' => array('class'=>'form-control') ))
          ->add('intitule',      'text', array('required' => true, 'label'=>'Intitulé', 'attr' => array('class'=>'form-control') ))
          ->add('addBy',      'text', array('required' => true, 'label'=>'Pseudo', 'attr' => array('class'=>'form-control') ))
          ->add('categorie', 'entity', array(
            'class' => 'DevSousTitreBundle:Categorie',
            'property' => 'value',
            'required' => true,
            'label'=>'Categorie',
            'attr' => array('class'=>'form-control')
            ))/**/
          ;

    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Dev\SousTitreBundle\Entity\SousTitre',
        );
    }

    public function getName()
    {
        return 'SousTitre';
    }
}

