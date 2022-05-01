<?php

namespace App\Models;

use App\DataBaseConnection;
use App\Exceptions\IncorrectLoginException;
use App\Exceptions\IncorrectPasswordException;
use App\Interfaces\PlannerLoginInterface;
use App\Model;
use function PHPUnit\Framework\throwException;

class PlannerLoginImpl extends Model implements PlannerLoginInterface
{
    public function __construct( DataBaseConnection $dataBaseConnection){
        parent::__construct( $dataBaseConnection );
    }
    public function login($login, $password): bool
    {
        $stm = $this -> getDBConnection() -> prepare('SELECT PasswordHash FROM Planners WHERE Username LIKE ?;');
        $stm -> execute([$login]);
        if( $stm -> rowCount() > 0 ){
            $stm = $stm -> fetch();
           if( password_verify($password,$stm['PasswordHash']) ){
                return true;
            }
           throw new IncorrectPasswordException();
        }
        throw new IncorrectLoginException();
    }
}