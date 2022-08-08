<?php

namespace SAE\PHPAPI;

final class Response {

    const DEFAULT_CONTENT_TYPE = 'application/json';
    const DEFAULT_RESPONSE_CODE = 200;

    /**
     * Print array in JSON string
     *
     * @access  public
     * @param   array   $response
     * @return  void
     */
    public function printJSON( array $response ) : void {

        echo json_encode( $response );
    }

    /**
     * Set content type
     *
     * @access  public
     * @param   string  $content_type
     * @return  void
     */
    public function setContentType( string $content_type = self::DEFAULT_CONTENT_TYPE ) : void {

        header( "Content-Type: $content_type" );
    }

    /**
     * Set HTTP response code
     *
     * @access  public
     * @param   int     $code
     * @return  int|bool
     */
    public function setResponseCode( int $code = self::DEFAULT_RESPONSE_CODE ) : int|bool {

        return http_response_code( $code );
    }

}