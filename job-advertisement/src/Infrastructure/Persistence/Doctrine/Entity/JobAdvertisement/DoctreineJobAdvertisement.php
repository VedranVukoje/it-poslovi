<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Persistence\Doctrine\Entity\JobAdvertisement;

use JobAd\Domain\Collection;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisement;
use JobAd\Domain\Model\JobAdvertisement\Id;
use JobAd\Domain\Model\Category\Adapter\CategoryCollection;
use JobAd\Domain\Model\Tag\Adapter\TagCollection;
use JobAd\Domain\Model\TypeOfJob\Adapter\TypeOfJobCollection;

//use Doctrine\Common\Collections\ArrayCollection;

/**
 * Description of JobAdvertisement
 * /home/vedran/Projects/dev/projects/it-poslovi/job-advertisement/src/Infrastructure/Persistence/Doctrine/Entity/JobAdvertisement/DoctreineJobAdvertisement.php
 * JobAd\Infrastructure\Persistence\Doctrine\Entity\JobAdvertisement\DoctreineJobAdvertisement
 * JobAdvertisement.DoctreineJobAdvertisement.orm
 * @author vedran
 */
class DoctreineJobAdvertisement extends JobAdvertisement
{

    private $surrogateCategoryes;
    private $surrogatetypeOfJobs;
    private $surrogateTags;

    public function __construct(Id $id)
    {
        $this->surrogateCategoryes = new CategoryCollection();
        $this->surrogateTags = new TagCollection();
        $this->surrogatetypeOfJobs = new TypeOfJobCollection();
        parent::__construct($id);
    }

    public function manageCategores(CategoryCollection $new): void
    {

        foreach ($new as $category) {
            if (!$this->surrogateCategoryes->contains($category)) {
                $this->addCategory((string) $category->id(), (string) $category->name());
                $this->surrogateCategoryes->add($category);
            }
        }

        foreach ($this->surrogateCategoryes as $category) {
            if (!$new->contains($category)) {
                $this->removeCategory((string) $category->id());
                $this->surrogateCategoryes->removeElement($category);
            }
        }
    }

    public function manageTags(TagCollection $new): void
    {
        foreach ($new as $tag) {
            if (!$this->surrogateTags->contains($tag)) {
                $this->addTag((string) $tag->id(), (string) $tag->name());
                $this->surrogateTags->add($tag);
            }
        }

        foreach ($this->surrogateTags as $tag) {
            if (!$new->contains($tag)) {
                $this->removeTag((string) $tag->id());
                $this->surrogateTags->removeElement($tag);
            }
        }
    }

    public function manageTypeOfJobs(TypeOfJobCollection $new): void
    {
        foreach ($new as $typeOfJob) {
            if (!$this->surrogatetypeOfJobs->contains($typeOfJob)) {
                $this->addTypeOfJob((string) $typeOfJob->id(), (string) $typeOfJob->name());
                $this->surrogatetypeOfJobs->add($typeOfJob);
            }
        }

        foreach ($this->surrogatetypeOfJobs as $typeOfJobs) {
            if (!$new->contains($typeOfJobs)) {
                $this->removeTypeOfJob((string) $typeOfJobs->id());
                $this->surrogatetypeOfJobs->removeElement($typeOfJobs);
            }
        }
    }

    public function categoryes(): Collection
    {
        return $this->categoryes;
    }

    public function typeOfJobs(): Collection
    {
        return $this->typeOfJobs;
    }

    public function tags(): Collection
    {
        return $this->tags;
    }
    
    /**
     * @todo 
     * 11 sijecanj 2018 
     * Sta ako PersistentCollection ima veliki broj rekorda . zbog perfomansi.
     * Ovde nece biti puno ali sta uraditi?
     * - probati extendovati Doctrine\Common\Collections\Collection interface .
     */
    public function aggregate()
    {
        $this->categoryes = new CategoryCollection(array_map(function($category) {
                    return $category;
                }, $this->surrogateCategoryes->toArray()));
                
        $this->typeOfJobs = new TypeOfJobCollection(array_map(function($typeOfJob) {
                    return $typeOfJob;
                }, $this->surrogatetypeOfJobs->toArray()));
                
        $this->tags = new TagCollection(array_map(function($tag) {
                    return $tag;
                }, $this->surrogateTags->toArray()));
    }

}
