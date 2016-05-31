<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HistorikoaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('onartzedata', 'date')
            ->add('bogargitaratzedata', 'date')
            ->add('bogestekaeu')
            ->add('bogestekaes')
            ->add('indarreandata', 'date')
            ->add('aldaketakeu')
            ->add('aldaketakes')
            ->add('fitxategia')
            ->add('createdAt', 'datetime')
            ->add('updatedAt', 'datetime')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Historikoa'
        ));
    }
}
