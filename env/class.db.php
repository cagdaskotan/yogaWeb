<?php
setlocale(LC_ALL, 'tr_TR.UTF-8');
date_default_timezone_set('Europe/Istanbul');
ini_set('memory_limit', '8192M');

class dbClass {

	//CONNECTION CONFIGS
	/*
	private $dbhost = "localhost";
	private $dbuser = "atif";
	private $dbpass = "Atif123654*";
	private $dbname = "atif_yoga";
	private $connect;
	*/

	private $dbhost = "localhost";
	private $dbuser = "root";
	private $dbpass = "";
	private $dbname = "yoga";
	private $connect;

	public function __construct() {
		try {
			$this->connect = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
			$this->connect->set_charset("utf8");
			if (!$this->connect) {
				throw new Exception("Veritabanı bağlantısı başarısız oldu: " . mysqli_connect_error());
			}
		} catch (Exception $e) {
			echo "
			<div style='margin: 50px auto; padding: 20px; max-width: 500px; border: 1px solid #cc0000; background-color: #ffeeee; color: #cc0000; font-family: Arial, sans-serif; font-size: 16px; text-align: center;'>
				<h2 style='margin-top: 0;'>Bağlantı Hatası</h2>
				<p>" . $e->getMessage() . "</p>
			</div>";
			exit;
		}
	}
	
	

	//GLOBAL FUNCTIONS (DB QUERIES)

	function deleteData($table,$id,$userID) {
		$date = date("Y-m-d H:i:s");
		$q = "UPDATE ".$table." SET isDelete = 1, deletedDate = '".$date."', deletedUID = '".$userID."' WHERE ID = ".$id;
		return $this->q($q);

	}

	function updateData($table,$condition,$id) {

		$set = '';

		foreach($condition as $anahtar => $deger) {
			$set .= $anahtar." = '".$deger."',";
		}
		
		$set = substr($set,0,strlen($set)-1);
		$query = 'UPDATE '.$table.' SET '.$set.' WHERE ID = '.$id;

		if(!$this->q($query)) {
			return false;
		}else{
			return true;
		}
	}
	
	function insertData($table,$veriler) {
		
		$fields = "";
        $datas = "";
        foreach ($veriler as $anahtar => $deger) {
            $fields .= $anahtar . ",";
            $datas .= "'".$deger."',";
        }
		$fields = substr($fields,0,strlen($fields)-1);
        $datas = substr($datas,0,strlen($datas)-1);
		
		$q = "INSERT INTO ".$table." (".$fields.") VALUES (".$datas.")";
		
		if(!$this->q($q)) {
			return false;
		}else{
			return true;
		}
	}
	function lastinsertid(){
		return mysqli_insert_id($this->connect);
	}

	function stripper($string) {
		return stripslashes(strip_tags($string));
	}

	function object($q) {
		return mysqli_fetch_object($q);
	}
	
	function rescape($string) {
		return mysqli_real_escape_string($this->connect,$string);
	}
	
	function numrows($q) {
		return mysqli_num_rows($q);
	}
	
	function fassoc($q) {
		return mysqli_fetch_assoc($q);
	}
	
	function q($q) {
		return mysqli_query($this->connect,$q);
	}

	public function __destruct() {
		$this->connect = null;
	}
	
}

$db = new dbClass();


?>