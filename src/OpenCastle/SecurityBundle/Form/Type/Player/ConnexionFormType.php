<?php

namespace OpenCastle\SecurityBundle\Form\Type\Player;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

/**
 * FormType form the connection form
 */
class ConnexionFormType extends AbstractType
{

    public function builldForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array(
                'label' => 'form.label.username'
            ))
            ->add('password', 'password', array(
                    'label' => 'form.label.password',
            ))
            ->add('submit_connexion', 'submit', array(
                    'label' => 'form.label.submit_connexion'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => '\\OpenCastle\\SecurityBundle\\Entity\\Player',
            'intention' => 'player_connexion'
        ));
    }

    public function getName()
    {
        return 'opencastle_security_player_connexion';
    }
}
