<?php


namespace App\Data;


use App\Entity\Site;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Date;

class SearchData

{
    /**
     * @var int
     */
    public $page = 1;

    /**
     * @var string
     */
    public $q = '';


    /**
     * @var Site
     */
    public $site;

    /**
     * @Assert\GreaterThanOrEqual("-1 month")
     * @var null|Date
     */
    public $dateDebut;

    /**
     * @var null|Date
     */
    public $dateFin;

    /**
     * @var boolean
     */
    public $organiser = false;

    /**
     * @var boolean
     */
    public $inscrit = false;

    /**
     * @var boolean
     */
    public $pasInscrit = false;

    /**
     * @var boolean
     */
    public $passee = false;

    /**
     * @var boolean
     */
    public $disable = false;

}