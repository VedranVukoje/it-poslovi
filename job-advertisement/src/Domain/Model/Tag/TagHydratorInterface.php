<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\Tag;

/**
 *
 * @author vedran
 */
interface TagHydratorInterface
{
    public function extract(Tag $tag): array;
    public function hydrate(array $data, Tag $tag): Tag;
}
