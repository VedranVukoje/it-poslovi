<?php

namespace JobAd\Application\Service\JobAdvertisement;

//use JobAd\Application\Event\EventDispatcher;
use JobAd\Application\Service\ApplicationService;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisement as JobAd;
use JobAd\Domain\Model\JobAdvertisement\Id;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisementRepository;
use JobAd\Domain\Model\JobAdvertisement\Assembler;

//use JobAd\Domain\Model\Tag\Tag;
//use JobAd\Domain\Model\JobAdvertisement\JobAddIsDrafted;
//use JobAd\Domain\Model\JobAdvertisement\Id as JobAdId;
//use JobAd\Domain\Model\JobAdvertisement\PozitonTitle;
//use JobAd\Domain\Model\JobAdvertisement\Description;
//use JobAd\Domain\Model\JobAdvertisement\HowToApplay;
//use JobAd\Domain\Model\TypeOfJob\TypeOfJobRepository;
//use JobAd\Domain\Model\Location\CityRepository;
//use JobAd\Domain\Model\Location\PostCode;
//use JobAd\Domain\Model\Category\CategoryRepository;
//use JobAd\TypeOfJob\DomainModel\Id as TypeOfJobId;
/**
 * Description of WriteJobAdvertisementService
 * JobAd\Application\Service\JobAdvertisement\DraftAdvertisementService
 * @author vedran
 */
class DraftAdvertisementService implements ApplicationService
{

    private $repo;
    private $appService;
    private $assembler;

    /**
     * 
     * @todo Repository u Dekorator || ?Lanac Odgovornosti 
     * i prilagoditi metodu execute .... 
     * 
     * @param JobAdvertisementRepository $repo
     * @param Assembler $assembler
     */
    public function __construct(
    ApplicationService $appService, JobAdvertisementRepository $repo, Assembler $assembler)
    {
        $this->appService = $appService;
        $this->repo = $repo;
        $this->assembler = $assembler;
    }

    public function execute($request = null)
    {
        
//        dump($request);
        if ($request->id) {
            dump('edig......');
            $jobAd = $this->repo->ofId(Id::fromNative($request->id), $request->version);
            $jobAd->manageJobAdDescriptions($request->pozitonTitle, $request->description, $request->howToApllay);
        } else {
            $jobAd = JobAd::draft($request->pozitonTitle, $request->description, $request->howToApllay);
        }
        dump($jobAd);
        $jobAd->addAdDuration($request->end);
        $this->repo->add($jobAd);
        
//        $request->id = (string) $jobAd->id();
        
        dump('Draftovan.....');
        return $this->appService->execute($request)
                ->set('jobAdId', (string) $jobAd->id())
                ->set('jobAdVersion', (int) $jobAd->version());
    }

}
