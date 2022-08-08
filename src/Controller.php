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
     * Request
     *
     * @access  protected
     * @var     Request|NULL
     */
    protected ?Request $Request = NULL;

    /**
     * Constructor
     *
     * @access  public
     * @construct
     */
    public function __construct() {
        $this->Response = new Response();
        $this->Request = new Request();

        // set default content-type
        $this->Response->setContentType( 'application/json' );
    }

}