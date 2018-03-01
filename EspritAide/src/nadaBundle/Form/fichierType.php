<?php

namespace nadaBundle\Form;

use nadaBundle\Entity\fichier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\PropertyAccess\PropertyPath;

class fichierType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, array(
                'choices' => array(
                    '' => array(
                        'Cours' => 'Cours',
                        'TD' => 'TD',


                    ),

                )))

            ->add('nom')
            ->add('module')
            ->add('idClasse',EntityType::class,array('class'=>'nadaBundle\Entity\Classe','choice_label'=>'niveau','multiple'=>false,))
            ->add('imageFile', VichFileType::class, [
                'required' => false,



            ]);

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'nadaBundle\Entity\fichier'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'nadabundle_fichier';
    }


}
