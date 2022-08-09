<?php

namespace SAE\PHPAPI\Controller;

use SAE\PHPAPI\Controller;
use SAE\PHPAPI\Request;
use SAE\PHPAPI\Model\Users as UsersModel;

final class User extends Controller {

    /**
     * Users Model
     *
     * @access  private
     * @var     UsersModel|NULL
     */
    private ?UsersModel $UsersModel = NULL;

    /**
     * Constructor
     *
     * @access  public
     * @construct
     */
    public function __construct() {
        parent::__construct();

        $this->UsersModel = new UsersModel();
    }

    /**
     * Delete
     *
     * @access  public
     * @param   int     $user_id
     * @return  void
     */
    public function delete( int $user_id ) : void {
        $this->acceptMethod( Request::METHOD_DELETE );

        // Todo: Delete user by ID
    }

    /**
     * Profile
     *
     * @access  public
     * @param   string  $username
     * @return  void
     */
    public function profile( string $username ) : void {
        $this->acceptMethod( Request::METHOD_GET );

        /** @var array|bool $profile */
        $profile = $this->UsersModel->getProfileByUsername( $username );

        // success
        if ( $profile ) {
            $this->Response->setResponseCode( 200 );
            $this->Response->printJSON( $profile );
        }
        // fail
        else {
            $this->Response->setResponseCode( 400 );
            $this->Response->printJSON( [ 'errors' => [ 'username' => 'The username doesn\'t exist' ] ] );
        }
    }

    /**
     * Login
     *
     * @access  public
     * @return  void
     */
    public function login() : void {
        $this->acceptMethod( Request::METHOD_POST );

        /** @var string|NULL $username */
        $username = filter_input( INPUT_POST, 'username' );
        /** @var string|NULL $password */
        $password = filter_input( INPUT_POST, 'password' );

        // success
        if ( $this->UsersModel->loginUser( $username, $password ) ) {
            $this->Response->setResponseCode( 200 );

        }
        // fail
        else {
            $this->Response->setResponseCode( 400 );
            $this->Response->printJSON( [ 'errors' => [ 'password' => 'Typed in wrong password' ] ] );
        }
    }

    /**
     * Register
     *
     * @access  public
     * @return  void
     */
    public function register() : void {
        $this->acceptMethod( Request::METHOD_POST );

        /** @var string|NULL $username */
        $username = filter_input( INPUT_POST, 'username' );
        /** @var string|NULL $email */
        $email = filter_input( INPUT_POST, 'email' );
        /** @var string|NULL $password */
        $password = filter_input( INPUT_POST, 'password' );
        /** @var string|NULL $password_repeat */
        $password_repeat = filter_input( INPUT_POST, 'password_repeat' );

        // success
        if ( $this->UsersModel->registerUser( $username, $email, $password, $password_repeat ) ) {
            $this->Response->setResponseCode( 201 );
        }
        // fail
        else {
            $this->Response->setResponseCode( 400 );
            $this->Response->printJSON( [ 'errors' => $this->UsersModel->getErrors() ] );
        }
    }

}