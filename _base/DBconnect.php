<?php

    class DBconnect {

        //Create static variables (this implies that you don't need to initiate the database object to use these variables)
        private static $writeDBConnection; //connection to the write (or master) db
        private static $readDBConnection; //connection to the read (or slave) db
        //for smaller projects, the write and read DBs are the same

        public static function connectWriteDB($db_host, $db_name, $db_user, $db_pass) {
            if(self::$writeDBConnection === null) { //if connection have not already been initiated
                self::$writeDBConnection = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass); //using PDO to connect to mysql db
                self::$writeDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //connects using exception mode
                self::$writeDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //prepared statements allows you to assign variables inside SQL codes rather than hardcoding. It is set to false because mysql does this already by default
            }

            return self::$writeDBConnection;
        }
        
        //repeat for the read DB
        public static function connectReadDB($db_host, $db_name, $db_user, $db_pass) {
            if(self::$readDBConnection === null) { //if connection have not already been initiated
                self::$readDBConnection = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
                self::$readDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
                self::$readDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
            }

            return self::$readDBConnection;
        }
    }

?>