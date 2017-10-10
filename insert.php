<?php
class dataBase{
  private $servername = "localhost";
  private $username = "superfuckinguser";
  private $password = "sosad";
  private $dbname = "tecnologias";
  private $conn = NULL;


  public function __construct(){
    try {
        $this -> conn = new PDO( "mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
        $this -> conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }catch(PDOException $ex){
        echo $sql . "<br>" . $ex->getMessage();
    }
  }

  public function __destructor(){
    $conn = NULL;
  }

  public function sendUser( $name, $pass, $email, $lastname, $img, $role ){

    $sql = $this->conn->prepare( "INSERT INTO user( name, pass, email, lastname, img, role )
    VALUES ( :name, :pass, :email, :lastname, :img, :role );" );

    $values = [ "name" => $name, "pass" => $pass, "email" => $email, "lastname" => $lastname, "img" => $img, "role" => $role ];

    $result =  $sql->execute( $values );
    if ( $result ){
      echo "¡Usuario insertado exitosamente!";
      header("Location: home.html");
    }

  }

}

$data = new dataBase  ;
if( isset($_POST['name']) )
  $data -> sendUser( $_POST["name"], $_POST["pass"], $_POST["email"], $_POST["lastname"], $_POST["img"], $_POST["role"] );
else {
  echo "<h1>Error de página</h1";
}

 ?>
