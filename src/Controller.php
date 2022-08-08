<?php

namespace SAE\PHPAPI;

abstract class Controller {

    /**
     * Response
     *
     * @access  protected
     * @var     Response|NULL
     */
    protected ?Response $Response = NULL;

    /**
     * Constructor
     *
     * @access  public
     * @construct
     */
    public function __construct() {
        $this->Response = new Response();
        $this->Response->setContentType( 'application/json' );
    }

}