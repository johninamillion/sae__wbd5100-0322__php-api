<?php

namespace SAE\PHPAPI;

final class Request {

    const METHOD_GET    = 'GET';
    const METHOD_POST   = 'POST';

    /**
     * Check if the request method in $_SERVER matches with the method given as argument
     *
     * @access  public
     * @param   string  $method
     * @return  bool
     */
    public function isMethod( string $method ) : bool {

        return $_SERVER[ 'REQUEST_METHOD' ] === $method;
    }

}