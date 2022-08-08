<?php

namespace SAE\PHPAPI;

abstract class Model {

    /**
     * Errors
     *
     * @access  protected
     * @var     array
     */
    protected array $errors = [];

    /**
     * Messages
     *
     * @access  protected
     * @var     array
     */
    protected array $messages = [];

    /**
     * Database
     *
     * @access  protected
     * @var     Database|NULL
     */
    protected ?Database $Database = NULL;

    /**
     * Constructor
     *
     * @access  public
     * @construct
     */
    public function __construct() {
        $this->Database = new Database();
    }

    /**
     * Add Error
     *
     * @access  public
     * @param   string  $key
     * @param   string  $error
     * @return  void
     */
    public function addError( string $key, string $error ) : void {
        $this->errors[ $key ][] = $error;
    }

    /**
     * Add Message
     *
     * @access  public
     * @param   string  $key
     * @param   string  $message
     * @return  void
     */
    public function addMessage( string $key, string $message ) : void {
        $this->messages[ $key ][] = $message;
    }

    /**
     * Get errors
     *
     * @access  public
     * @param   string|NULL $key
     * @return  array
     */
    public function getErrors( ?string $key = NULL ) : array {

        return is_null( $key )
            ? $this->errors
            : $this->errors[ $key ];
    }

    /**
     * Has errors
     *
     * @access  public
     * @param   string|NULL $key
     * @return  bool
     */
    public function hasErrors( ?string $key = NULL ) : bool {

        return is_null( $key )
            ? isset( $this->errors ) && !empty( $this->errors )
            : isset( $this->errors[ $key ] ) && !empty( $this->errors[ $key ] );
    }

}