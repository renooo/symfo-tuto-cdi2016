<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 03/02/2017
 * Time: 10:36
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ArtistSearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            TextType::class,
            [
                'required' => false,
            ]
        )->add(
            'genres',
            ChoiceType::class,
            [
                'required' => false,
                'multiple' => true,
            ]
        )->add(
            'creationYear_min',
            TextType::class,
            [
                'required' => false,
                'attr' => ['value' => 1900]
            ]
        )->add(
            'creationYear_max',
            TextType::class,
            [
                'required' => false,
                'attr' => ['value' => date('Y')]
            ]
        )->add(
            'search',
            SubmitType::class,
            [
                'attr' => ['class' => 'btn-primary']
            ]
        );
    }

    public function getName()
    {
        return 'app_bundle_artist_search_form_type';
    }
}
