<?php

namespace JobAd\Application\Service\JobAdvertisement;

//use JobAd\Application\Event\EventDispatcher;
use JobAd\Application\Service\ApplicationService;
use Psr\Log\LoggerInterface;
use JobAd\Domain\Model\Category\Exceptions\CategoresNotFoundException;
use JobAd\Domain\Model\Location\Exception\CityNotFoundException;
use JobAd\Domain\Model\JobAdvertisement\Exceptions\OnlyOneCityPerJobAd;
use JobAd\Domain\Model\Category\Exceptions\TypeOfJobNotFoundException;
use JobAd\Domain\Model\JobAdvertisement\RepositoryFactory;
use JobAd\Domain\Model\JobAdvertisement\JobAdvertisement as DomainJobAd;
use JobAd\Domain\Model\JobAdvertisement\Id;
//use JobAd\Domain\Model\JobAdvertisement\JobAdvertisementRepository;
//use JobAd\Domain\Model\JobAdvertisement\Assembler;

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
class DraftAdvertisementService extends JobAd implements ApplicationService
{
    
    private $appService;
    private $logger;
    /**
     *  
     * 
     * @param RepositoryFactory $repoFactory
     */
    public function __construct(ApplicationService $appService, RepositoryFactory $repoFactory, LoggerInterface $logger)
    {
        $this->appService = $appService;
        $this->logger = $logger;
        parent::__construct($repoFactory);
    }

    public function execute($request = null)
    {
        
        if ($request->id) {
            $jobAd = $this->ofId(Id::fromNative($request->id));
            /**
             * @todo
             * ovo ubaciti u try catch exception.. npr za Doctrine ovde ce baciti Optimistic Lock Exception....
             */
            $this->lock($jobAd, (int) $jobAd->version());
            $jobAd->manageJobAdDescriptions($request->pozitonTitle, $request->description, $request->howToApllay);
        } else {
            $jobAd = DomainJobAd::draft($request->pozitonTitle, $request->description, $request->howToApllay);
        }

        $jobAd->addAdDuration($request->end);
        
//        $cities = $this->cityesByPostCodes($request->city['postCode']);
//        
//        if (0 == count($cities)) {
//            throw new CityNotFoundException(sprintf('Post Code "%s" ne postoji.', $request->city['postCode']));
//        }
//        if (1 !== count($cities)) {
//            throw new OnlyOneCityPerJobAd("Samo jedna lokacija po oglasu.");
//        }
//        
//        $jobAd->addCity((string)$cities[0]->postCode(),(string)$cities[0]);
        
        
//        $categoryes = $this->categoryByArrayOfCategoryIds($request->categoryes);
//        if (0 == count($categoryes)) {
//            throw new CategoresNotFoundException("Niste izabrali kategoriju.");
//        }
//        $jobAd->manageCategores($categoryes);
        
//        $jobAd->manageTags($this->tagByArrayIds($request->tags));
//        
//        $typeOfJobs = $this->typeOfJobByArrayIds($request->typeOfJobs);
//        if(0 == count($typeOfJobs)){
//            throw new TypeOfJobNotFoundException("Morate izabrati makar jedan tip posla");
//        }
//        
//        $jobAd->manageTypeOfJobs($typeOfJobs);
        
        $this->repoFactory->jobAdRepo()->add($jobAd);

        $request->id = (string) $jobAd->id();
        $request->version = (int) $jobAd->version();
        $this->logger->debug('Job Ad was drafted ', ['jobAd' => $this->extract($jobAd)]);
        return $this->appService->execute($request)
                ->set('id', $jobAd->id());
    }

}
