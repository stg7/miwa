<?php
define("API_KEY", "KEY");

function get_user_ip() {
    /* based on https://www.whatismyip.com/questions/how-do-i-find-my-real-ip-address-in-php-getting-servers-ip-rather-than-visitors-ip/ */
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}


try {
    if (isset($_GET["key"]) && $_GET["key"] == API_KEY) {
        $db =  new SQLite3("test.db");
        $db->exec('CREATE TABLE IF NOT EXISTS stats (ip_address STRING, user_agent STRING, page STRING, datetime STRING );');

        $statement = $db->prepare('INSERT INTO stats VALUES (:ip_address, :user_agent, :page, :time_);');
        $statement->bindValue(':ip_address', get_user_ip());
        $statement->bindValue(':user_agent', $_SERVER['HTTP_USER_AGENT']);
        $statement->bindValue(':page', json_encode($_GET));
        $statement->bindValue(':time_', date("c"));
        $result = $statement->execute();
        $db->close();
    }

} catch (Exception $e) {
    echo "<pre>";
    echo $e;
    echo "</pre>";
}
