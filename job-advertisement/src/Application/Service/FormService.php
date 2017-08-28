<?php


namespace JobAd\Application\Service;


use JobAd\Application\Contract\Form;
use JobAd\Domain\Model\TypeOfJob\TypeOfJob;
/**
 * Description of FormService
 *
 * @author vedran
 */
class FormService
{
    
    private $fomr;
    
    public function __construct(Form $form)
    {
        $this->fomr = $form;
    }
    
    /**
     * 
     * @param type $type
     * @param type $data
     * @param type $options
     * @return type
     */
    public function execute($type, $data = null, array $options = [])
    {
        return $this->fomr->create($type, $data, $options);
    }
}
