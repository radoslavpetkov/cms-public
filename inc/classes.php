<?php
defined('SITE') OR exit('Неразрешен директен достъп');
 /* Основен клас на страница
 * Дава възможност за зареждане на темплейти използваме и 
 * превръща масивите в променливи
 */
 class Page{

    function __construct(){
        require_once('inc/config.php');
    }

    public function load_template($name, $data = array()){
        // $data['title'] = 'Заглавие на страницата'
        // $data['name'] = ... 
        // -> $title
        // -> $name

        if(count($data)>0){
            foreach($data AS $key=>$value){
                $$key = $value;
            }
        }
        //load file
        if(file_exists(SITE_ROOT.'template/'.$name.'.php')){
            include(SITE_ROOT.'template/'.$name.'.php');
        }else{
            exit( "Файлът: ".SITE_ROOT.'template/'.$name.'.php' . "  не е намерен");
        }
    }
 }
/* DB singleton - помощен клас
* клас за установяване на връзка с базата.
* Ако вече има връзка - връща текущата.
*/
 class ConnectDB {
	 
	 private static $instance = null;
	 private $connection;
	 
	 private $dbhost = DB_SERVER;
	 private $dbname = DB_DATABASE;
	 private $username = DB_USER;
	 private $password = DB_PASS;
	 
	 private function __construct(){
		try{
            $this->connection = new PDO("mysql:host={$this->dbhost};
				dbname={$this->dbname}",
				$this->username,
				$this->password,
				array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        } 
	 }
	 /* проверяваме дали има връзка и я връщаме
	 * ако няма - създаваме нова
	 */
	 public static function getInstance(){
		if(!self::$instance){
		  self::$instance = new ConnectDb();
		}
		return self::$instance;
	 }
	  // взимаме връзката
	  public function getConnection(){
		return $this->connection;
	  }

 }
/* ОСНОВЕН клас за заявки към базата с данни
*	Тук има методи за четирите основни операции
*/
 class Db {
	 
     private $connection = null;
	 
	 // автоматично се изпълнява при създаване на обект от този клас
     public function __construct(){
		// изпълняваме метода от класа за връзка с базата 
        $instance = ConnectDb::getInstance();
		// вземаме връзката и я записваме за да я използваме по-нататък
		$this->connection = $instance->getConnection();
     }


	/* Методи за основните операции SELECT, INSERT, UPDATE, DELETE
	* с използването на "named prepared statements"
	* например: $statement = SELECT * FROM pages WHERE category_id = :id
	* където :id името на променливата в стейтмънта

	* $parameters = array('id' => 5)
	*/
	
    //  SELECT
     public function Select($statement = '', $parameters = array()){
         try{
            $result = $this->executeStatement($statement,$parameters);
            return $result->fetchAll();

         }catch(Exception $e){
             throw new Exception($e->getMessage());
             
         }
     }
    //  INSERT
     public function Insert($statemant = '', $parameters = []){
        try{
            $this->executeStatement($statement,$parameters);
            return $this->connection->lastInsertId();

         }catch(Exception $e){
             throw new Exception($e->getMessage());
             
         } 
     }

    //  UPDATE
    public function Update($statement='',$parameyets = []){
        try{
            $this->executeStatement($statement,$parameters);
            return true;

         }catch(Exception $e){
             throw new Exception($e->getMessage());
             
         }
    }

    // DELETE
    public function Remove($statement='', $parameters = []){
        try{
            $this->executeStatement($statement,$parameters);
            return true;

         }catch(Exception $e){
             throw new Exception($e->getMessage());
             
         }
    }
     
	 // метод за стартиране на заявката към базата
     private function executeStatement($statement,$parameters){
        try{
            $stmt = $this->connection->prepare($statement);
            $stmt->execute($parameters);
            return $stmt;

         }catch(Exception $e){
             throw new Exception($e->getMessage());
             
         }
     }
 }


/** ПОДКЛАСОВЕ НА ОТДЕЛНИТЕ ВИДОВЕ СТРАНИЦИ
*    те трябва винаги да наследяват Page
**/

// Началната страница
 class HomePage extends Page{

    public function __construct(){
        parent:: __construct();
    }

    public function GetData(){
        $db = new DB;
        $sql = "SELECT * FROM pages WHERE id=1";
        $result = $db->Select($sql);

        return $result[0];
    }
 }
// новини - блог на категория
 class NewsPage extends Page{
    public function __construct(){
        parent:: __construct();
    }

    public function GetLast($number = 1){
      $number = intval(strval($number),10);
      if($number > 0){
        $db = new DB;
        $sql = "SELECT id, title, summary  FROM pages WHERE category_id = 1 AND active = 1 ORDER BY timestamp DESC LIMIT $number ";
        $result = $db->Select($sql);
        return $result;
      }else{
          return false;
      }
    }

    public function GetOne($id){
        $id = intval(strval($id),10);
        if($id >0){
            $db = new DB;
            $stmt = "SELECT * FROM pages WHERE id = :id";
            $param['id'] = $id;
            $result = $db->Select($stmt, $param);
            return $result[0];
        }else{
            return false;
        }
    }
 }

