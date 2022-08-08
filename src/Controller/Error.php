<?php

namespace SAE\PHPAPI\Controller;

use SAE\PHPAPI\Controller;

final class Error extends Controller {

    /**
     * Get error message by status code
     *
     * @access  private
     * @static
     * @param   int     $code
     * @return  string|NULL
     */
    private static function getMessage( int $code ) : ?string {
        /** @var string $messages */
        $messages = [
            '400'   =>  _( "Bad Request" ),
            '401'   =>  _( "Unauthorized" ),
            '402'   =>  _( "Payment Required" ),
            '403'   =>  _( "Forbidden" ),
            '404'   =>  _( "Not Found" ),
            '405'   =>  _( "Method Not Allowed" ),
            '406'   =>  _( "Not Acceptable" ),
            '407'   =>  _( "Proxy Authentication Required" ),
            '408'   =>  _( "Request Timeout" ),
            '409'   =>  _( "Conflict" ),
            '410'   =>  _( "Gone" ),
            '411'   =>  _( "Length Required" ),
            '412'   =>  _( "Precondition Failed" ),
            '413'   =>  _( "Payload Too Large" ),
            '414'   =>  _( "URI Too Long" ),
            '415'   =>  _( "Unsupported Media Type" ),
            '416'   =>  _( "Range Not Satisfiable" ),
            '417'   =>  _( "Expectation Failed" ),
            '418'   =>  _( "I'm a teapot" ),
            '422'   =>  _( "Unprocessable Entity" ),
            '425'   =>  _( "Too Early" ),
            '426'   =>  _( "Upgrade Required" ),
            '428'   =>  _( "Precondition Required" ),
            '429'   =>  _( "Too many Requests" ),
            '431'   =>  _( "Request Header Fields Too Large" ),
            '451'   =>  _( "Unavailable For Legal Reasons" ),
        ];

        return $messages[ $code ] ?? NULL;
    }

    /**
     * Init
     *
     * @access  public
     * @static
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
        $this->Response->setContentType( 'application/json' );
        $this->Response->setResponseCode( $status );
        $this->Response->printJSON( [ 'error' => [ 'code' => $status, 'message' => self::getMessage( $status ) ] ] );
        exit();
    }

}