<?php

namespace OpenCastle\SecurityBundle\Form\Type\Player;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

/**
 * FormType form the inscription form
 */
class InscriptionFormType extends AbstractType
{

    public function builldForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array(
                'label' => 'form.label.username'
            ))
            ->add('password', 'repeated', array(
                    'first_name' => 'form.label.password',
                    'second_name' => 'form.label.password_confirm',
                    'type' => 'password'
            ))
            ->add('submit_inscription', 'submit', array(
                    'label' => 'form.label.submit_inscription'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => '\\OpenCastle\\SecurityBundle\\Entity\\Player',
            'intention' => 'player_inscription'
        ));
    }

    public function getName()
    {
        return 'opencastle_security_player_inscription';
    }

}