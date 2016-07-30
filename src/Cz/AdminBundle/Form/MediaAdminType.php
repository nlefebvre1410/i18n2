<?php

namespace Cz\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaAdminType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file','file', array(
               'label'=> false,
                'attr'=> array(
                    'class'=> 'file-input-custom',
                    'data-show-caption'=> 'true',
                    'data-show-upload'=> 'false',
                    'accept'=>'image/*',
                ),
                'required' => false))
;
    }

    /**
     * Sets the default options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cz\AdminBundle\Entity\MediaAdmin'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cz_adminbundle_media';
    }
}
