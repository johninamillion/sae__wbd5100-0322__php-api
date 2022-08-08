<?php

namespace SAE\PHPAPI\Controller;

use SAE\PHPAPI\Controller;

final class Error extends Controller {

    /**
     * Init
     *
     * @access  public
     * @param   int     $status
     * @return  void
     */
    public static function init( int $status = 404 ) : void {
        ( new self() )->index( $status );
    }

    /**
     * Index
     *
     * @access  public
     * @param   int     $status
     * @return  void
     */
    public function index( int $status = 404 ) : void {
        $this->Respo
    }

}