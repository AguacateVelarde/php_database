<?php
class user{
    private $name;
    private $pass;
    private $email;
    private $lastname;
    private $img;
    private $role;
    private $id;
    public function __construct(
              $id,
              $name,
              $pass,
              $email,
              $lastname,
              $img,
              $role
    ){
      $this -> id = $id;
      $this -> name = $name;
      $this -> pass = $pass;
      $this -> email = $email;
      $this -> lastname = $lastname;
      $this -> img = $img;
      $this -> role = $role;
    }

    public function show(){
      return "<tr>" .
      "<th>" . $this ->id . "</th><th>"
       . $this -> name . "</th><th>"
       . $this -> email ."</th><th>"
       . $this -> lastname. "</th><th>"
       . $this -> role . "</th></tr>";
    }
}

class dataBase{
  private $servername = "localhost";
  private $username = "read";
  private $password = "myfuckingbitch";
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

  public function showUser( ){

    $sql =  "SELECT * FROM user";
    $users = [];
    foreach( $this ->conn -> query( $sql ) as $data ){
      array_push( $users, new user(
                                    $data['id'],
                                    $data['name'],
                                    $data['pass'],
                                    $data['email'],
                                    $data['lastname'],
                                    $data['img'],
                                    $data['role']
                                   )
                    );
    }
    print '<table style="width:100%;  border: 1px solid black; ">
          <tr>
          <th> ID </th>
           <th>Nombre</th>
           <th>Correo</th>
           <th>Apellido</th>
           <th>Rol</th>
           </tr>
      ';
    foreach( $users as $data ){
      print $data ->show();
    }
    print '</table>';
  }

}

$data = new dataBase  ;
$data -> showUser();



 ?>
