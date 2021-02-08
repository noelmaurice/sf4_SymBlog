<?php

namespace App\Form;

use App\Entity\Article;
/*
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
*/

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*
        $builder
            ->add('title', TextType::class, [
                "attr" => [
                    "placeholder" => "Titre de l'article"
                ]
            ])
            ->add('content', TextareaType::class, [
                "attr" => [
                    "placeholder" => "Contenu de l'article"
                ]
            ])
            ->add('image', TextType::class, [
                "attr" => [
                    "placeholder" => "URL de l'image"
                ]
            ])
            // ->add('createdAt')
            ->add('save', SubmitType::class, [
                "label" => "Enregistrer"
            ])
        ;
        */

        $builder
            ->add('title')
            ->add('category', EntityType::class, [
                "class" => Category::class,
                "choice_label" => "title"
            ])
            ->add('content')
            ->add('image')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
