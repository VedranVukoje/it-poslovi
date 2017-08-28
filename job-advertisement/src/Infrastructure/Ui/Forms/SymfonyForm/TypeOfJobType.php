<?php

namespace JobAd\Infrastructure\Ui\Forms\SymfonyForm;

use JobAd\Domain\Model\TypeOfJob\Status;
use JobAd\Domain\Model\TypeOfJob\StatusNames;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

// u construct imas u Applications interface....
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
/**
 * Description of TypeOfJobType
 *
 * @author vedran
 */
class TypeOfJobType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
//        dump(Status::fromNative(2));
//        Status::fromNative();
        $builder->add('id', HiddenType::class)
                ->add('name', TextType::class)
                ->add('status', ChoiceType::class, [
                    'choices' => (new StatusNames)->datat()
                ])
                ->add('save', SubmitType::class);
        
//        $transformer = new CallbackTransformer(
//                function($status) {
//            return (string) $status;
//        }, function($status) {
//            return [$status];
//        });
//        $builder->get('status')->addModelTransformer($transformer);
    }

}
