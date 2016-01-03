<?php

namespace OpenCastle\SecurityBundle\Form\Type\Player;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

/**
 * FormType form the inscription form.
 */
class InscriptionFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'label' => 'form.label.username',
            ))
            ->add('plain_password', RepeatedType::class, array(
                    'first_options' => array('label' => 'form.label.password', 'required' => true),
                    'second_options' => array('label' => 'form.label.repeat_password', 'required' => true),
                    'type' => PasswordType::class,
            ))
        ;
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => '\OpenCastle\SecurityBundle\Entity\Player',
            'intention' => $this->getName(),
            'validation_groups' => array('registration', 'Default'),
        ));
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefixes default to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix()
    {
        return 'opencastle_security_player_inscription';
    }
}
