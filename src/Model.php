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
        $this->errors[ $key ] = $error;
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
        $this->messages[ $key ] = $message;
    }

}