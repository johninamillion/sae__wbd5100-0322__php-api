<?php

namespace SAE\PHPAPI;

use SAE\PHPAPI\Controller\Error;

final class Application {

    /**
     * URL
     *
     * @access  private
     * @var     array
     */
    private array $url = [];

    /**
     * Create a string of the controller class name with namespace
     *
     * @param   string|NULL $controller
     * @return  string
     */
    private function controllerClassString( ?string $controller ) : string {
        /** @var string $class */
        $class = ucfirst( $controller );

        return "SAE\\PHPAPI\\Controller\\{$class}";
    }

    /**
     * Check if a controller exists
     *
     * @access  private
     * @param   string  $controller
     * @return  bool
     */
    private function controllerExists( string $controller ) : bool {

        return class_exists( $controller );
    }

    /**
     * Check if the argument is not empty and valid
     *
     * @access  private
     * @param   string|NULL $argument
     * @return  bool
     */
    private function isValidArgument( ?string $argument ) : bool {

        return !empty( $argument );
    }

    /**
     * Check if a controller method exists
     *
     * @access  private
     * @param   string|NULL $controller
     * @param   string|NULL $method
     * @return  bool
     */
    private function methodExists( ?string $controller, ?string $method ) : bool {

        return !is_null( $controller) && !is_null( $method ) && method_exists( $controller, $method );
    }

    /**
     * Parse URL
     *
     * @access  private
     * @return  array
     */
    private function parseUrl() : array {
        /** @var string $url */
        $url    = filter_input( INPUT_GET, '_url' ) ?? '';
        /** @var string $url_lowercase */
        $url_lowercase = strtolower( $url );
        /** @var array $url_exploded */
        $url_exploded = explode( '/', $url_lowercase );

        /** @var string|NULL $controller */
        $controller = $url_exploded[ 0 ];
        /** @var string|NULL $method */
        $method = $url_exploded[ 1 ] ?? NULL;
        /** @var string|NULL $argument */
        $argument = $url_exploded[ 2 ] ?? NULL;

        return [
            'controller'    =>  $this->sanitizeController( $controller ),
            'method'        =>  $this->sanitizeControllerMethod( $controller, $method ),
            'argument'      =>  $argument
        ];
    }

    /**
     * Sanitize Controller
     *
     * @access  private
     * @param   string|NULL $controller
     * @return  string|NULL
     */
    private function sanitizeController( ?string $controller ) : ?string {
        /** @var string $request */
        $request = $this->controllerClassString( $controller );

        return $this->controllerExists( $request ) ? $request : NULL;
    }

    /**
     * Sanitize Controller Method
     *
     * @access  private
     * @param   string|NULL $controller
     * @param   string|NULL $method
     * @return  string|NULL
     */
    private function sanitizeControllerMethod( ?string $controller, ?string $method ) : ?string {
        /** @var string $request */
        $request = $this->controllerClassString( $controller );

        return $this->methodExists( $request, $method ) ? $method : NULL;
    }

    /**
     * Constructor
     *
     * @access  public
     * @construct
     */
    public function __construct() {
        $this->url = $this->parseUrl();
    }

    /**
     * Run
     *
     * @access  public
     * @return  void
     */
    public function run() : void {
        /** @var string $controller */
        $controller = $this->url[ 'controller' ];
        /** @var string $method */
        $method = $this->url[ 'method' ];
        /** @var string|NULL $argument */
        $argument = $this->url[ 'argument' ];

        if ( $this->methodExists( $controller, $method ) ) {
            if ( $this->isValidArgument( $argument ) ) {
                ( new $controller() )->{$method}( $argument );
            }
            else {
                ( new $controller() )->{$method}();
            }
        }
        else {
            Error::init();
        }
    }

}