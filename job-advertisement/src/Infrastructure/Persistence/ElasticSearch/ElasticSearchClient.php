<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace JobAd\Infrastructure\Persistence\ElasticSearch;

use Elasticsearch\ClientBuilder;
// nisam siguran za ovo ????
use JobAd\Application\Contract\Search;
/**
 * Description of ElasticSearch
 *
 * @author vedran
 * maperi ne pripadaju ovde samo da ih sklonim iz kontrolera.
 */

class ElasticSearchClient implements Search
{
    /**
     * 
     * @todo static method .
     * @return type
     */
    public function build()
    {
        /**
         * @todo Ubaci konfiguraciju ..... optionsResolver????
         */
        
        return ClientBuilder::create()->build();
    }
}
