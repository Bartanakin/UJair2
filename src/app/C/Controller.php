<?php

namespace App\C;

abstract class Controller
{

    protected bool $destruct = false;
    protected array $sessionVariables = [];

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
}