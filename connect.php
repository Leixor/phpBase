<?php
    // Class for handling conn related stuff
    class connection
    {
        // conn attribute declarations
        private $servername;
        private $username;
        private $password;
        private $databaseName;
        private $conn;

        private $pQueries = array();

        // Constructor which creates a conn
        function __construct($servername, $username, $password, $databaseName)
        {
            $this->servername = $servername;
            $this->username = $username;
            $this->password = $password;
            $this->databaseName = $databaseName;

            $this->openConnection();
        }

        function __destruct()
        {
            $this->conn = null;
        }

        // Return the conn for access to functions
        public function getConnection()
        {
            return $this->conn;
        }


        // Open the conn and check if the conn was succesfully built
        private function openConnection()
        {
            try
            {
                // Create conn
                $this->conn = new PDO('mysql:host='.$this->servername.';dbname='.$this->databaseName, $this->username, $this->password);
            }

            catch(PDOException $e)
            {
                die("conn failed: " . $e->getMessage());
            }

            // Throw every error, not only php errors
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        // Make a query and return if its succesfull
        public function query($query)
        {
            // Check if execution if succesfull
            if($result = $this->conn->query($query))
            {
                return $result;
            }
            else
            {
                return $this->conn->error;
            }
        }

        // Add parameterzied Query to pQuery array
        public function addPQuery($name, $query)
        {
            $this->pQueries[$name] = $this->conn->prepare($query);
        }


        // Make a parameterized Query
        public function pQuery($name, $parameters)
        {
            // Prepare the statement
            if(array_key_exists($name, $this->pQueries))
            {
                $result = $this->pQueries[$name];
            }
            else
            {
                echo "Parameterized query does not exist under the name:" .$name;
                return FALSE;
            }

            // Check if execution if succesfull
            if($result->execute($parameters))
            {
                return $result;
            }
            else
            {
                return $this->conn->error;
            }
        }
    }
?>
