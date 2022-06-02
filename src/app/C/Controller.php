<?php

namespace App\C;

use App\Interfaces\PassengerLoginInterfaces\LoginAndPasswordVerification;
use App\View;
use App\ViewPaths;

abstract class Controller
{

    protected bool $destruct = false;
    protected array $sessionVariables = [];
    protected bool $logged = false;
    protected ?string $warning = "";

    public function __construct(protected LoginAndPasswordVerification $loginAndPasswordVerification)
    {
        $this -> trackSessionVariable('logged','logged',true);
        $this -> trackSessionVariable('warning','warning','');
    }
    public function __destruct()
    {
        if( !$this -> destruct ){
            $this -> writeSession();
        }
    }

    protected function verifyAccount(): bool {
        $token = $_POST['token'];
        $login = $_POST['login'];
        $hashP = $_POST['hashP'];
        if(hash("sha256", $login . $hashP . $hashP) == $token) {
            if($this -> loginAndPasswordVerification -> run($login, $hashP) != -1) {
                return true;
            }
        }
        return false;
    }

    protected function createUnauthorizedView(): View {
        return View::make( ViewPaths::UNAUTHORIZED);
    }
    
    protected function trackSessionVariable(string $propName, string $sesName, mixed $default){
        $this -> sessionVariables[$propName] = [ 'sesName' => $sesName, 'defaultVar' => $default ];
        $this -> restoreFromSession($propName);
    }

    protected function resetProp(string $propName, ?string $sesName = null , mixed $default = null ){
        $this -> $propName = $default ?? $this -> sessionVariables[$propName]['defaultVar'];
        unset($_SESSION[$sesName ?? $this -> sessionVariables[$propName]['sesName']]);
    }

    protected function restoreFromSession(string $propName, ?string $sesName = null, mixed $default = null){
        if( isset($_SESSION[$sesName ?? $this -> sessionVariables[$propName]['sesName']])){
            $this -> $propName = $_SESSION[$sesName ?? $this -> sessionVariables[$propName]['sesName']];
        }
        else{
            $this->resetProp($propName,$sesName,$default);
        }
    }
    public function writeSession(): void {
        foreach ( $this -> sessionVariables as $propName => $variable ){
            $_SESSION[$variable['sesName']] = $this -> $propName;
        }
    }

    protected function assertPostVariables(array $names): bool {
        foreach ( $names as $name ){
            if( !isset( $_POST[$name]) )
                return true;
        }
        return false;
    }

    public function resetAllProps(): void {
        foreach ( $this -> sessionVariables as $propName => $variable ){
            $this -> $propName = $variable['defaultVar'];
        }
    }
    public function createSessionExpiredView(string $message = "Session expired"): View {
        return View::make(ViewPaths::HOME_PAGE,['serverMessage' => $message ]);
    }
    public function createBadRequestView(string $message = "Bad post request"): View {
        return View::make(ViewPaths::BAD_REQUEST,['message' => $message ]);
    }
}