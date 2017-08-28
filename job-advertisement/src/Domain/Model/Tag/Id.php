<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\Tag;

Use JobAd\Domain\ValueObjects\UuidIdentifier;
use Ramsey\Uuid\Uuid;

/**
 * Description of Id
 *
 * @author vedran
 */
class Id extends UuidIdentifier
{

    protected $value;

    public function __construct(Uuid $value)
    {
        $this->value = $value;
    }

}
