<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\Tag;

/**
 * Description of TagHydrator
 *
 * @author vedran
 */
class TagHydrator extends Tag implements TagHydratorInterface
{
    public function extract(Tag $tag): array
    {
        return [
            'id' => (string) $tag->id,
            'name' => (string) $tag->name
        ];
    }
    
    public function hydrate(array $data, Tag $tag): Tag
    {
        $tag->name = new Name($data['name']);
        
        return $tag;
    }
    
    public function __construct()
    {}
}
