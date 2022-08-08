<?php

namespace SAE\PHPAPI;

use SAE\PHPAPI\Controller\Error;

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
     * Accept method
     *
     * @access  protected
     * @param   string  $method
     * @return  void
     */
    protected function acceptMethod( string $method ) : void {
        if ( !$this->Request->isMethod( $method ) ) {
            Error::init( 405 );
        }
    }

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