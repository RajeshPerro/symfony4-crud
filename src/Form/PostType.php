<?php
/**
 * Created by PhpStorm.
 * User: rajesh
 * Date: 12/3/18
 * Time: 12:57 PM
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class PostType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm (FormBuilderInterface $builder, array $options)
    {
        // For the full reference of options defined by each form field type
        // see https://symfony.com/doc/current/reference/forms/types.html
        // By default, form fields include the 'required' attribute, which enables
        // the client-side form validation. This means that you can't test the
        // server-side validation errors from the browser. To temporarily disable
        // this validation, set the 'required' attribute to 'false':
        // $builder->add('title', null, ['required' => false, ...]);
        $builder
            ->add('title', TextType::class, [
                'attr' => ['autofocus' => true,
                'class' => 'form-control',
                'style' => 'margin-bottom:10px'
                ],
                'label' => 'your post title',
            ])
            ->add('authorName', TextType::class, [
                'attr' => ['autofocus' => true,
                    'class' => 'form-control',
                    'style' => 'margin-bottom:10px'
                ],
                'label' => 'author name',
            ])

            ->add('categorey', ChoiceType::class, [
                'placeholder' => 'choose your post type',
                'choices'  =>[
                    'Technology' => 'Technology',
                    'Business' => 'Business',
                    'Politics' => 'Politics',
                    'Culture' => 'Culture',
                    'Weather' => 'Weather',
                ],
                'attr' => ['autofocus' => true,
                    'class' => 'form-control',
                    'style' => 'margin-bottom:10px'
                ],
                'label' => 'your post type',
            ])

            ->add('description', TextareaType::class, [
                'attr' => ['autofocus' => true,
                    'class' => 'form-control',
                    'style' => 'margin-bottom:10px',
                    'rows' => 12,

                ],
                'label' => 'describe your post',

            ])

            ->add('tag', TextType::class, [
                'attr' => ['autofocus' => true,
                    'class' => 'form-control',
                    'style' => 'margin-bottom:10px',


                ],
                'label' => 'tag your topic',
                'required' => false,
            ])
            ->add('save', SubmitType::class, array('label' => 'Create Post', 'attr'=>array('class' => 'btn btn-primary')))
        ;
    }

}