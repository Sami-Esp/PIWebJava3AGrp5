<?php

namespace App\Form;

use App\Entity\Association;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use VictorPrdh\RecaptchaBundle\Form\ReCaptchaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AssociationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('telephone')
            ->add('email')
            ->add('lieu')
            ->add('codePostal')
            ->add('description')
            ->add('photo', FileType::class, [    
                // unmapped means that this field is not associated to any entity property
                'mapped' => true,
    
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                
    
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                        ],
                       
                    ])
                    
                ],
            ])
            ->add("recaptcha", ReCaptchaType::class)
            ->add('Valider', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary mx-auto d-block']
            ]);
           
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Association::class,
            
        ]);
    }
}
