<?php

namespace Dev\SousTitreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;

class FusionSrtType extends AbstractType
{
    public function buildForm(FormBuilderInterface  $builder, array $options)
    {
        //max_length' => 20, 'required' => false, 'label' => 'Login', 'trim' => true, 'read_only' => false, 'error_bubbling' => false)
        $builder
          ->add('file1',     'file', array('required' => true, 'label' => 'Fichier .srt 1', 'trim' => true, 'read_only' => false, 'error_bubbling' => false))
          ->add('file2',     'file', array('required' => true, 'label' => 'Fichier .srt 2', 'trim' => true, 'read_only' => false, 'error_bubbling' => false))
          ->add('couleur1',      'hidden', array('required' => true, 'label'=>'Couleur 1', 'attr' => array('class'=>'form-control') ))
          ->add('couleur2',      'hidden', array('required' => true, 'label'=>'Couleur 2', 'attr' => array('class'=>'form-control') ))
          ->add('taille1',      'integer', array('required' => true, 'label'=>'Taille 1', 'attr' => array('class'=>'form-control',
                                                                                                          'min'=>"1",
                                                                                                          'max'=>"100",
                                                                                                          'value'=>"28"            ) ))
          ->add('taille2',      'integer', array('required' => true, 'label'=>'Taille 2', 'attr' => array('class'=>'form-control',
                                                                                                          'min'=>"1",
                                                                                                          'max'=>"100",
                                                                                                          'value'=>"28"            ) ))

/*          ->add('ok', 'submit', array('label'=>'Traduire'))*/;

    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Dev\SousTitreBundle\Form\Data\FusionSrt',
        );
    }

    public function getName()
    {
        return 'FusionSrt';
    }
}