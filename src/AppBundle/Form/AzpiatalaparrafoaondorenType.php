<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AzpiatalaparrafoaondorenType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('ordena')->add('ordena_prod')->add('testuaeu')->add('testuaeu_prod')->add('testuaes')->add('testuaes_prod')->add('ezabatu')->add('createdAt')->add('updatedAt')->add('azpiatala')->add('udala')        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Azpiatalaparrafoaondoren'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_azpiatalaparrafoaondoren';
    }


}
