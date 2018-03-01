<?php

namespace nadaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClasseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('niveau', ChoiceType::class, array(
                'choices' => array(
                    '1er année' => array(
                        '1A' => '1A',


                    ),
                    '2eme année' => array(
                        '2A' => '2A',
                        '2B' => '2P',
                    ),
                    '3eme année' => array(
                        '3A' => '3A',
                        '3B' => '3B',
                    ),
                    '4eme année' => array(
                        '4GL' => '4GL',
                        '4infoB' => '4infoB',
                        '4sim' => '4sim',
                        '4Arctic' => '4Arctic',
                        '4NIDS' => '4NIDS',
                        '4IRT' => '4IRT',
                        '4Sleam' => '4Sleam',
                        '4DS' => '4DS',
                        '4TWIN' => '4TWIN',
                        '4BI' => '4BI',


                    ),
                    '5eme année' => array(
                        '5GL' => '5GL',
                        '5infoB' => '5infoB',
                        '5sim' => '5sim',
                        '5Arctic' => '5Arctic',
                        '5NIDS' => '5NIDS',
                        '5IRT' => '5IRT',
                        '5Sleam' => '5Sleam',
                        '5DS5' => '5DS',
                        '5TWIN' => '5TWIN',
                        '5BI' => '4BI',


                    ),
                ),
            ))
         ->add('numero');


    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'nadaBundle\Entity\Classe'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'nadabundle_classe';
    }


}
