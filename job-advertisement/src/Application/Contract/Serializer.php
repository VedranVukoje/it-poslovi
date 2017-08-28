<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\Contract;

/**
 * JobAd\Application\Contract\Serializer
 * @author vedran
 */
interface Serializer
{
    public function serialize($data, $format);
    public function deserialize($serializeData, $fqcn, $format);
}
