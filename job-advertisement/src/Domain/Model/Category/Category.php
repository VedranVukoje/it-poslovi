<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace JobAd\Domain\Model\Category;

use JobAd\Domain\Model\JobAdvertisement\JobAdvertisement;
use JobAd\Domain\Model\JobAdvertisement\Adapter\JobAdvertisementCollection;
/**
 * Description of Category
 * 
 * @author vedran
 */
class Category
{
    /**
     *
     * @var Id
     */
    protected $id;
    
    /**
     *
     * @var Name
     */
    protected $name;
    
    /**
     *
     * @var JobAdvertisement 
     */
    protected $jobAdvertisement;
    
    
    public function __construct(Id $id)
    {
        $this->id = $id;
        $this->jobAdvertisement = new JobAdvertisementCollection();
    }
    
    public function id()
    {
        return $this->id;
    }
    
    public function name()
    {
        return $this->name;
    }
    
    public function __toString()
    {
        return (string) $this->name;
    }
    
    /**
     * @todo assertion ubaci !!!!
     * @param string $name
     * @return \static
     */
    public static function fromName(string $name)
    {
        $category = new static(Id::generate());
        $category->name = new Name($name);
        
        return $category;
    }
    /**
     * @todo u proxy hidrator ..... 
     * @param array $data
     * @return \self
     */
    public static function hydrate(array $data): self
    {
        $category = new static(Id::fromNative($data['id']));
        $category->name = new Name($data['name']);
        
        
        return $category;
    }

    public static function fromNative($id, $name)
    {
        $category = new static(Id::fromNative($id));
        $category->name = new Name($name);
        
        return $category;
    }
    
    public function setJobAdvertisement(JobAdvertisement $jobAdvertisement)
    {
        $this->jobAdvertisement[] = $jobAdvertisement;
    }
    
    public function extract(): array
    {
        return [
            'id' => (string) $this->id,
            'name' => (string) $this->name
        ];
    }
    
}