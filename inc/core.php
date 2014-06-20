<?
	header('Content-Type: text/html; charset=utf-8');

    //settings
    define("db_host", 'localhost');
    define("db_user", 'user');
    define("db_pass", 'pass');
    define("db_name", 'name');
    define("db_charset", 'UTF8');
    define("db_prefix", '');


	class persons
	{
	    function __construct() {
	    	//try connect to db
	        $mysqli = new mysqli(db_host, db_user, db_pass, db_name);      
	        $mysqli->set_charset(db_charset);  
	       if ($mysqli->connect_error) {
	            printf("Connect error: %s\n", $mysqli->connect_error);           
	        }
	        else
	        $this->mysqli = $mysqli;
	    }

	    function addNew($parameters)
	    {
	    	$this->params = $parameters;
	    	$this->persons = $this->params['person'];
	    	$query = "INSERT INTO `persons` (`client_id`, `date`, `coords`, `sex`, `age`) VALUES "; //coords as x1,x2,y1,y2
	    	foreach ($this->persons as $key => $value) {	    		
	    		$query .= "('{$this->params['client_id']}', '{$this->params[date]}', '{$value['coords']}', '{$value['sex']}', '{$value['age']}')";
	    		if ( (count($this->persons)) > ($key)) {$query .= ",";}
	    	}
	    	$result = $this->mysqli->query($query);
	    }

	    function getAll()
	    {
	    	$query = "Select * from `persons`";
	    	$result = $this->mysqli->query($query);
	    	echo json_encode($result->fetch_all(MYSQLI_ASSOC));	    	
	    }
	}

	class photos
	{
		const sort_dir = 'res/sort';
		const unsort_dir =  'res/unsort';
		private $file_name;
		private $handle;

		static function getPhoto ()
		{	
			usleep (100);
			if ($handle = opendir(static::unsort_dir)) {
		    while (false !== ($file = readdir($handle))) { 
		    	if ($file != "." && $file != ".." && $file!=$_COOKIE["last"]) {
	        		return "/".static::unsort_dir."/$file";
   				 }}   			
			}
			closedir($handle);
		}

		static function removePhoto($src)
		{
			$path = explode("/", $src);
			$file_name = $path[count($path)-1];
			rename( $_SERVER['DOCUMENT_ROOT']."/".static::unsort_dir."/$file_name", $_SERVER['DOCUMENT_ROOT']."/".static::sort_dir."/$file_name" );
			$_COOKIE["last"] = $file_name;
		}
	}


?>