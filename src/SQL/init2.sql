
SET GLOBAL log_bin_trust_function_creators = 1;

CALL resetTableAirplanes();
CALL resetTableAirplaneTypes();
CALL resetTableAirports();
CALL resetTableEmployees();
CALL resetTablePassengers();
CALL resetTableRoutes();
CALL resetTableFlights();
CALL resetTableCrewList();
CALL resetTableCountries();
CALL resetTableTickets();

