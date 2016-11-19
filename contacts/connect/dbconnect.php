<?php
	/**
	* This is a Database processor class and functions that serve as the
	* backend processor for the whole application using sqlite database.
	* This functions is written in dynamic format that can work for most
	* CRUD operation using PHP and SQLITE3 but only the delete is not added
	* due to the fact the deleting of record is not proper in the world of
	* record keeping. Moreso PDO and prepared statement is used to tackle
	* against SQL Injection and someother database attacks
	*** Oloruntoba Samson A.K.A Samprog ...... coding is like honey.....
	*/
	class ContactList
	{
		private $conn; //a variabe that can only be accessed only form this class
		public $row_num; // a variable that can be accessed from disffent class of this project
		private $memory_db; //a variabe that can only be accessed only form this class
		function __construct()
		{
			try
			{
				//creating the database if not exist and the memory
				$this->conn = new PDO('sqlite:books.sqlite3');
				$this->memory_db = new PDO('sqlite::memory:');
				//call the table creation function
				$this->CreateTables();
			}
			catch(PDOException $e) 
			{
			    // Print PDOException message
				$this->createLog($ex);
			    echo $e->getMessage();
			}
		}

		//This function create a table named contact_book with needed fields
		function CreateTables()
		{
			$this->conn->exec("CREATE TABLE IF NOT EXISTS contact_book (
                    id INTEGER PRIMARY KEY, 
                    names TEXT, 
                    email TEXT, 
                    time INTEGER)");
		}

		//This function select all record or specific record from the database without a WHERE clause
		//Only two (2) parameters are passed for it to work as desired, the Table you want to select 
		//from and the fields you want to select but * is used for all record except otherwise
		function SelectDB($table, $fields)
		{
			$this->row_num = 0;
			try
			{
				$result = $this->conn->query("SELECT " . $fields . " FROM " . $table);
				$recs = array();
				foreach ($result as $results) 
			    {
			    	$recs[] = $results;
			    }
			    $this->row_num = count($recs);
			}
			catch(Exception $ex)
			{
				$this->createLog($ex);
				$this->row_num = -1;

			}
			return $recs;
		}

		//This function select all record or specific record from the database with a WHERE clause
		//Only two (4) parameters are passed for it to work as desired, the Table you want to select 
		//from, the fields you want to select but * is used for all record except otherwise, the column
		//name for the WHERE clause and the value for the WHERE clause
		function SelectByIdentity($table, $fields, $column, $value)
		{
			$this->row_num = 0;
			try
			{
				$sql = "SELECT " . $fields . " FROM " . $table . " WHERE " . $column . " = :" . $column;
				$res = $this->conn->prepare($sql);
				$res->execute(array(':' . $column => $value));
				$recs = array();
				foreach($res->fetchAll(PDO::FETCH_BOTH) as $row) 
				{
		        	$recs[] = $row;
				}
			    $this->row_num = count($recs);
			}
			catch(Exception $ex)
			{
				$this->createLog($ex);
				$this->row_num = -1;
			}
			return $recs;
		}

		//This function insert record into the database, only two (2) parameter is passed for 
		//it to work as desired, the Table you want to insert to and the data in an associate
		//array format in which you want to insert into the database
		function InsertDB($table, $data)
		{
			try
			{
				$fieldname = "";
				$fieldprep = "";
				foreach(array_keys($data) as $key)
				{
				    $fieldname .= $key . ", ";
				    $fieldprep .= ":" . $key . ", ";
				}
				$fieldname = substr($fieldname, 0, strlen($fieldname)-2);
				$fieldprep = substr($fieldprep, 0, strlen($fieldprep)-2);

				$insert = "INSERT INTO " . $table . " (" . $fieldname . ") VALUES (" . $fieldprep. ")";
				
				$stmt = $this->conn->prepare($insert);
			    // Bind parameters to statement variables
			    foreach(array_keys($data) as $key)
				{
				    $stmt->bindParam(':' . $key, $data[$key]);
				}
			 
			    $stmt->execute();
				return "1";
			}
			catch(Exception $ex)
			{
				$this->createLog($ex);
				return "-1";
			}
		}

		//This function Update a particular record in the database, which accept 
		//Only two (2) parameters and passed to the function to work as desired, 
		//the Table you want to update, the data to use for the update, the column
		//for the WHERE clause and the unique value for the updates.
		function UpdateDB($table, $data, $column, $value)
		{
			try
			{
				$fieldname = "";
				$fieldprep = "";
				foreach(array_keys($data) as $key)
				{
				    $fieldname .= $key . "=:" . $key . ", ";
				}
				$fieldname = substr($fieldname, 0, strlen($fieldname)-2);

				$update = "UPDATE " . $table . " SET " . $fieldname . " WHERE " . $column . " = :" . $column;
				
				$stmt = $this->conn->prepare($update);
			    // Bind parameters to statement variables
			    foreach(array_keys($data) as $key)
				{
				    $stmt->bindParam(':' . $key, $data[$key]);
				}
				$stmt->bindParam(':' . $column, $value);
			 
			    $stmt->execute();
				return "1";
			}
			catch(Exception $ex)
			{
				$this->createLog($ex);
				return "-1";
			}
		}

		//This is a Log files creation which record errors and time of the error
		function createLog($error)
		{
			$myfile = fopen("logs.txt", "a") or die("Unable to open file!");
			$date = date('d-m-Y h:i:s A');
			$txt = $date . "    Error: " . $error;
			fwrite($myfile, "\n". $txt);
			fclose($myfile);
		}
	}
?>