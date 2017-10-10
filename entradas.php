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
                  $id
    ){
      $this -> id_user = $id_user;
      $this -> title = $title;
      $this -> body = $body;
      $this -> date = $date;
      $this -> id = $id;


    }

    public function show(){
      return '
      <article>
    <header>
      <h1>'. $this -> title . '</h1>
      <h2>Escrito por ' . '$this -> user -> getName()' .'</h2>

      <time class="op-published" datetime="' . $this -> date . '">' . $this -> date . '</time>

      <!-- The date and time when your article was last updated -->
      <!--<time class="op-modified" dateTime="2014-12-11T04:44:16Z">December 11th, 4:44 PM</time> -->

      <!-- The authors of your article -->
      <address>
        <a rel="facebook" href="#">' .' $this -> user -> getName()' . '</a>

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

    $sql =  "SELECT * FROM entradas";
    $entradas = [];

    foreach( $this ->conn -> query( $sql ) as $data ){

      array_push( $entradas, new entrada(
                                    $data['id_user'],
                                    $data['title'],
                                    $data['body'],
                                    $data['date'],
                                    $data['id']
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
    foreach( $entradas as $data ){
      print $data ->show();
    }
    print '</table>';
  }

}

$data = new dataBase  ;
$data -> showUser();



 ?>
