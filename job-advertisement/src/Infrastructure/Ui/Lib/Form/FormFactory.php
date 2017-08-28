<?php

/*
 *  ItPoslovi
 *  Vedran Vukoje Ja:
 *  vedran.vukoje@gmail.com
 */

namespace JobAd\Infrastructure\Ui\Lib\Form;

use Symfony\Component\Form\FormFactoryInterface;
use JobAd\Application\Contract\Form;


/**
 * Description of FormFactory
 *
 * @author vedran
 */
class FormFactory implements Form
{

    private $form;

    public function __construct(FormFactoryInterface $form)
    {
        $this->form = $form;
    }

    public function create($type, $data = null, array $options = array())
    {
//        dump($this->form);
        
        return $this->form->create($type, $data, $options);
    }

}
