<?php    
    session_start();
    // if(empty($_SESSION['username'])):
    //     header('location:Login.php');
    // endif;

    class Database{
        protected $host='localhost';
        protected $dbname='mydbworking';
        protected $username='root';
        protected $password='';
        protected $con;

        public function Connection(){
            $this->con=null;
            try{
                $this->con=new PDO('mysql:host='.$this->host.';dbname='.$this->dbname.'',
                $this->username,$this->password);
                $this->con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                echo 'Error ! '.$e->getMessage();
            }
            return $this->con;
        }
    }
?>