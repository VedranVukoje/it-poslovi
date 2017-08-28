<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\Service\Location;

use JobAd\Application\Service\ApplicationService;
use JobAd\Application\Service\ServiceApplicationDecorator;
use JobAd\Domain\Model\Location\CityRepository;
use JobAd\Domain\SpecificationFactory;
use JobAd\Domain\Model\Location\Exception\CityNotFoundException;

/**
 * ViewCitiesService je servis koji nam iz postCode ( $request ) vraca 
 * BaseResponse::response [].
 * JobAd\Application\Service\Location\ViewCityService
 * @author vedran
 */
class ViewCitiesService extends ServiceApplicationDecorator implements ApplicationService
{

    private $appService;
    private $repo;
    private $spec;

    public function __construct(ApplicationService $appService, CityRepository $repo, SpecificationFactory $spec)
    {
        $this->appService = $appService;
        $this->repo = $repo;
        $this->spec = $spec;
    }

    public function execute($request = null)
    {
        
        $query = $this->spec->cityByPostCodes($request->city['postCode']);
        $cities = $this->repo->query($query);

        if (0 == count($cities)) {
            throw new CityNotFoundException(sprintf('Post Code "%s" ne postoji.', $request->city['postCode']));
        }

        $response = (new ViewCitiesFormResponse)->assemble($cities)->cities;
        return $this->appService->execute($request)->set('app.service.location.cities', $response);
    }

}
