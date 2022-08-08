<?php

namespace SAE\PHPAPI;

abstract class Controller {

    /**
     * Response
     *
     * @access  private
     * @var     Response|NULL
     */
    private ?Response $Response = NULL;

    /**
     * Constructor
     *
     * @access  public
     * @construct
     */
    public function __construct() {
        $this->Response = new Response();
    }

}