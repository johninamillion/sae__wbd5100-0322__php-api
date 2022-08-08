<?php

namespace SAE\PHPAPI\Model;

use SAE\PHPAPI\Model;

final class Users extends Model {
    
    /**
     * Create salt
     *
     * @access  private
     * @return  string
     */
    private function createSalt() : string {
        /** @var int $time */
        $time = time();
        /** @var int $rand */
        $rand = rand( 1, 99999 );

        return hash( 'sha512', "{$time}{$rand}" );
    }

    /**
     * Check if an email exists
     *
     * @access  private
     * @param   string|NULL $email
     * @return  bool
     */
    private function emailExists( ?string $email ) : bool {
        /** @var string $query */
        $query = 'SELECT email FROM users WHERE email = :email;';

        /** @var \PDOStatement $Statement */
        $Statement = $this->Database->prepare( $query );
        $Statement->bindValue( ':email', $email );
        $Statement->execute();

        return $Statement->rowCount() > 0;
    }

    /**
     * Hash password
     *
     * @access  private
     * @param   string  $password
     * @param   string  $salt
     * @return  string
     */
    private function hashPassword( string $password, string $salt ) : string {

        return hash( 'sha512', "{$password}{$salt}" );
    }

    /**
     * Check if an username exists
     *
     * @access  private
     * @param   string|NULL $username
     * @return  bool
     */
    private function usernameExists( ?string $username ) : bool {
        /** @var string $query */
        $query = 'SELECT username FROM users WHERE username = :username;';

        /** @var \PDOStatement $Statement */
        $Statement = $this->Database->prepare( $query );
        $Statement->bindValue( ':username', $username );
        $Statement->execute();

        return $Statement->rowCount() > 0;
    }

    /**
     * Validate email
     *
     * @access  private
     * @param   string|NULL $email
     * @return  bool
     */
    private function validateEmail( ?string $email ) : bool {
        if ( empty( $email ) ) {
            $this->addError( 'email', _( 'The email is empty' ) );
        }
        if ( $this->emailExists( $email ) ) {
            $this->addError( 'email', _( 'The email already exists' ) );
        }
        if ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
            $this->addError( 'email', _( 'The email is invalid' ) );
        }

        return !$this->hasErrors( 'email' );
    }

    /**
     * Validate password
     *
     * @access  private
     * @param   string|NULL $password
     * @param   string|NULL $password_repeat
     * @return  bool
     */
    private function validatePassword( ?string $password, ?string $password_repeat ) : bool {
        if ( empty( $password ) ) {
            $this->addError( 'password', _( 'The password is empty' ) );
        }
        if ( strlen( $password ) < 8 ) {
            $this->addError( 'password', _( 'The password is shorter than 8 characters' ) );
        }
        if ( preg_match( '/\s/', $password ) ) {
            $this->addError( 'password', _( 'The password contains any whitespace' ) );
        }
        if ( !preg_match( '/\d/', $password ) ) {
            $this->addError( 'password', _( 'The password doesn\'t contain any digits' ) );
        }
        if ( !preg_match( '/\W/', $password ) ) {
            $this->addError( 'password', _( 'The password doesn\'t contain any special characters' ) );
        }
        if ( !preg_match( '/[a-z]/', $password ) ) {
            $this->addError( 'password', _( 'The password doesn\'t contain any lowercase characters' ) );
        }
        if ( !preg_match( '/[A-Z]/', $password ) ) {
            $this->addError( 'password', _( 'The password doesn\'t contain any uppercase characters' ) );
        }
        if ( $password !== $password_repeat ) {
            $this->addError( 'password', _( 'The password doesn\'t match with the repeated password' ) );
        }

        return !$this->hasErrors( 'password' );
    }

    /**
     * Validate username
     *
     * @access  private
     * @param   string|NULL $username
     * @return  bool
     */
    private function validateUsername( ?string $username ) : bool {
        if ( empty( $username ) ) {
            $this->addError( 'username', _( 'The username is empty' ) );
        }
        if ( $this->usernameExists( $username ) ) {
            $this->addError( 'username', _( 'The username already exists' ) );
        }
        if ( strlen( $username ) < 4 ) {
            $this->addError( 'username', _( 'The username is shorter than 4 characters' ) );
        }
        if ( strlen( $username ) > 16 ) {
            $this->addError( 'username', _( 'The username is longer than 16 characters' ) );
        }
        if ( preg_match( '/\s/', $username ) ) {
            $this->addError( 'username', _( 'The username contains whitespace' ) );
        }

        return !$this->hasErrors( 'username' );
    }

    /**
     * Register user
     *
     * @access  public
     * @param   string|NULL $username
     * @param   string|NULL $email
     * @param   string|NULL $password
     * @param   string|NULL $password_repeat
     * @return  bool
     */
    public function registerUser( ?string $username, ?string $email, ?string $password, ?string $password_repeat ) : bool {
        /** @var bool $validate_username */
        $validate_username = $this->validateUsername( $username );
        /** @var bool $validate_email */
        $validate_email = $this->validateEmail( $email );
        /** @var bool $validate_password */
        $validate_password = $this->validatePassword( $password, $password_repeat );

        if ( $validate_username && $validate_email && $validate_password ) {
            /** @var int $registered */
            $registered = $_SERVER[ 'REQUEST_TIME' ] ?? time();
            /** @var string $salt */
            $salt = $this->createSalt();
            /** @var string $hashed_password */
            $hashed_password = $this->hashPassword( $password, $salt );

            /** @var string $query */
            $query = 'INSERT INTO users ( username, email, password, salt, registered ) VALUES ( :username, :email, :password, :salt, :registered );';

            /** @var \PDOStatement $Statement */
            $Statement = $this->Database->prepare( $query );
            $Statement->bindValue( ':username', $username );
            $Statement->bindValue( ':email', $email );
            $Statement->bindValue( ':password', $hashed_password );
            $Statement->bindValue( ':salt', $salt );
            $Statement->bindValue( ':registered', $registered );
            $Statement->execute();

            return $Statement->rowCount() > 0;
        }

        return FALSE;
    }

}