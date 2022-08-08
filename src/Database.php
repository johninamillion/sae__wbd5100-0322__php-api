<?php

namespace SAE\PHPAPI;

final class Database extends \PDO {

    /**
     * Constructor
     *
     * @access  public
     * @construct
     */
    public function __construct() {
        /** @var string $dsn */
        $dsn = sprintf(
            '%1$s:dbname=%2$s;host=%3$s;port=%4$s;charset=%5$s',
            DATABASE_TYPE,
            DATABASE_NAME,
            DATABASE_HOST,
            DATABASE_PORT,
            DATABASE_CHARSET
        );
        /** @var string $user */
        $user = DATABASE_USER;
        /** @var string $pass */
        $pass = DATABASE_PASS;
        /** @var array $options */
        $options = [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ];

        parent::__construct( $dsn, $user, $pass, $options );
    }

}