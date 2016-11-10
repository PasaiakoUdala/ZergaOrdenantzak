<?php

namespace AppBundle\Form;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class HistorikoaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('onartzedata', DateType::class, array(
                'widget' => 'single_text',

                // do not render as type="date", to avoid HTML5 date pickers
                'html5' => false,

                // add a class that can eb selected in JavaScript
                'attr' => ['class' => 'js-datepicker'],
            ))
            ->add('bogargitaratzedata', DateType::class, array(
                'widget' => 'single_text',

                // do not render as type="date", to avoid HTML5 date pickers
                'html5' => false,

                // add a class that can eb selected in JavaScript
                'attr' => ['class' => 'js-datepicker'],
            ))
            ->add('bogbehinbetikodata', DateType::class, array(
                'widget' => 'single_text',

                // do not render as type="date", to avoid HTML5 date pickers
                'html5' => false,

                // add a class that can eb selected in JavaScript
                'attr' => ['class' => 'js-datepicker'],
            ))
            ->add('bogestekaeu')
            ->add('bogestekaes')
            ->add('indarreandata', DateType::class, array(
                'widget' => 'single_text',

                // do not render as type="date", to avoid HTML5 date pickers
                'html5' => false,

                // add a class that can eb selected in JavaScript
                'attr' => ['class' => 'js-datepicker'],
            ))
            ->add('aldaketakeu',CKEditorType::class, array(
                'config_name' => 'my_config_1',
            ))
            ->add('aldaketakes',CKEditorType::class, array(
                'config_name' => 'my_config_1',
            ))
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
