<?php

namespace JobAd\Domain\Model\JobAdvertisement;

use DateTimeImmutable;
use JobAd\Domain\AggregateRoot;
use JobAd\Domain\EventStream;
use JobAd\Domain\DomainEvent;
use JobAd\Domain\Model\JobAdvertisement\Events\JobAdWasDrafted;
use JobAd\Domain\Model\JobAdvertisement\Events\CategoryWasAddedToJobAdvertisement;
use JobAd\Domain\Model\JobAdvertisement\Events\TypeOfJobWasAddedToJobAdvertisement;
use JobAd\Domain\Model\JobAdvertisement\Events\CityWasAddedToJobAdvertisement;
use JobAd\Domain\Model\JobAdvertisement\Events\DurationWasAddedToAd;
use JobAd\Domain\Model\JobAdvertisement\Events\TagWasAddedToJobAd;
use JobAd\Domain\Model\JobAdvertisement\Events\JobAdDescriptionsWasManaged;
use JobAd\Domain\Model\JobAdvertisement\Events\JobAdCategoresWsaManaged;
use JobAd\Domain\Model\JobAdvertisement\Events\JobAdTagsWasManaged;
use JobAd\Domain\Model\JobAdvertisement\Events\JobAdTypeOfJobsWasManaged;
use JobAd\Domain\Model\TypeOfJob\TypeOfJob;
use JobAd\Domain\Model\Category\Adapter\CategoryCollection;
use JobAd\Domain\Model\TypeOfJob\Adapter\TypeOfJobCollection;
use JobAd\Domain\Model\Tag\Adapter\TagCollection;
use JobAd\Domain\Model\Location\City;
use JobAd\Domain\Model\Location\PostCode;
use JobAd\Domain\Model\Category\Category;
use JobAd\Domain\Model\Tag\Tag;
use JobAd\Domain\Model\JobAdvertisement\Exceptions\TimeInThePastException;

/**
 * Description of JobAdvertisement
 * JobAd\Domain\Model\JobAdvertisement\JobAdvertisement
 * @author vedran
 */
class JobAdvertisement extends AggregateRoot
{

    /**
     * Minimalno vreme u satima koje oglas ceka na odobrenje.
     */
    const ADMIN_APPROVAL_TIME = '+24 hours';
    
    private $isNew = false;
    /**
     *
     * @important obavezno kastovati ValueObject JobAd\Domain\Model\JobAdvertisement\Id u string. 
     * Iz nekog razloga Doctrine Optimistic Locking sam proverava 
     * verziju ispod haube SELECT version FROM JobAdvertisement WHERE id = '$id'
     *  $id je ValueObjekat JobAd\Domain\Model\JobAdvertisement\Id Tip .
     * Doktrin ispod haube okine ovaj upit za proveru verzije ovako.
     * SELECT 
     *  version 
     * FROM 
     *  JobAdvertisement WHERE id = '(object(JobAd\Domain\Model\JobAdvertisement\Id:"3c0af362-631e-42da-96d7-c5433014c973"))'
     * sto je progresno .
     * iz ovog razloga ValueObject JobAd\Domain\Model\JobAdvertisement\Id momrao
     * kastovati u string.
     * 
     * ValueObject JobAd\Domain\Model\JobAdvertisement\Id je takodje mapiran kao
     * custom tip. 
     * ne znam gde je jos greska i da li je gresa?
     * @var string!
     */
    protected $id;
    
    /**
     * @todo proveri zasto je u dokumentaciji samo $version ?
     * Optimistic Locking
     */
    protected $version = 1;
    /**
     *
     * @var PozitonTitle 
     */
    protected $pozitonTitle;

    /**
     *
     * @var Description
     */
    protected $description;

    /**
     *
     * @var HowToApplay
     */
    protected $howToApply;

    /**
     *
     * @var CategoryCollection[] 
     */
    protected $categoryes;

    /**
     *
     * @var JobAd\Domain\Model\Location\City
     */
    protected $city;

    /**
     *
     * @var TypeOfJobCollection[] 
     * 
     */
    protected $typeOfJobs;

    /**
     *
     * @var Status
     */
    protected $status;

    /**
     * 
     * Vreme pocetka trajanja oglasa
     * @var DateTimeImmutable
     */
    protected $start;

    /**
     * 
     * Vreme kraja trajanja oglasa
     * @var DateTimeImmutable 
     */
    protected $end;

    /**
     *
     * @var TagCollection[] 
     */
    protected $tags;

    /**
     *
     * @var DateTimeImmutable 
     */
    protected $createdAt;

    /**
     *
     * @var DateTimeImmutable
     */
    protected $updatedAt;
    // ovo tek treba da dodje.
    protected $user = 1;

    /**
     * 
     * @param \JobAd\JobAdvertisment\DomainModel\Id $id
     */
    public function __construct(Id $id)
    {
        $this->id = (string) $id;
        $this->typeOfJobs = new TypeOfJobCollection();
        $this->categoryes = new CategoryCollection();
        $this->tags = new TagCollection();
    }

    public function id()
    {
        return Id::fromNative($this->id);
    }
    
    public function version()
    {
        return $this->version;
    }
    
    public function isNew(): bool
    {
        return $this->isNew;
    }

    public function pozitonTitle()
    {
        return $this->pozitonTitle;
    }

    public function city()
    {
        return $this->city;
    }

    /**
     * 
     * @todo ovo mislim da se ne koristi !
     * @return type
     */
    public function cityAndPostCodeAsArray()
    {
        return [
            'name' => (string) $this->city,
            'postCode' => (string) $this->city->postCode()
        ];
    }

    public function categoryes()
    {
        return $this->categoryes;
    }

    public function typeOfJobs()
    {
        return $this->typeOfJobs;
    }

    public function description()
    {
        return $this->description;
    }

    public function howToApply()
    {
        return $this->howToApply;
    }

    public function tags()
    {
        return $this->tags;
    }

    public function duration()
    {
        return $this->end;
    }
    
    public function createdAt()
    {
        return $this->createdAt;
    }
    
    public function updatedAt()
    {
        return $this->updatedAt;
    }

    public static function reconstitute(EventStream $history)
    {
        $jobAd = new static($history->id());
        
        foreach($history->stream() as $event){
            $jobAd->applyTaht($event);
        }
        
        return $jobAd;
    }
    
    public static function reconstituteFromDomainEvent(DomainEvent $event)
    {
        $jobAd = new static($event->id());
        $jobAd->applyTaht($event);
        return $jobAd;
    }
    
    public function doApplayByDomainEvent(DomainEvent $event)
    {
        $this->applyTaht($event);
    }
    
//    public static function hydrate(array $data): self
//    {
//        $jobAdd = new static($data['id']);
//        
//        return $jobAdd;
//    }

    /**
     * 
     * @param \JobAd\JobAdvertisment\DomainModel\CompanyName $name
     * @param type $category
     * @param type $description
     * @param type $howToApplay
     */
    public static function draft(string $pozitonTitle, string $description, string $howToApplay)
    {
        $draft = new static(Id::generate());

        $draft->recordApplayAndPublihThat(
                new JobAdWasDrafted(
                $draft->id(), new PozitonTitle($pozitonTitle), new Description($description), new HowToApplay($howToApplay)
        ));
        
        $draft->updateTimestam();

        return $draft;
    }

    public function manageJobAdDescriptions(string $pozitonTitle, string $description, string $howToApplay)
    {
        $this->recordApplayAndPublihThat(
                new JobAdDescriptionsWasManaged(
                $this->id(), new PozitonTitle($pozitonTitle), new Description($description), new HowToApplay($howToApplay)
        ));
        $this->updateTimestam();
    }

    public function addTypeOfJob(TypeOfJob $typeOfJob)
    {
        $event = new TypeOfJobWasAddedToJobAdvertisement($this->id, $typeOfJob);
        $this->recordApplayAndPublihThat($event);
        $this->updateTimestam();
    }
    
    public function manageTypeOfJobs(TypeOfJobCollection $new)
    {
        $add = new TypeOfJobCollection();
        $remove = new TypeOfJobCollection();

        foreach ($new as $typeOfJob) {
            if (!$this->typeOfJobs->contains($typeOfJob)) {
                $add[] = $typeOfJob;
            }
        }

        foreach ($this->typeOfJobs as $typeOfJobs) {
            if (!$new->contains($typeOfJobs)) {
                $remove[] = $typeOfJob;
            }
        }
        
        $this->recordApplayAndPublihThat(new JobAdTypeOfJobsWasManaged($this->id(), $new, $add, $remove));
        $this->updateTimestam();
    }


//    public function addTypeOfJob(string $id, string $name, string $createdAt = '', string $updatedAt = '')
//    {
//        $typeOfJob = TypeOfJob::creteAsActive($id, $name, $createdAt, $updatedAt);
//        $event = new TypeOfJobWasAddedToJobAdvertisement($this->id, $typeOfJob);
//        $this->recordApplayAndPublihThat($event);
//    }

    public function addCategory(Category $category)
    {

        $event = new CategoryWasAddedToJobAdvertisement($this->id(), $category);
        $this->recordApplayAndPublihThat($event);
        $this->updateTimestam();
    }

    public function manageCategores(CategoryCollection $new)
    {
        
        $add = new CategoryCollection();
        $remove = new CategoryCollection();

        foreach ($new as $category) {
            if (!$this->categoryes->contains($category)) {
                $add[] = $category;
            }
        }

        foreach ($this->categoryes as $category) {
            if (!$new->contains($category)) {
                $remove[] = $category;
            }
        }
        
        $this->recordApplayAndPublihThat(new JobAdCategoresWsaManaged($this->id(), $new, $add, $remove));
        $this->updateTimestam();
    }

//    public function addCategory($id, $name)
//    {
//        $category = Category::fromNative($id, $name);
//        $event = new CategoryWasAddedToJobAdvertisement($this->id, $category);
//        $this->recordApplayAndPublihThat($event);
//    }

    public function addCity(int $postCode, string $city)
    {
        $event = new CityWasAddedToJobAdvertisement($this->id(), new City(new PostCode($postCode), $city));
        $this->recordApplayAndPublihThat($event);
        $this->updateTimestam();
    }

    public function addAdDuration(string $duration)
    {

        $duration = new DateTimeImmutable($duration);
        $this->assertDuration($duration);
        $this->recordApplayAndPublihThat(new DurationWasAddedToAd($this->id(), $duration));
        $this->updateTimestam();
    }

    public function addTag(Tag $tag)
    {
        $this->recordApplayAndPublihThat(new TagWasAddedToJobAd($this->id(), $tag));
        $this->updateTimestam();
    }

    public function manageTags(TagCollection $new)
    {

        $add = new TagCollection();
        $remove = new TagCollection();

        foreach ($new as $tag) {
            if (!$this->tags->contains($tag)) {
                $add[] = $tag;
            }
        }

        foreach ($this->tags as $tag) {
            if (!$new->contains($tag)) {
                $remove[] = $tag;
            }
        }

        $this->recordApplayAndPublihThat(new JobAdTagsWasManaged($this->id(), $new, $add, $remove));
        $this->updateTimestam();
    }

    public function updateTimestam()
    {
        $this->updatedAt = new \DateTimeImmutable();

        if (null === $this->createdAt) {
            $this->createdAt = new \DateTimeImmutable();
        }
    }
    
//    public function extract(): array
//    {
//        
//        $categoryes = iterator_to_array($this->categoryes->map(function($category){
//            return ['id' => (string) $category->id(), 'name' => (string) $category->name()];
//        }));
//        
//        $typeOfJobs = iterator_to_array($this->typeOfJobs->map(function($typeOfJob){
//            return ['id' => (string) $typeOfJob->id(), 'name' => (string) $typeOfJob->name()];
//        }));
//        
//        $tags = iterator_to_array($this->tags->map(function($tag){
//            return ['id' => (string) $tag->id(), 'name' => (string) $tag->name()];
//        }));
//        
//        return [
//            'id' => $this->id,
//            'version' => $this->version,
//            'pozitonTitle' => (string) $this->pozitonTitle,
//            'description' => (string) $this->description,
//            'howToApplay' => (string) $this->howToApplay,
//            'categoryes' => $categoryes,
//            'city' => [
//                'postCode' => is_null($this->city)? '': (string) $this->city->postCode(), 
//                'name' => (string) $this->city
//                ],
//            'typeOfJobs' => $typeOfJobs,
//            'status' => (string) $this->status,
//            'end' => is_null($this->end)? null:$this->end->format('d.m.Y'),
//            'tags' => $tags,
//            'createdAt' => $this->createdAt->format('d.m.Y H:i:s'),
//            'updatedAt' => $this->updatedAt->format('d.m.Y H:i:s')
//        ];
//    }
    
    public function status()
    {
        return $this->status;
    }

    public function isDrafted()
    {
        return $this->status->equals(Status::draft());
    }

    protected function applyJobAdDescriptionsWasManaged(JobAdDescriptionsWasManaged $event)
    {
        $this->id = (string) $event->id();
        $this->pozitonTitle = $event->pozitonTitle();
        $this->howToApplay = $event->howToApplay();
        $this->description = $event->description();
//        $this->updateTimestam();
    }

    protected function applyJobAdWasDrafted(JobAdWasDrafted $event)
    {
        $this->id = (string) $event->id();
        $this->pozitonTitle = $event->pozitonTitle();
        $this->howToApplay = $event->howToApplay();
        $this->description = $event->description();
        $this->setStatus(Status::draft());
//        $this->updateTimestam();
        $this->isNew = true;
    }

    protected function applyCategoryWasAddedToJobAdvertisement(CategoryWasAddedToJobAdvertisement $event)
    {
        /**
         * @todo ovako ne treba... samo $this->categoryes[] = $event->category()
         */
        $category = $event->category();
        $category->setJobAdvertisement($this);
        $this->categoryes[] = $category;
//        $this->updateTimestam();
    }

    protected function applyJobAdCategoresWsaManaged(JobAdCategoresWsaManaged $event)
    {
        
        $this->id = (string) $event->id();
        
        if (0 < count($event->remove())) {
            foreach ($event->remove() as $category) {
                $this->categoryes->removeElement($category);
            }
        }
        if (0 < count($event->add())){
            foreach ($event->add() as $category) {
                $this->categoryes[] = $category;
            }
        }
//        $this->updateTimestam();
    }

    protected function applyTypeOfJobWasAddedToJobAdvertisement(TypeOfJobWasAddedToJobAdvertisement $event)
    {
        $this->typeOfJobs[] = $event->typeOfJob();
//        $this->updateTimestam();
    }
    
    protected function applyJobAdTypeOfJobsWasManaged(JobAdTypeOfJobsWasManaged $event)
    {
        $this->id = (string) $event->id();
        
        if(0 < count($event->remove())){
            foreach($event->remove() as $typeOfJob){
                $this->typeOfJobs->removeElement($typeOfJob);
            }
        }
        if(0 < count($event->add())){
            foreach($event->add() as $typeOfJob){
                $this->typeOfJobs[] = $typeOfJob;
            }
        }
//        $this->updateTimestam();
    }

    protected function applyCityWasAddedToJobAdvertisement(CityWasAddedToJobAdvertisement $event)
    {
//        dump($event);
        $this->id = (string) $event->id();
        $this->city = $event->city();
//        $this->updateTimestam();
    }

    protected function applyDurationWasAddedToAd(DurationWasAddedToAd $event)
    {
        $this->id = (string) $event->id();
        $this->end = $event->duration();
        $this->updateTimestam();
    }

    protected function applyTagWasAddedToJobAd(TagWasAddedToJobAd $event)
    {
        $this->id = (string) $event->id();
        $this->tags[] = $event->tag();
//        $this->updateTimestam();
    }

    protected function applyJobAdTagsWasManaged(JobAdTagsWasManaged $event)
    {
        $this->id = (string) $event->id();
        
        if(0 < count($event->remove())){
            foreach ($event->remove() as $tag){
                $this->tags->removeElement($tag);
            }
        }
        if(0 < count($event->add())){
            foreach($event->add() as $tag){
                $this->tags[] = $tag;
            }
        }
//        $this->updateTimestam();
    }

    private function setStatus(Status $status)
    {
        $this->status = $status;
    }
    
    

    /**
     * 
     * @param DateTimeImmutable $start
     * @param DateTimeImmutable $end
     * @throws TimeInThePastException
     */
    private function assertDuration(DateTimeImmutable $end)
    {

        $createdAt = $this->createdAt->setTime(0, 0, 0);
        $end = $end->setTime(0, 0, 0);

//        dump($createdAt->format('Y-m-d\TH:i:s.uO'));
//        dump($createdAt->getTimestamp());
//        
//        dump($start->format('Y-m-d\TH:i:s.uO'));
//        dump($start->getTimestamp());



        if ($createdAt > $end) {
            throw new TimeInThePastException('Vreme trajanja oglasa (Trajanje:) ne moze biti u proslosti.');
        }
    }

}
