<?php

/*
 *  ItPoslovi
 *  Vedran Vukoje Ja:
 *  vedran.vukoje@gmail.com
 */

namespace JobAd\Application\Service;

/**
 *
 * @author vedran JobAd\Application\Service\ApplicationService
 */
interface ApplicationService
{
    /**
     * 
     * @param type $request
     * @return mixed 
     */
    public function execute($request = null);
}
