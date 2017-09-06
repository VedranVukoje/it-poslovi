<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JobAd\Infrastructure\Ui\Framework\Symfony\JobAdvertisementBundle\Command;

//use Symfony\Component\Console\Command\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use JobAd\Infrastructure\Persistence\ElasticSearch\Mapping\JobAdvertisementMapping;
use JobAd\Infrastructure\Persistence\ElasticSearch\ElasticSearchClient;

/**
 * Description of ElasticSerachMappingCommand
 *
 * @author vedran
 */
class ElasticSerachMappingCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this->setName('it-poslovi:elasticserach-mapping')
                ->setDescription('Mapiranje za job-advertisement type.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $es = $this->getContainer()->get(ElasticSearchClient::class)->build();
//        $x = $es->indices()->getMapping(['type' => 'job-advertisement']);
        if (!$es->indices()->exists(['index' => 'job-advertisement'])) {
            // curl -XHEAD 'localhost:9200/twitter/_mapping/tweet?pretty'
            // curl -XGET 'localhost:9200/itposlovi/_mapping/jobadvertisment'
//            curl -XGET 'localhost:9200/_mapping/tweet?pretty'
//            curl -XGET 'localhost:9200/_all/_mapping/jobadvertisement?pretty'
//            curl -XGET 'localhost:9200/itposlovi/_settings,_mappings?pretty'
//            curl –i -XHEAD 'localhost:9200/itposlovi/'
            $es->indices()->create((new JobAdvertisementMapping)->map());
            
        }
//        var_dump($x);
    }

}
