<?php

namespace JobAd\Domain\Model\JobAdvertisement;

use DateTimeImmutable;
use JobAd\Domain\AggregateRoot;
use JobAd\Domain\EventStream;
use JobAd\Domain\DomainEvent;
use JobAd\Domain\Model\JobAdvertisement\Events\JobAdWasDrafted;
//use JobAd\Domain\Model\JobAdvertisement\Events\CategoryWasAddedToJobAdvertisement;
use JobAd\Domain\Model\JobAdvertisement\Events\TypeOfJobWasAddedToJobAd;
use JobAd\Domain\Model\JobAdvertisement\Events\TypeOfJobWasRemovedFromJobAd;
use JobAd\Domain\Model\JobAdvertisement\Events\CityWasAddedToJobAdvertisement;
use JobAd\Domain\Model\JobAdvertisement\Events\DurationWasAddedToAd;
use JobAd\Domain\Model\JobAdvertisement\Events\TagWasAddedToJobAd;
use JobAd\Domain\Model\JobAdvertisement\Events\JobAdDescriptionsWasManaged;
//use JobAd\Domain\Model\JobAdvertisement\Events\JobAdCategoresWsaManaged;
//use JobAd\Domain\Model\JobAdvertisement\Events\JobAdTagsWasManaged;
//use JobAd\Domain\Model\JobAdvertisement\Events\JobAdTypeOfJobsWasManaged;
use JobAd\Domain\Model\JobAdvertisement\Events\StatusWasChangedToDrafted;
use JobAd\Domain\Model\JobAdvertisement\Events\CategoryWasAddToJobAd;
use JobAd\Domain\Model\JobAdvertisement\Events\CategoryWasRemoveFromJobAd;
use JobAd\Domain\Model\JobAdvertisement\Events\TagWasRemovedFromJobAd;
use JobAd\Domain\Model\TypeOfJob\TypeOfJob;
use JobAd\Domain\Model\Category\Adapter\CategoryCollection;
use JobAd\Domain\Model\TypeOfJob\Adapter\TypeOfJobCollection;
use JobAd\Domain\Model\Tag\Adapter\TagCollection;
use JobAd\Domain\Model\Location\City;
use JobAd\Domain\Model\Location\PostCode;
use JobAd\Domain\Model\Category\Category;
//use JobAd\Domain\Model\Category\Id as CategoryId;
//use JobAd\Domain\Model\Category\CategoryHydrator;
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

    public function id(): Id
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

    public function pozitonTitle(): PozitonTitle
    {
        return $this->pozitonTitle;
    }

    public function city(): City
    {
        return $this->city;
    }

    public function categoryes(): \JobAd\Domain\Collection
    {
        return $this->categoryes;
    }

    public function typeOfJobs(): \JobAd\Domain\Collection
    {
        return $this->typeOfJobs;
    }

    public function description(): Description
    {
        return $this->description;
    }

    public function howToApply(): HowToApply
    {
        return $this->howToApply;
    }

    public function tags(): \JobAd\Domain\Collection
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

        foreach ($history->stream() as $event) {
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
        
        return $this;
    }


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
                new JobAdWasDrafted($draft->id, $pozitonTitle, $description, $howToApplay
        ));
        
        return $draft;
    }

    public function manageJobAdDescriptions(string $pozitonTitle, string $description, string $howToApplay)
    {
        $this->recordApplayAndPublihThat(new JobAdDescriptionsWasManaged($this->id, $pozitonTitle, $description, $howToApplay));
    }

    public function addTypeOfJob(string $id, string $name)
    {
        $this->recordApplayAndPublihThat(new TypeOfJobWasAddedToJobAd($this->id, $id, $name));
    }
    
    public function removeTypeOfJob(string $id)
    {
        $this->recordApplayAndPublihThat(new TypeOfJobWasRemovedFromJobAd($this->id, $id));
    }

    public function addCategory(string $id, string $name)
    {
        $this->recordApplayAndPublihThat(new CategoryWasAddToJobAd($this->id, $id, $name));
    }
    
    public function removeCategory(string $id)
    {
        $this->recordApplayAndPublihThat(new CategoryWasRemoveFromJobAd($this->id, $id));
    }
    
    public function addCity(int $postCode, string $city)
    {
        $this->recordApplayAndPublihThat(new CityWasAddedToJobAdvertisement($this->id, $postCode, $city));
    }

    public function addAdDuration(string $duration)
    {
        $this->assertDuration(new DateTimeImmutable($duration));
        $this->recordApplayAndPublihThat(new DurationWasAddedToAd($this->id, $duration));
    }

    public function addTag(string $id, string $name)
    {
        $this->recordApplayAndPublihThat(new TagWasAddedToJobAd($this->id, $id, $name));
    }
    
    public function removeTag(string $id)
    {
        $this->recordApplayAndPublihThat(new TagWasRemovedFromJobAd($this->id, $id));
    }

    public function changeStatusToDraft()
    {
        $this->recordApplayAndPublihThat(new StatusWasChangedToDrafted($this->id, (string) Status::draft()));
    }

    public function updateTimestam()
    {
        $this->updatedAt = new \DateTimeImmutable();

        if (null === $this->createdAt) {
            $this->createdAt = new \DateTimeImmutable();
        }
    }

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

        $this->id = $event->id();
        $this->pozitonTitle = new PozitonTitle($event->pozitonTitle());
        $this->description = new Description($event->description());
        $this->howToApply = new HowToApply($event->howToApply());
        $this->updateTimestam();
    }

    protected function applyJobAdWasDrafted(JobAdWasDrafted $event)
    {
        $this->id = $event->id();
        $this->pozitonTitle = new PozitonTitle($event->pozitonTitle());
        $this->howToApply = new HowToApply($event->howToApply());
        $this->description = new Description($event->description());
        $this->setStatus(Status::draft());
        $this->updateTimestam();
        $this->isNew = true;
    }

    protected function applyTypeOfJobWasAddedToJobAd(TypeOfJobWasAddedToJobAd $event)
    {
        $this->typeOfJobs[] = TypeOfJob::fromIdAndName($event->typeOfJobId(), $event->typeOfJobName());
        $this->updateTimestam();
    }
    
    protected function applyTypeOfJobWasRemovedFromJobAd(TypeOfJobWasRemovedFromJobAd $event)
    {
        foreach ($this->typeOfJobs as $key => $typeOfJob){
            if((string) $typeOfJob->id() == $event->typeOfJobId()){
                unset($this->typeOfJobs[$key]);
            }
        }
        
        $this->updateTimestam();
    }

    protected function applyCityWasAddedToJobAdvertisement(CityWasAddedToJobAdvertisement $event)
    {
        $this->id = $event->id();
        $this->city = new City(new PostCode($event->postCode()), $event->city());
        $this->updateTimestam();
    }

    protected function applyDurationWasAddedToAd(DurationWasAddedToAd $event)
    {
        
        $this->id = $event->id();
        $this->end = new DateTimeImmutable($event->duration());
        $this->updateTimestam();
    }

    protected function applyTagWasAddedToJobAd(TagWasAddedToJobAd $event)
    {
        $this->tags[] = Tag::fromIdAndName($event->tagId(),$event->name());
        $this->updateTimestam();
    }
    
    protected function applyTagWasRemovedFromJobAd(TagWasRemovedFromJobAd $event)
    {
        
        foreach ($this->tags as $key => $tag){
            if( (string) $tag->id() == $event->tagId()){
                unset($this->tags[$key]);
            }
        }
        $this->updateTimestam();
    }

    protected function applyCategoryWasAddToJobAd(CategoryWasAddToJobAd $event)
    {
        $this->categoryes[] = Category::fromNative($event->categoryId(), $event->name());
        $this->updateTimestam();
    }
    
    protected function applyCategoryWasRemoveFromJobAd(CategoryWasRemoveFromJobAd $event)
    {
        
        foreach ($this->categoryes as $key => $category){
            if((string)$category->id() == $event->categoryId()){
                unset($this->categoryes[$key]);
            }
        }

        $this->updateTimestam();
    }

    protected function applyStatusWasChangedToDrafted(StatusWasChangedToDrafted $event)
    {
        $this->setStatus(Status::fromNative($event->status()));
    }

    private function setStatus(Status $status)
    {
        $this->status = $status;
    }

    /**
     * 
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
