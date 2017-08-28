<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\Tag;


interface TagRepository
{
    public function nextIdentity();
    public function ofId(Id $id): Tag;
    public function add(Tag $tag);
    public function query($specification);
}
