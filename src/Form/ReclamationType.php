<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('contenue', null, [
            'label' => 'Contenu de la réclamation',
            'attr' => ['class' => 'form-control mb-3', 'rows' => 8] // Par exemple, 8 lignes
        ])
        
            
            ->add('id_utilisateur', null, [
                'label' => 'ID de l\'utilisateur',
                'attr' => ['class' => 'form-control mb-3']
            ])
            
            // Section Statut de la Réclamation
            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'Envoyé' => 'envoyé',
                    'Vu' => 'vu',
                    'Répondu' => 'repondu',
                ],
                'label' => 'Statut de la réclamation',
                'attr' => ['class' => 'form-control mb-3']
            ])
            
            // Section Date de Création
            ->add('date_en_jour', null, [
                'label' => 'Date de création',
                'attr' => ['class' => 'form-control mb-3']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
