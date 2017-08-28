<?php

namespace JobAd\Infrastructure\Adapter;

use JobAd\Application\Contract\Form;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Description of SymfonyFormFactory
 *
 * @author vedran
 */
class SymfonyFormFactory implements Form
{
    private $form;
    
    public function __construct(FormFactoryInterface $form)
    {
        $this->form = $form;
    }
    
    public function create($type, $data = null, array $options = array())
    {
        return $this->form->create($type, $data, $options);
    }
}
