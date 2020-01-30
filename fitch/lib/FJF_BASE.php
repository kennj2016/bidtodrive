<?php
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

/** include command definition file */
if (!@include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["lib_path"] . "/FJF_CMD.php")) {
    throw new FatalException('Failed to include FJF_CMD library');
}

class FJF_BASE
{

    /**
     * Debug logger
     * @param string $str
     * @param string $method
     */
    public static function log($str, $method = null)
    {
        if (!$GLOBALS["WEB_APPLICATION_CONFIG"]["debug_mode"]) {
            return;
        }

        if ($GLOBALS["WEB_APPLICATION_CONFIG"]["log_file"] != "" &&
            @file_exists($GLOBALS["WEB_APPLICATION_CONFIG"]["log_file"]) &&
            @is_writable($GLOBALS["WEB_APPLICATION_CONFIG"]["log_file"])
        ) {
            $data = date("m/d/Y h:i:s") . " " . number_format(floatval(microtime()), 3) . "(" . $method . "): " . $str . "\n";
            $fp = @fopen($GLOBALS["WEB_APPLICATION_CONFIG"]["log_file"], "a+");
            $res = @fwrite($fp, $data);
            @fclose($fp);
        }
    }


    /**
     * Processes request and loads appropriate command based on the definition
     * @param string $cmdToLoad
     * @return mixed
     */
    public static function process_request($cmdToLoad)
    {
        $cmdFile = $cmdToLoad . ".php";
        FJF_BASE::log("Processing '$cmdToLoad' ...", __METHOD__);

        if ($GLOBALS['WEB_APPLICATION_CONFIG'][$cmdToLoad] == null ||
            $GLOBALS['WEB_APPLICATION_CONFIG'][$cmdToLoad]["class"] == null ||
            !@file_exists($GLOBALS['WEB_APPLICATION_CONFIG']["commands_path"] . "/" . $cmdFile)
        ) {
            throw new FatalException("Failed to process '$cmdToLoad': invalid configuration");
        }

        FJF_BASE::log("Including file '" . $cmdFile . "' ...", __METHOD__);
        include_once($GLOBALS['WEB_APPLICATION_CONFIG']["commands_path"] . "/" . $cmdFile);

        if (!class_exists($GLOBALS['WEB_APPLICATION_CONFIG'][$cmdToLoad]["class"])) {
            throw new FatalException("Class '" . $GLOBALS['WEB_APPLICATION_CONFIG'][$cmdToLoad]["class"] . "' does not exist");
        }

        //create new instance of the class
        $tmpInstance = new $GLOBALS['WEB_APPLICATION_CONFIG'][$cmdToLoad]["class"];
        //execute the command
        $res = $tmpInstance->execute();
        unset($tmpInstance);

        return $res;
    }


    /**
     * Redirects to a new location
     * @param string $loc
     */
    public static function redirect($loc)
    {
        FJF_BASE::log("Redirecting to '$loc'", __METHOD__);
        //header("HTTP/1.1 301 Moved Permanently");
        header("Location: $loc");
        exit;
    }


    /**
     * Global redirect
     * @return boolean
     */
    public static function global_redirect()
    {
        $toRedirect = false;
        $loc = $_SERVER["REQUEST_URI"];

        $exceptionCMD = array("script");

        if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "PUT") {
            return true;
        }
        if (strpos($_SERVER["REQUEST_URI"], "?") !== false) {
            return true;
        } // if this is AJAX request, then no redirects
        elseif (preg_match("/\/ajax\//", $loc) || isset($_REQUEST["cmd"]) && substr($_REQUEST["cmd"], 0, 4) == "ajax") {
            return true;
        } // if this is ADMIN request, then no redirects
        elseif (preg_match("/^\/admin\//", $loc) || isset($_REQUEST["cmd"]) && substr($_REQUEST["cmd"], 0, 5) == "admin") {
            return true;
        } // if this is exception CMD
        elseif (isset($_REQUEST["cmd"]) && in_array($_REQUEST["cmd"], $exceptionCMD)) {
            return true;
        } // if this is an image or css or js file (which was NOT found and is being redirected to Error404 page)
        elseif (preg_match("/(\.[a-z\d]+$)/i", $loc)) {
            return true;
        } // no trailing slashes
        elseif (!preg_match("/\/$/", $loc)) {
            $toRedirect = true;
        } // double trailing slashes (or more)
        elseif (preg_match("/\/{2,}$/", $loc)) {
            $toRedirect = true;
            $loc = rtrim($loc, "/ ");
        }

        // checking if we need to redirect...
        if ($toRedirect) {
            FJF_BASE::log("GlobalRedirecting: FROM '" . $_SERVER["REQUEST_URI"] . "' TO '" . $loc . "/'", __METHOD__);
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $loc . "/");
            exit;
        }

        return true;
    }


    /**
     * Saves/gets status message to/from session
     * @param string $s
     * @return string
     */
    public static function status($s = null)
    {
        if ($s) {
            $_SESSION["status"] = $s;
        } else {
            $s = isset($_SESSION["status"]) ? $_SESSION["status"] : "";
            unset($_SESSION["status"]);
        }
        return $s;
    }


    /**
     * Returns DB error
     * @return string
     */
    public static function db_error()
    {
        return $GLOBALS["WEB_APPLICATION_CONFIG"]["db_error"];
    }


    /**
     * Escapes string to avoid SQL Injection
     * @param string $value
     * @return string
     */
    public static function db_escape($value)
    {
        if (!FJF_BASE::db_is_connected()) {
            return;
        }

        return $GLOBALS["WEB_APPLICATION_CONFIG"]["db_connection"]->real_escape_string($value);
    }

    public static function capsuleOpen(){
        $capsule = new Illuminate\Database\Capsule\Manager();

        $config = [
            'driver'    => 'mysql',
            'host'      => isset($GLOBALS["WEB_APPLICATION_CONFIG"]["db_host"]) && $GLOBALS["WEB_APPLICATION_CONFIG"]["db_host"] ? $GLOBALS["WEB_APPLICATION_CONFIG"]["db_host"] : null,
            'database'  => isset($GLOBALS["WEB_APPLICATION_CONFIG"]["db_name"]) && $GLOBALS["WEB_APPLICATION_CONFIG"]["db_name"] ? $GLOBALS["WEB_APPLICATION_CONFIG"]["db_name"] : null,
            'username'  => isset($GLOBALS["WEB_APPLICATION_CONFIG"]["db_user"]) && $GLOBALS["WEB_APPLICATION_CONFIG"]["db_user"] ? $GLOBALS["WEB_APPLICATION_CONFIG"]["db_user"] : null,
            'password'  => isset($GLOBALS["WEB_APPLICATION_CONFIG"]["db_password"]) && $GLOBALS["WEB_APPLICATION_CONFIG"]["db_password"] ? $GLOBALS["WEB_APPLICATION_CONFIG"]["db_password"] : null,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'port'      => isset($GLOBALS["WEB_APPLICATION_CONFIG"]["db_port"]) && $GLOBALS["WEB_APPLICATION_CONFIG"]["db_port"] ? $GLOBALS["WEB_APPLICATION_CONFIG"]["db_port"] : null,
        ];

        $capsule->addConnection($config);

        $capsule->setEventDispatcher(new Dispatcher(new Container));

        // Make this Capsule instance available globally via static methods... (optional)
        $capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $capsule->bootEloquent();
    }

    /**
     * Opens DB connection
     * @return boolean
     * @throws DatabaseException
     */
    public static function db_open()
    {
        if (FJF_BASE::db_is_connected()) {
            return true;
        }

        /** makes mysqli driver to throw exceptions instead of warnings */
        $driver = new mysqli_driver();
        $driver->report_mode = MYSQLI_REPORT_STRICT;

        FJF_BASE::log("Params:[host=" . $GLOBALS["WEB_APPLICATION_CONFIG"]["db_host"] . ",port=" . $GLOBALS["WEB_APPLICATION_CONFIG"]["db_port"] . ",dbname=" . $GLOBALS["WEB_APPLICATION_CONFIG"]["db_name"] . ",user=" . $GLOBALS["WEB_APPLICATION_CONFIG"]["db_user"] . ",password=***]", __METHOD__);

        try {
            $GLOBALS["WEB_APPLICATION_CONFIG"]["db_connection"] = new mysqli(
                isset($GLOBALS["WEB_APPLICATION_CONFIG"]["db_host"]) && $GLOBALS["WEB_APPLICATION_CONFIG"]["db_host"] ? $GLOBALS["WEB_APPLICATION_CONFIG"]["db_host"] : null,
                isset($GLOBALS["WEB_APPLICATION_CONFIG"]["db_user"]) && $GLOBALS["WEB_APPLICATION_CONFIG"]["db_user"] ? $GLOBALS["WEB_APPLICATION_CONFIG"]["db_user"] : null,
                isset($GLOBALS["WEB_APPLICATION_CONFIG"]["db_password"]) && $GLOBALS["WEB_APPLICATION_CONFIG"]["db_password"] ? $GLOBALS["WEB_APPLICATION_CONFIG"]["db_password"] : null,
                isset($GLOBALS["WEB_APPLICATION_CONFIG"]["db_name"]) && $GLOBALS["WEB_APPLICATION_CONFIG"]["db_name"] ? $GLOBALS["WEB_APPLICATION_CONFIG"]["db_name"] : null,
                isset($GLOBALS["WEB_APPLICATION_CONFIG"]["db_port"]) && $GLOBALS["WEB_APPLICATION_CONFIG"]["db_port"] ? $GLOBALS["WEB_APPLICATION_CONFIG"]["db_port"] : null
            );

        } catch (mysqli_sql_exception $e) {
            throw new DatabaseException("DB connection failed: " . $e->getMessage(), null, $e);
        }

        FJF_BASE::log("DB Connection Established", __METHOD__);

        $now = new DateTime();
        $mins = $now->getOffset() / 60;
        $sgn = $mins < 0 ? -1 : 1;
        $mins = abs($mins);
        $hrs = floor($mins / 60);
        $mins -= $hrs * 60;

        $GLOBALS["WEB_APPLICATION_CONFIG"]["db_connection"]->query(
            "SET time_zone='" . sprintf('%+d:%02d', $hrs * $sgn, $mins) . "'"
        );

        return true;
    }


    /**
     * Checks if DB is connected
     * @return boolean
     */
    public static function db_is_connected()
    {
        return $GLOBALS["WEB_APPLICATION_CONFIG"]["db_connection"] && $GLOBALS["WEB_APPLICATION_CONFIG"]["db_connection"]->ping();
    }


    /**
     * Updates DB record
     * @param string $table
     * @param array $data
     * @param string $criteria
     * @param boolean $debug
     * @return boolean
     * @throws DatabaseException
     */
    public static function db_update($table, $data, $criteria, $debug = false)
    {
        FJF_BASE::log("Params: [table:$table,data:" . json_encode($data) . ",criteria:$criteria]", __METHOD__);

        $sql_temp = "";
        $sql = "UPDATE $table SET ";

        if (!is_array($data)) {
            throw new DatabaseException("Invalid Data parameter");
        }

        reset($data);
        
        foreach($data as $field => $value){
            if ($value === null) {
                $sql_temp .= $field . "=NULL,";
            } else {
                $sql_temp .= $field . "='" . FJF_BASE::db_escape($value) . "',";
            }
        }
        
        $sql .= substr($sql_temp, 0, strlen($sql_temp) - 1);

        if ($criteria != null) {
            $sql .= " WHERE " . $criteria;
        }

        FJF_BASE::log($sql, __METHOD__);

        if ($debug) {
            exit($sql);
        }

        $result = $GLOBALS["WEB_APPLICATION_CONFIG"]["db_connection"]->query($sql);

        if (!$result) {
            throw new DatabaseException("Query execution failed");
        }

        FJF_BASE::log("SUCCESS", __METHOD__);

        return true;
    }


    /**
     * Inserts DB record
     * @param string $table
     * @param array $data
     * @param string $primary_key
     * @return integer
     * @throws DatabaseException
     */
    public static function db_insert($table, $data, $primary_key)
    {
        FJF_BASE::log("Params: [table:$table,data:" . json_encode($data) . ",pk:$primary_key]", __METHOD__);

        $sql_temp1 = "";
        $sql_temp2 = "";
        $sql = "INSERT INTO $table (";

        if (!is_array($data)) {
            throw new DatabaseException("Invalid Data parameter");
        }

        reset($data);
        
        foreach($data as $field => $value){
            if ($field != $primary_key) {
                $sql_temp1 .= $field . ",";
                if ($value === null) {
                    $sql_temp2 .= "NULL,";
                } else {
                    $sql_temp2 .= "'" . FJF_BASE::db_escape($value) . "',";
                }
            }
        }
        $sql .= rtrim($sql_temp1, ", ") . ") VALUES (" . rtrim($sql_temp2, ", ") . ")";

        FJF_BASE::log($sql, __METHOD__);

        $result = $GLOBALS["WEB_APPLICATION_CONFIG"]["db_connection"]->query($sql);
        if (!$result) {
            throw new DatabaseException("Query execution failed");
        }

        $nextID = $GLOBALS["WEB_APPLICATION_CONFIG"]["db_connection"]->insert_id;

        FJF_BASE::log("SUCCESS. Returned value is: " . $nextID, __METHOD__);

        return $nextID;
    }


    /**
     * Replaces DB record
     * @param string $table
     * @param array $data
     * @return boolean
     * @throws DatabaseException
     */
    public static function db_replace($table, $data)
    {
        FJF_BASE::log("Params: [table:$table,data:" . json_encode($data) . "]", __METHOD__);

        $sql_temp1 = "";
        $sql_temp2 = "";
        $sql = "REPLACE INTO $table (";

        if (!is_array($data)) {
            throw new DatabaseException("Invalid Data parameter");
        }

        reset($data);
        
        foreach($data as $field => $value){
            $sql_temp1 .= $field . ",";
            if ($value === null) {
                $sql_temp2 .= "NULL,";
            } else {
                $sql_temp2 .= "'" . FJF_BASE::db_escape($value) . "',";
            }
        }

        $sql .= rtrim($sql_temp1, ", ") . ") VALUES (" . rtrim($sql_temp2, ", ") . ")";

        FJF_BASE::log($sql, __METHOD__);

        $result = $GLOBALS["WEB_APPLICATION_CONFIG"]["db_connection"]->query($sql);

        if (!$result) {
            throw new DatabaseException("Query execution failed");
        }

        FJF_BASE::log("SUCCESS.", __METHOD__);

        return $result;
    }


    /**
     * Closes db connection
     */
    public static function db_close()
    {
        $GLOBALS["WEB_APPLICATION_CONFIG"]["db_connection"] && $GLOBALS["WEB_APPLICATION_CONFIG"]["db_connection"]->close();
    }


    /**
     * Gets single DB record
     * @param string $table
     * @param string $criteria
     * @param string $sort
     * @return mixed
     * @throws DatabaseException
     */
    public static function db_get_one($table, $criteria, $sort = null)
    {
        FJF_BASE::log("Params: [table:$table,criteria:$criteria,sort:$sort]", __METHOD__);

        if (!$criteria) {
            throw new DatabaseException("Invalid Criteria parameter");
        }

        $sql = "SELECT * FROM $table WHERE $criteria";

        if ($sort != null) {
            $sql .= " ORDER BY " . $sort;
        }

        FJF_BASE::log($sql, __METHOD__);

        $result = $GLOBALS["WEB_APPLICATION_CONFIG"]["db_connection"]->query($sql);

        if (!$result) {
            throw new DatabaseException("Query execution failed");
        }

        switch ($result->num_rows) {
            case 0:
                FJF_BASE::log("No data was returned", __METHOD__);
                $return = 0;
            default:
                $record = $result->fetch_object();
                $return = $record;
        }

        $result->close();

        return $return;
    }


    /**
     * Returns multiple DB records
     * @param string $sql
     * @return mixed
     * @throws DatabaseException
     */
    public static function db_get_many($sql)
    {
        FJF_BASE::log($sql, __METHOD__);
        $return = null;

        $result = $GLOBALS["WEB_APPLICATION_CONFIG"]["db_connection"]->query($sql);

        if (!$result) {
            throw new DatabaseException("Query execution failed");
        }

        switch ($result->num_rows) {
            case 0:
                FJF_BASE::log("No data was returned", __METHOD__);
                $return = 0;
            default:
                $records = array();
                for ($i = 0; $i < $result->num_rows; $i++) {
                    $result->data_seek($i);
                    $record = $result->fetch_object();
                    $key = (isset($GLOBALS["WEB_APPLICATION_CONFIG"]["FJF_BASE_key"]) && isset($record->{$GLOBALS["WEB_APPLICATION_CONFIG"]["FJF_BASE_key"]})) ? $record->{$GLOBALS["WEB_APPLICATION_CONFIG"]["FJF_BASE_key"]} : $i;
                    $records[$key] = $record;
                }
                if (count($records) > 0) {
                    FJF_BASE::log("Got '" . count($records) . "' records", __METHOD__);
                    $return = $records;
                }
        }

        $result->close();
        if (isset($GLOBALS["WEB_APPLICATION_CONFIG"]["FJF_BASE_key"])) {
            unset($GLOBALS["WEB_APPLICATION_CONFIG"]["FJF_BASE_key"]);
        }

        return $return;
    }


    /**
     * Executes SQL query
     * @param string $sql
     * @return boolean
     * @throws DatabaseException
     */
    public static function db_execute($sql)
    {
        $result = $GLOBALS["WEB_APPLICATION_CONFIG"]["db_connection"]->query($sql);

        if (!$result) {
            throw new DatabaseException("Query execution failed");
        }

        FJF_BASE::log("Successfully executed: $sql", __METHOD__);

        return true;
    }


    /**
     * Gets affected rows count
     * @return integer
     */
    public static function db_affected_rows()
    {
        return $GLOBALS["WEB_APPLICATION_CONFIG"]["db_connection"]->affected_rows;
    }


    /**
     * Replaces query parameters
     * @param string $str
     * @param  array $params
     * @return string
     */
    public static function replace_params($str, $params)
    {
        if (is_array($params) && !empty($params)) {
            foreach ($params as $search => $replace) {
                $str = str_replace($search, FJF_BASE::db_escape($replace), $str);
            }
        }
        return $str;
    }


    /**
     * MD5 encryption
     * @param string $plain_text
     * @param string $password
     * @param integer $iv_len
     * @return string
     */
    public static function encrypt($plain_text, $password, $iv_len = 16)
    {
        $plain_text .= "\x13";
        $n = strlen($plain_text);
        if ($n % 16) {
            $plain_text .= str_repeat("\0", 16 - ($n % 16));
        }
        $i = 0;
        $enc_text = FJF_BASE::getRandChar($iv_len);
        $iv = substr($password ^ $enc_text, 0, 512);
        while ($i < $n) {
            $block = substr($plain_text, $i, 16) ^ pack('H*', md5($iv));
            $enc_text .= $block;
            $iv = substr($block . $iv, 0, 512) ^ $password;
            $i += 16;
        }
        $encStr = base64_encode($enc_text);
        FJF_BASE::log("Encrypting '$plain_text' into  #$%^&** ....", __METHOD__);
        return $encStr;
    }


    /**
     * MD5 decryption
     * @param string $enc_text
     * @param string $password
     * @param integer $iv_len
     * @return string
     */
    public static function decrypt($enc_text, $password, $iv_len = 16)
    {
        $enc_text = base64_decode($enc_text);
        $n = strlen($enc_text);
        $i = $iv_len;
        $plain_text = '';
        $iv = substr($password ^ substr($enc_text, 0, $iv_len), 0, 512);
        while ($i < $n) {
            $block = substr($enc_text, $i, 16);
            $plain_text .= $block ^ pack('H*', md5($iv));
            $iv = substr($block . $iv, 0, 512) ^ $password;
            $i += 16;
        }
        $res = preg_replace('/\\x13\\x00*$/', '', $plain_text);
        FJF_BASE::log("Decrypting #$%^&** into.... $res", __METHOD__);
        return $res;
    }


    /**
     * Generates random chars
     * @param integer $iv_len
     * @return string
     */
    public static function getRandChar($iv_len)
    {
        $iv = '';
        while ($iv_len-- > 0) {
            $iv .= chr(mt_rand() & 0xff);
        }
        return $iv;
    }


    /**
     * Generates random token
     * @param integer $iv_len
     * @return string
     */
    public static function getRandToken($len)
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $len; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    /**
     * @param $string
     * @return string
     */
    public static function ucname($string)
    {
        $string = ucwords(strtolower($string));
        foreach (array('-', '\'') as $delimiter) {
            if (strpos($string, $delimiter) !== false) {
                $string = implode($delimiter, array_map('ucfirst', explode($delimiter, $string)));
            }
        }
        return $string;
    }

    /**
     * @param $value
     * @return mixed
     */
    public static function moneyFormat($value)
    {
        return str_replace('.00', '', number_format($value, 2, '.', ','));
    }

    /**
     * @param $value
     * @return float
     */
    public static function moneyUnformat($value)
    {
        $cleanString = preg_replace('/([^0-9\.,])/i', '', $value);
        $onlyNumbersString = preg_replace('/([^0-9])/i', '', $value);
        $separatorsCountToBeErased = strlen($cleanString) - strlen($onlyNumbersString) - 1;
        $stringWithCommaOrDot = preg_replace('/([,\.])/', '', $cleanString, $separatorsCountToBeErased);
        $removedThousandSeparator = preg_replace('/(\.|,)(?=[0-9]{3,}$)/', '', $stringWithCommaOrDot);
        return (float)str_replace(',', '.', $removedThousandSeparator);
    }

}


/**
 * Custom exception class to handle DB exceptions
 */
class DatabaseException extends Exception
{

    public function __construct($message, $code = 0, $previous = null)
    {
        if ($GLOBALS["WEB_APPLICATION_CONFIG"]["db_connection"] && $GLOBALS["WEB_APPLICATION_CONFIG"]["db_connection"]->connect_error) {
            $GLOBALS["WEB_APPLICATION_CONFIG"]["db_error"] = $GLOBALS["WEB_APPLICATION_CONFIG"]["db_connection"]->connect_error;
            $message = $message . ": " . $GLOBALS["WEB_APPLICATION_CONFIG"]["db_error"];
        } else {
            $GLOBALS["WEB_APPLICATION_CONFIG"]["db_error"] = $message;
        }

        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return implode(": ", array(__CLASS__, $this->message, $this->file, $this->line));
    }

}

?>