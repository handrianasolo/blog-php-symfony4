<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => array(
                'placeholder' => 'your title here'
                )])

            ->add('category', EntityType::class, [
                'class' =>  Category::class,
                'choice_label' => 'title'
            ])

            ->add('content', TextareaType::class,[
                'attr' => array(
                'placeholder' => 'your description here'
                )])

            ->add('image', TextType::class,[
                'attr' => array(
                'placeholder' => 'http://placehold.it/350x150'
                )])
                
            ->add('Save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'method' => ['post', 'get']
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
