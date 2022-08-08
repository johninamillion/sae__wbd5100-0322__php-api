<?php

namespace SAE\PHPAPI;

abstract class Model {

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

}