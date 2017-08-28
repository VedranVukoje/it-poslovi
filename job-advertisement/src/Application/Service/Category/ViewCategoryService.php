<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Application\Service\Category;

use JobAd\Domain\Model\Category\CategoryRepository;
use JobAd\Domain\Model\Category\CategorySpecificationFactory;
use JobAd\Application\Service\ApplicationService;

/**
 * Description of ViewCategoryService
 *
 * @author vedran
 */
class ViewCategoryService implements ApplicationService
{

    private $appService;
    private $repo;
    private $spec;

    public function __construct(ApplicationService $appService, CategoryRepository $repo, CategorySpecificationFactory $spec)
    {
        $this->appService = $appService;
        $this->repo = $repo;
        $this->spec = $spec;
    }

    public function execute($request = null)
    {

        $spec = $this->spec->categoryByArrayOfCategoryIds(array_map(function($category) {
                    return $category['id'];
                }, $request->categoryes));

        $response = $this->repo->query($spec);

        return $this->appService->execute($request)
                ->set('app.service.category.view_categores', (new ViewCategoresDTO($response))->categoryes)
                ->set('app.service.category.domain.collection', $response);
    }

}
