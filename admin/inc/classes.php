<?php
defined('SITE') OR exit('Неразрешен директен достъп');
 class Page{

    function __construct(){
        require_once('inc/config.php');
    }

    public function is_loged(){
        if(isset($_SESSION['user']['loged']) AND $_SESSION['user']['loged'] === true){
            return true;
        }else{
            return false;
        }
    }

    public function show_errors(){
        $return = '';
        if(isset($_SESSION['errors']) AND count($_SESSION['errors'])>0){
            $return = '<div class="alert alert-danger">
            <strong>Грешка!</strong> '.implode('<br>',$_SESSION['errors']).'
          </div>';
          unset($_SESSION['errors']);
        }
        return $return;
    }

    public function show_success(){
        $return = '';
        if(isset($_SESSION['success']) AND count($_SESSION['success'])>0){
            $return = '<div class="alert alert-success">
            <strong>Успех!</strong> '.implode('<br>',$_SESSION['success']).'
          </div>';
          unset($_SESSION['success']);
        }
        return $return;
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
        if(file_exists(ADMIN_SITE_ROOT.'template/'.$name.'.php')){
            include(ADMIN_SITE_ROOT.'template/'.$name.'.php');
        }else{
            exit( "Файлът: ".ADMIN_SITE_ROOT.'template/'.$name.'.php' . "  не е намерен");
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



     // $statement = SELECT * FROM pages WHERE category_id = :id
     // $parameters = array('id' => 5)

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
     public function Insert($statement = '', $parameters = []){
        try{
            $this->executeStatement($statement,$parameters);
            return $this->connection->lastInsertId();

         }catch(Exception $e){
             throw new Exception($e->getMessage());
             
         } 
     }

    //  UPDATE
    public function Update($statement='',$parameters = []){
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

class User extends Page {


    public function check_user($username = '',$password = ''){
        if(strlen($username) == 0 OR strlen($password) == 0){
            return false;
        }

        $db = new DB;
        $users = $db->Select('SELECT * FROM users WHERE active = 1 AND username = :username', array('username'=>$username));
        if(count($users) == 0){
            return false;
        }
        foreach($users AS $user){
            if(password_verify($password,$user['password'])){
                $_SESSION['user']['loged'] = true;
                $_SESSION['user']['id'] = $user['id'];
                $_SESSION['user']['names'] = $user['names'];
                $_SESSION['user']['username'] = $user['username'];
                $_SESSION['user']['active'] = $user['active'];
                return true;
            }
        }
        return false;
    }
}

class AllPages extends Page {

    public function get_all(){
        $db = new Db;
        $stmt = 'SELECT p.id, p.title, p.category_id, c.name AS category, p.active FROM pages AS p LEFT JOIN categories AS c ON c.id = p.category_id';
        $result = $db->Select($stmt);
        return $result;
    }
}

class SinglePage extends Page {
    var $id;

    public function set_id($id=0){
        $this->id = $id;
    }

    public function get_page(){
        $db = new Db;
        $result = $db->Select('SELECT * FROM pages WHERE id = :id',array('id'=> $this->id));
        return $result[0];
     }

    public function check_post($data){
        $alloyed_keys = array(
            'title'=>'TITLE','summary'=>'SUMMARY','content'=>'CONTENT','category_id'=>'INT','active'=>'INT'
        );

        foreach($alloyed_keys AS $key=>$value){
            if(isset($data[$key])){
                if($this->check($data[$key],$value) !== false){
                    $result[$key] = $this->check($data[$key],$value);
                }
            }
        }
		if(isset($_SESSION['errors']) AND count($_SESSION['errors'])>0){
			$result = false;
		}
        return $result;
    }

    public function save_edit($data, $id){
        if(count($data)>0){
            $tmp = array();
            foreach($data AS $k=>$v){
                $tmp[] = $k."=".':'.$k;
            }
            $statement = 'UPDATE pages SET '.implode(', ',$tmp).' WHERE id='.$id;
            $db = new Db;
            $db->Update($statement,$data);
        }
    }

    public function add_page($data){
        if(count($data)>0){
            $keys = [];
            $values = [];
            foreach($data AS $k=>$v){
                $keys[] = $k;
                $kkeys[] = ':'.$k;
                
            }
            $statement = 'INSERT INTO pages ( '.implode(', ',$keys).') VALUES ('.implode(', ',$kkeys).')';
            $db = new Db;
            $db->Insert($statement,$data);
        }
    }


    private function check($data,$type){
        if($type == 'INT'){
            return intval(strval($data),10);
            //return $data;
        }
        if($type == 'TITLE'){
            if(strlen(strip_tags(trim($data))) >120 OR  strlen(strip_tags(trim($data))) < 1){
                $_SESSION['errors'][] = 'Заглавието не трябва да е празно и с дължина до 120 символа!';
				return false;
            }
            return strip_tags(trim($data)); 
        }

        if($type == 'SUMMARY'){
            if(strlen(strip_tags(trim($data))) >350 OR strlen(strip_tags(trim($data))) < 1){
				$_SESSION['errors'][] = 'Краткия текст не трябва да е празен и с дължина до 350 символа!';
                return false;
            }
            return strip_tags(trim($data)); 
        }

        if($type == 'CONTENT'){
            return trim($data);
        }
    }

}

class Upload extends Page{
    public function upload_file($file = []) {
        // upload folder
        $folder = SITE_ROOT.'/images/';

       // file exists
       if(file_exists($folder.$file['name'])){
           $_SESSION['errors'][] = 'Файл с такова име вече съществува!';
       }
       
       // големина на файла
       $max_file_size = 50; // големина на файла в KB
       if($file['size']> $max_file_size*1024){
           $_SESSION['errors'][] = "Файлът не трябва да е по-голям от $max_file_size KB!"; 
       }

       // разрешен файлов формат
       $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
       if($ext != 'jpg' AND $ext != 'jpeg' AND $ext != 'bmp' AND $ext != 'png' AND $ext != 'doc' AND $ext != 'docx' AND $ext != 'pdf' ){
           $_SESSION['errors'][] = 'Само *.jpg, *.jpeg, *.bmp, *.png, *.doc(x) и *.pdf са позволени!';
       }

       //if errors
       if(isset($_SESSION['errors']) AND count($_SESSION['errors'])>0){
           return false;
       }else{
           if(move_uploaded_file($file['tmp_name'], $folder.$file['name'])){
               return true;
           }else{
               $_SESSION['errors'][] = 'Неуспех при качването на файла!';
           }
           return false;
       }

    }

    public function get_files(){
        //folder
        $folder = '../images/';
        $files = glob($folder.'*.{jpg,jpeg,bmp,png,doc,docx,pdf}', GLOB_BRACE);
        return $files;
    }
}


