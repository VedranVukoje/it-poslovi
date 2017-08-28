<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Domain\Model\Tag;

/**
 * Description of Tags
 * JobAd\Domain\Model\Tag\Tag
 * @author vedran
 */
class Tag
{

    private $id;
    private $name;
    /**
     *
     * @todo ValueObject Slug sada nema !!!.
     * @var Slug 
     */
    private $slug;
    /**
     * @todo.
     * @var type 
     */
    private $tagIcon;

    public function __construct(Id $id, Name $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->setSlug($name);
    }

    public static function fromName(string $name)
    {
        return new static(Id::generate(), new Name($name));
    }

    public function id()
    {
        return $this->id;
    }

    public function name()
    {
        return $this->name;
    }

    public function slug()
    {
        return $this->slug;
    }
    
    private function setSlug(Name $slug)
    {
        /**
         * @todo
         * https://stackoverflow.com/questions/2955251/php-function-to-make-slug-url-string
         * Instead of a lengthy replace, try this one:
         * 
         * nema npr latinicna slova ....
         */ 
        $this->slug = preg_replace('/[^A-Za-z0-9-]+/', '-', (string) $slug);
    }

}
