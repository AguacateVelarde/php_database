<?php
class persona {
    public $servername = "localhost";
    public $username = "root";
    public $password = "";
    public $dbname = "db_formulario";

    public function enviar(){
        try {
            //$aux = $this->$servername;//,dbname=$this->$dbname,$this->$username,$this->$password;
            echo "HOLA";

            //$conn = new PDO("mysql:host='$this->servername';'dbname=$this->dbname','$this->username', '$this->password'");
            $this -> conn = new PDO( "mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //recupera las variables del html
            $nombre=$_POST['nombre'];
            $correo=$_POST['correo'];
            $mensaje=$_POST['mensaje'];

            //Prepara la conexión con el query, pero las variables dadas por el usuario aún no las sabe
            $sql = $this->conn->prepare( "INSERT INTO datos_formulario VALUES ( :nombre, :correo, :mensaje );" );
            // Se declara un arreglo donde se dan valor a las variables antes asignadas
            $values = [ "nombre" => $nombre, "correo" => $correo, "mensaje" => $mensaje ];
            //Se ejecuta el query
            $sql->execute( $values );

            echo "Nuevo dato insertado";
        }
        catch(PDOException $ex)
            {
            echo $this->$sql . "<br>" . $ex->getMessage();
            }
        $conn = null;
    }
}
$p1 = new persona();
$p1->enviar();
?>
