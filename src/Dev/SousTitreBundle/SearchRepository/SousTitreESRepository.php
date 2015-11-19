<?php

namespace Dev\SousTitreBundle\SearchRepository;

use FOS\ElasticaBundle\Repository;

class SousTitreESRepository extends Repository
{
    /**
     * @param $searchText
     * @return array<Article>
     */
    public function findSousTitres($searchText)
    {

        $query_part = new \Elastica\Query\Bool();
        $query_part->addShould(
            new \Elastica\Query\Term(array('value' => array('value' => $searchText, 'boost' => 3)))
        );
        $query_part->addShould(
            new \Elastica\Query\Term(array('intitule' => array('value' => $searchText)))
        );

        $filters = new \Elastica\Filter\Bool();
        $filters->addMust(
            new \Elastica\Filter\Term(array('langue' => 'fr'))
        );

        $query = new \Elastica\Query\Filtered($query_part, $filters);

        // return $this->findHybrid($query); pour avoir aussi un ES Result
        $res=$this->find($query);
        return $res;
    }
}