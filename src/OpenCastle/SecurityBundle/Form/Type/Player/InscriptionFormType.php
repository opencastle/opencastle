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

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('username', 'text', array(
                'label' => 'form.label.username'
            ))
            ->add('plain_password', 'repeated', array(
                    'first_options' => array('label' => 'form.label.password', 'required' => true),
                    'second_options' => array('label' => 'form.label.repeat_password', 'required' => true),
                    'type' => 'password'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => '\OpenCastle\SecurityBundle\Entity\Player',
            'intention' => $this->getName(),
            'validation_groups' => array('registration', 'Default')
        ));
    }

    public function getName()
    {
        return 'opencastle_security_player_inscription';
    }
}
