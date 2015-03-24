<?php
	
	require_once 'DataSource.php';
	
	class DataSourceTest extends PHPUnit_Framework_TestCase
	{
		private $pdo;
		
		function __construct() {
			require_once 'sensitive.php'; //this goes from the folder this is run from, not from the one this file is in -_-	
			$dsn = "mysql:dbname=".DB_Name;
			
			try {
			   	$this->pdo = new PDO($dsn,DB_User,DB_Pass);
			} catch(PDOException $e) {
			    die('Could not connect to the database:<br/>' . $e);
			}
		}
		
		function testPDO() {
			$statement = "SELECT * FROM `women` WHERE `is_poc` = 1";
			$woc = $this->pdo->query($statement);
			$this->assertEquals(2, $woc->rowCount()); //will break once the db is larger
			$statement = "SELECT * FROM `women`";
			$all = $this->pdo->query($statement);
			$this->assertEquals(7,$all->rowCount()); //ditto
		}
		
		function testPDOFetch() {
			$statement = "SELECT * FROM `women`";
			$women = $this->pdo->query($statement);
			$result = $women->FetchAll();
			$this->assertTrue(is_array($result));
			$this->assertEquals(7,count($result));
		}
		
		function testClass() {
			$this->data = new DataSource($this->pdo);
			$this->assertInstanceOf("DataSource",$this->data);
		}
		
		function testGetAllWomen() {
			$this->data = new DataSource($this->pdo);
			$women = $this->data->getAllWomen();
			$this->assertTrue(is_array($women));
			foreach ($women as $woman) {
				echo $woman['name'];
			}
		}
	}

?>