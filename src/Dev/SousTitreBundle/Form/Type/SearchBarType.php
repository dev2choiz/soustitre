<?php

namespace Dev\SousTitreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;

class SearchBarType extends AbstractType
{
    public function buildForm(FormBuilderInterface  $builder, array $options)
    {
        //max_length' => 20, 'required' => false, 'label' => 'Login', 'trim' => true, 'read_only' => false, 'error_bubbling' => false)
        $builder
          ->add('search',      'text', array('required' => true, 'label'=>'Recherche', 'attr' => array('class'=>'form-control') ))

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