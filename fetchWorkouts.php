<?php
include_once('includes/MMF/MMF.php');
include_once('conf.php');

$debug = false;
$quiet = false;

if ( isset($_GET['debug']) ) {
    $log->log("enabling debug", PEAR_LOG_DEBUG);
    $debug = true;
}

if ( isset($_GET['quiet']) ) {
    $log->log("going silent", PEAR_LOG_DEBUG);
    $quiet = true;
}

if ( ! $quiet ) { echo "<pre>\n"; }

// Which day to fetch the data for?
if ( isset($_GET['startedAfter']) && $_GET['startedAfter'] != "" ) {

    $startedAfter = $_GET['startedAfter'];
    $log->log("GET paramter detected, fetching data for " . $startedAfter, PEAR_LOG_DEBUG);

    if ( $debug ) { print "startedAfter passed, fetcing for $startedAfter\n"; }

}else{
    $date = new DateTime();
    $date->sub(new DateInterval('P1D'));
    $startedAfter = $date->format('Y-m-d');

    $log->log("Defaulting to yesterday, " . $startedAfter, PEAR_LOG_DEBUG);

    if ( $debug ) { print "defaulting to yesterday=$startedAfter\n"; }

}

$request = new MMF;

// This grabs the user ID of whoever allowed us to see their account
$userID = $request->getAuthenticatedUserId(MMF_OAUTH_ACCESS_TOKEN,MMF_OAUTH_ACCESS_TOKEN_SECRET);

// Grabs a list of workouts for the specified user. fourth and fifth fields optional
// also takes a sixth optional param for 'StartedBefore'
// 11 is bike ride
$workouts = $request->getWorkoutsForUser(MMF_OAUTH_ACCESS_TOKEN, MMF_OAUTH_ACCESS_TOKEN_SECRET, $userID, "11", $startedAfter);

foreach ( $workouts as $workout ) {

    $workoutId = $workout['_links']['self'][0]['id'];
    $log->log("Found workoutId=$workoutId", PEAR_LOG_INFO);
    if ( $debug ) { print "Found workoutId=$workoutId\n"; }


    $fileName = $backupDir.'/'.$workoutId.'.json';


    // TODO: Check if the given workout exists on disk. If not grab it and save
    if ( ! file_exists($fileName ) ) {

        if ( ! $quiet ) { print "Saving to $fileName\n"; }
        $log->log("writing to fileName=$fileName", PEAR_LOG_INFO);

        $workOutDetails = $request->getWorkoutById(MMF_OAUTH_ACCESS_TOKEN, MMF_OAUTH_ACCESS_TOKEN_SECRET, $workoutId, true);

        $json = json_encode($workOutDetails);

        if ( file_put_contents($fileName, $json) == false ) {

            $log->log("Failed to write to $fileName", PEAR_LOG_CRIT);
            print "CRITICAL ERROR: Failed to write to $fileName\n";

        }else{
            $log->log("Wrote to $fileName successfully", PEAR_LOG_INFO);
        }

    }else{

        if ( ! $quiet ) { print "fileName=$fileName exists, skipping\n"; }
        $log->log("fileName=$fileName exists, skipping", PEAR_LOG_INFO);

    }

}

if ( ! $quiet ) { echo "</pre>\n"; }
?>
