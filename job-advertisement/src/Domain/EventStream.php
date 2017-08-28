<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain;
use Ramsey\Uuid\Uuid;
/**
 * Description of EventStream
 *
 * @author vedran
 */
interface EventStream
{

    public function id(): Uuid;

    public function stream(): array;
    
    public function type(): string;
}
