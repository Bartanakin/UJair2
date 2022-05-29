<?php

namespace App\C;

abstract class Controller
{

    protected bool $destruct = false;
    protected function resetProp(string $propName, string $sesName, mixed $default){
        $this -> $propName = $default;
        unset($_SESSION[$sesName]);
    }

    protected function restoreFromSession(string $propName, string $sesName, mixed $default){
        if( isset($_SESSION[$sesName])){
            $this -> $propName = $_SESSION[$sesName];
        }
        else{
            $this->resetProp($propName,$sesName,$default);
        }
    }

    protected function assertPostVariables(array $names): bool {
        foreach ( $names as $name ){
            if( !isset( $_POST[$name]) )
                return false;
        }
        return true;
    }
}