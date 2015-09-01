<?php

namespace Dev\SousTitreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;

class UploadSrtType extends AbstractType
{
    public function buildForm(FormBuilderInterface  $builder, array $options)
    {
        //max_length' => 20, 'required' => false, 'label' => 'Login', 'trim' => true, 'read_only' => false, 'error_bubbling' => false)
        $builder
          ->add('file',     'file', array('required' => true, 'label' => 'Fichier', 'trim' => true, 'read_only' => false, 'error_bubbling' => false))
          ->add('langueSource',      'language', array('required' => true, 'label'=>'Langue source', 'attr' => array('class'=>'form-control') ))
          ->add('langueDestination',      'language', array('required' => true, 'label'=>'Langue cible'))
          ->add('modeHybride',      'checkbox', array('required' => false,  'label'=>'Mode hybride'))
/*          ->add('ok', 'submit', array('label'=>'Traduire'))*/;

    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Dev\SousTitreBundle\Form\Data\UploadSrt',
        );
    }

    public function getName()
    {
        return 'UploadSrt';
    }
}

