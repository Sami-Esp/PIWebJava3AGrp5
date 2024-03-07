<?php


namespace App\Form;

use App\Entity\Don;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;




class DonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom')
         ->add('prenom')
         ->add('email')
         ->add('telephone')
         ->add('type', ChoiceType::class, [
            'choices' => [
                'Objet' => 'objet',
                'Argent' => 'Argent',
            ],
            
        ])
               ->add('montant', IntegerType::class, [
            'required' => false,
                'empty_data' => '-',
             
               ])
               ->add('modeDePaiement', ChoiceType::class, [
            'choices' => [
             'Carte bancaire' => 'Carte bancaire',
             'Portefeuilles électroniques' => 'Portefeuilles électroniques',
             'Autre' => 'Autre',
            ],
             
            'required' => false,
            'data' =>'-'  ,             
            
               ])
               ->add('categorie', ChoiceType::class, [
            'choices' =>['Vêtements' => 'Vêtements',
            'Meubles' => 'Meubles',
            'Appareils électroménagers' => 'Appareils électroménagers',
            'Électronique' => 'Électronique',
            'Jouets' => 'Jouets',
            'Livres' => 'Livres',
            'Autre' => 'Autre',
            
               ],
               'required' => false,
               'data' => 'Autre',
               ])
            
            
               ->add('etat',ChoiceType::class, [
            'choices' =>['Neuf' => 'Neuf',
            'Usagé' => 'Usagé',
            'Bon état' => 'Bon état',
            'Autre' => 'Autre',
            
            ] ,
            'required' => false,
              'data' =>'Neuf',
            
               ])
            
               ->add('commentaire', TextareaType::class, [
            'required' => false,
            'data' =>'-',
              
               ])
             
               ->add('label', TextType::class, [
            'required' => false,
            'data' =>'-',
              
               ])
               
              ;

                }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Don::class,
        ]);
    }
}