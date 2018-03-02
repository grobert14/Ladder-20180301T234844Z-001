<?php
    //Start session and connect to the database
    // THis file is included in all pages - except for the error page

    session_start();
    $dbconn = pg_connect("host=localhost dbname=ladder user=postgres password=gohar1996") or die(header('Location: /userAuth/error/error.php'));
    $stat = pg_connection_status($dbconn);
    if ($stat === PGSQL_CONNECTION_OK)
    {
       'Connection status ok';
    }

    else
        {
      header('Location: /userAuth/error/error.php');
    }
?>
