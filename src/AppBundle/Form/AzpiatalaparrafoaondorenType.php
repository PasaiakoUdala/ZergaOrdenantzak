<?php

namespace AppBundle\Form;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
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
        $builder
            ->add('ordena')
            ->add('testuaeu',CKEditorType::class, array(
                'config_name' => 'my_config_1',
            ))
            ->add('testuaes',CKEditorType::class, array(
                'config_name' => 'my_config_1',
            ))
            ->add('azpiatala')
            ->add('udala')        ;
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
