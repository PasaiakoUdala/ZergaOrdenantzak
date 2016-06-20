<?php

namespace AppBundle\Form;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AtalaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('kodea')
            ->add('izenburuaeu')
            ->add('izenburuaes')

//            ->add('izenburuaeu',CKEditorType::class, array(
//                'config_name' => 'my_config_1',
//            ))
//            ->add('izenburuaes', CKEditorType::class, array(
//                'config_name' => 'my_config_1',
//            ))
            ->add('ordenantza')
            ->add('udala')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Atala'
        ));
    }
}
