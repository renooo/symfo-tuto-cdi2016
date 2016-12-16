<?php

namespace AppBundle\Form;

use AppBundle\Entity\Artist;
use AppBundle\Entity\Genre;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArtistFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, [
            'label' => 'Nom',
            'attr' => ['maxlength' => 100, 'placeholder' => 'Nom'],
        ])
        ->add('creationYear', NumberType::class, [
           'label' => 'Année de création',
        ])
        ->add('genres', EntityType::class, [
            'label' => 'Genre(s)',
            'class' => Genre::class,
            'choice_label' => 'name',
            'multiple' => true,
            'attr' => ['style' => 'height: 200px;'],
            'query_builder' => function(EntityRepository $er){
                return $er->createQueryBuilder('g')
                    ->orderBy('g.name', 'ASC');
            },
        ])
        ->add('valider', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => Artist::class,
        ]);
    }

    public function getName()
    {
        return 'app_bundle_artist_form_type';
    }
}
