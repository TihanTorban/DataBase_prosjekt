<?php
/**
 * Created by PhpStorm.
 * User: Gluck
 * Date: 07.02.14
 * Time: 11:12
 */

$db_is_connected = false;

//  Connection to data base;
    function db_connnect()
    {
        global $db;
        @ $db = new mysqli('localhost', 'user', '1234', 'mydb');
        global $db_is_connected;
        if (mysqli_connect_errno())
        {
            $db_is_connected = false;
            alert_message("Error: Could not connect ot database. Please try again later.");
            return;
        }else{
            $db_is_connected = true;
            $db->query("SET CHARACTER SET utf8");
        }
        return;
    }
		
?>
