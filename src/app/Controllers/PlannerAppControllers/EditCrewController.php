<?php

namespace App\Controllers\PlannerAppControllers;

use App\C\Controller;
use App\Entities\CrewList;
use App\Entities\Flight;
use App\Exceptions\SessionExpiredException;
use App\Interfaces\FindCrewForFlight;
use App\View;
use App\ViewPaths;
use PhpParser\Node\Expr\Array_;

class EditCrewController extends Controller
{
    protected Flight $flight;
    protected array $candidates;

    public function __construct(
        protected FindCrewForFlight $findCrewForFlight
    )
    {
        $this ->resetProp('flight','flight',Flight::createNull());
        $this ->resetProp('candidates','candidates',[]);
    }

    public function __destruct()
    {
        if( !$this -> destruct){
            $_SESSION['flight'] = $this->flight;
            $_SESSION['candidates'] = $this->candidates;
        }
    }

    public function linkMember(): View {

    }

    public function unlinkMember(): View {

    }

    public function findAvailableMembers(): View {

    }

    public function loadCrewList(): View {
        if( !isset($_POST['flightID']))
            return View::make(ViewPaths::BAD_REQUEST);
        try{
            $this -> flight -> setId($_POST['flightID']);
            $this -> flight -> setCrewList( $this -> findCrewForFlight -> findCrewForFlight($this -> flight -> getId()));

        }catch(SessionExpiredException $e){
            return View::make(ViewPaths::SESSION_EXPIRED);
        }
        return $this -> createDeafultView();
    }

    protected function createDeafultView(string $message = ""){
        return View::make(ViewPaths::EDIT_CREW_PAGE)
    }
}