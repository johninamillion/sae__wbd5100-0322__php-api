<?php

namespace SAE\PHPAPI;

abstract class Session {

    /**
     * Start
     *
     * @access  public
     * @static
     * @return  void
     */
    public static function start() : void {
        session_start();
    }

}