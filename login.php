<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Mis entradas</title>
  </head>
  <body>

<?php
header('Content-Type: text/html; charset=utf-8');

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

    public function getEmail(){
      return $this -> email;
    }

    public function getPass(){
      return $this -> pass;
    }
    public function getId(){
      return $this -> id;
    }
    public function getName(){
      return $this -> name;
    }
}



class entrada{
    private $id_user;
    private $title;
    private $body;
    private $date;
    private $id;
    private $user;

    public function __construct(
                  $id_user,
                  $title,
                  $body,
                  $date,
                  $id,
                  $user
    ){
      $this -> id_user = $id_user;
      $this -> title = $title;
      $this -> body = $body;
      $this -> date = $date;
      $this -> id = $id;
      $this -> user = $user;

    }

    public function show(){
      return '
      <article>
    <header>
      <h1>'. $this -> title . '</h1>
      <h2>Escrito por ' . $this -> user -> getName() .'</h2>

      <time class="op-published" datetime="' . $this -> date . '">' . $this -> date . '</time>

      <!-- The date and time when your article was last updated -->
      <!--<time class="op-modified" dateTime="2014-12-11T04:44:16Z">December 11th, 4:44 PM</time> -->

      <!-- The authors of your article -->
      <address>
        <a rel="facebook" href="#">' . $this -> user -> getName() . '</a>

      </address>
      <address>
        <a>TR Vishwanath</a>
        Vish is a scholar and a gentleman.
      </address>

      <!-- The cover image shown inside your article -->
      <figure>
        <img src="http://mydomain.com/path/to/img.jpg" />
        <figcaption>This image is amazing</figcaption>
      </figure>

      <!-- A kicker for your article -->
      <h3 class="op-kicker">
        This is a kicker
      </h3>

    </header>

    <!-- Article body goes here -->

    <!-- Body text for your article -->
    <p>' . $this -> body  .'</p>

    <!-- A video within your article -->
    <figure>
      <video>
        <source src="http://mydomain.com/path/to/video.mp4" type="video/mp4" />
      </video>
    </figure>

    <!-- An ad within your article -->
    <figure class="op-ad">
      <iframe src="https://www.adserver.com/ss;adtype=banner320x50" height="60" width="320"></iframe>
    </figure>

    <!-- Analytics code for your article -->
    <figure class="op-tracker">
        <iframe src="" hidden></iframe>
    </figure>

    <footer>
      <!-- Credits for your article -->
      <aside>Acknowledgements</aside>

      <!-- Copyright details for your article -->
      <small>Legal notes</small>
    </footer>
  </article>

      ';
    }
}



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

  public function showEntry( $email, $pass ){

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
      if( $data -> getEmail() == $email && $data -> getPass() == $pass ){
        print $data ->show();
        echo "<br><br>";
        $sql =  "SELECT * FROM entradas  WHERE id_user=".$data -> getId().";";
        $entradas = [];
        foreach ($this -> conn -> query( $sql ) as $result) {
              array_push( $entradas, new entrada(
                                    $result[ 'id_user' ],
                                    $result[ 'title' ],
                                    $result[ 'body' ],
                                    $result[ 'date' ],
                                    $result[ 'id' ],
                                    $data
                ));
        }
        if( sizeof( $entradas ) > 0 ){
          foreach ($entradas as  $value) {
            header('Content-Type: text/html; charset=utf-8');
            print $value -> show();
          }
        }else{
          echo "<h1> No tienes entradas tuyas :( </h1>";
        }



      }
    }
    print '</table>';
  }

}

$data = new dataBase  ;
$data -> showEntry( $_POST[ "email" ], $_POST[ "pass" ] );



 ?>
<a href="entradas.php"><button type="button" name="button"> Ver entradas de todos </button></a>


 </body>
 </html>
