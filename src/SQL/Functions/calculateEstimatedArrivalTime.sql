DROP FUNCTION IF EXISTS CalculateEstimatedArrivalTime;
SET GLOBAL log_bin_trust_function_creators = 1;
CREATE FUNCTION CalculateEstimatedArrivalTime( speed FLOAT, distance FLOAT, datetime_of_departure DATETIME )
    RETURNS DATETIME
    RETURN DATE_ADD(datetime_of_departure, INTERVAL 3600*distance/speed SECOND);