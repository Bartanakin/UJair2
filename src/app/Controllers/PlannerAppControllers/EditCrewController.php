<?php

namespace App\Controllers\PlannerAppControllers;

use App\C\Controller;
use App\Entities\Flight;
use App\Entities\PersonClasses\EmployeeDegree;
use App\Exceptions\SessionExpiredException;
use App\Interfaces\EditCrewInterfaces\AvailableMemberFinder;
use App\Interfaces\EditCrewInterfaces\CrewEditor;
use App\Interfaces\FindCrewForFlight;
use App\Interfaces\FlightDataFinderForCrewEdition;
use App\Interfaces\FlightEditorInterfaces\AvailableAirplaneFinder;
use App\View;
use App\ViewPaths;

class EditCrewController extends Controller
{
    protected Flight $flight;
    protected array $candidates;
    protected EmployeeDegree $roleToLink;

    public function __construct(
        protected FindCrewForFlight $findCrewForFlight,
        protected AvailableMemberFinder $availableMemberFinder,
        protected CrewEditor $crewEditor,
    )
    {
        parent::__construct();
        $this ->trackSessionVariable('flight','flight',Flight::createNull());
        $this ->trackSessionVariable('candidates','candidates',[]);
        $this ->trackSessionVariable('roleToLink','roleToLink',EmployeeDegree::UNDEFINED);
    }

    public function linkMember(): View {
        if( !$this -> logged ) return $this -> createSessionExpiredView();
        if( $this -> assertPostVariables(['EmployeeID']))
            return View::make(ViewPaths::BAD_REQUEST);
        try{
            $this -> flight -> assertFlightID();
            if(!in_array($_POST['EmployeeID'], array_map(fn($x) => $x->getID(), $this->candidates)))
                throw new SessionExpiredException("Invalid candidate's ID");
            if( $this -> roleToLink == EmployeeDegree::UNDEFINED )
                throw new SessionExpiredException("Role to link has not been defined");
            $employee = $this -> candidates[array_search( $_POST['EmployeeID'],array_map(fn($x) => $x -> getID(),$this -> candidates))];

            $this -> crewEditor -> linkMember(
                $employee,
                $this -> roleToLink,
                $this -> flight -> getId()
            );

            $this -> flight -> setCrewList( $this -> findCrewForFlight -> findCrewForFlight($this -> flight -> getId()));
            $this ->resetProp('roleToLink');
            $this ->resetProp('candidates');
        }catch( SessionExpiredException $e ){
            return View::make(ViewPaths::SESSION_EXPIRED,['warning' => $e -> getMessage()]);
        }
        return $this -> createDefaultView();
    }

    public function unlinkMember(): View {
        if( !$this -> logged ) return $this -> createSessionExpiredView();
        if( $this -> assertPostVariables(['EmployeeID']))
            return View::make(ViewPaths::BAD_REQUEST);
        try{
            $this -> flight -> assertFlightID();
            $this -> flight -> assertCrewListWithEmployee($_POST['EmployeeID']);
            $employee = $this -> flight -> getCrewList() -> findEmployee($_POST['EmployeeID']);

            $this -> crewEditor -> unLinkMember($employee,$this -> flight -> getId());
            $this -> flight -> setCrewList( $this -> findCrewForFlight -> findCrewForFlight($this -> flight -> getId()));
            $this ->resetProp('roleToLink');
            $this ->resetProp('candidates');
        }catch( SessionExpiredException $e ){
            return View::make(ViewPaths::SESSION_EXPIRED,['warning' => $e -> getMessage()]);
        }
        return $this -> createDefaultView();
    }

    public function findAvailableMembers(): View {
        if( !$this -> logged ) return $this -> createSessionExpiredView();
        if( $this -> assertPostVariables(['RoleID']))
            return View::make(ViewPaths::BAD_REQUEST);

        try{
            $this -> flight -> assertFlightID();
            $this -> roleToLink = EmployeeDegree::tryFrom($_POST['RoleID']);

            $this -> candidates = $this -> availableMemberFinder -> run($this -> roleToLink);
        }catch( SessionExpiredException $e ){
            return $this -> createSessionExpiredView($e -> getMessage());
        }
        return $this -> createDefaultView();
    }

    public function loadCrewList(): View {
        if( !$this -> logged ) return $this -> createSessionExpiredView();

        $this ->resetProp('flight');
        $this ->resetProp('candidates');
        $this ->resetProp('roleToLink');

        if( $this -> assertPostVariables(['flightID']))
            return View::make(ViewPaths::BAD_REQUEST);
        try{
            $this -> flight -> setId($_POST['flightID']);
            $this -> flight -> setCrewList( $this -> findCrewForFlight -> findCrewForFlight($this -> flight -> getId()));

        }catch(SessionExpiredException $e){
            return View::make(ViewPaths::SESSION_EXPIRED);
        }
        return $this -> createDefaultView();
    }

    protected function createDefaultView(string $message = ""): View {
        $this -> warning = $message;
        return View::make(ViewPaths::EDIT_CREW_PAGE,[
            'flight' => $this -> flight,
            'candidates' => $this -> candidates,
            'roleToLink' => $this -> roleToLink,
            'warning' => $message
        ]);
    }
}