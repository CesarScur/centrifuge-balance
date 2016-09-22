<?php

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FalconType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $number = array();
        foreach(range(1, 30) as $value) {
            $number[$value] = $value;
        }

        $builder->add('number', ChoiceType::class, array(
            'choices' => $number,
//            'group_by' => function($val, $key, $index) {
//                if ($val <= 18) {
//                    return 'Inner';
//                } else {
//                    return 'Outer';
//                }
//            }
        ))->add('weight', TextType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Falcon'
        ));

    }

    public function getName()
    {
        return 'app_bundle_falcon';
    }
}
