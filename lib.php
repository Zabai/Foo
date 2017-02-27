<?php
class View{
    public static function header($title){
        $html = <<<HEADER
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8">
                <link rel="stylesheet" type="text/css" href="../estilos.css">
                <script src="scripts.js"></script>
                <title>$title</title>
            </head>
            <body>
HEADER;
        User::session_start();
        echo $html;
    }
    public static function navigation(){
        echo <<<NAV
        <nav>
            <ul>
                <li><a href="index.html" class="active">Inicio</a></li>
                <li><a href="tabla.html">Productos</a></li>
                <li><a href="contacto.html">Contacto</a></li>
            </ul>
        </nav>
NAV;
    }
    public static function printHTML($html){
        echo $html;
    }
    public static function end(){
        echo '</body>
        </html>';
    }
}

class DB{
    private static $connection=null;
    public static function get(){
        if(self::$connection === null){
            self::$connection = $db = new PDO("sqlite:./datos.db");
            self::$connection->exec('PRAGMA foreign_keys = ON;');
            self::$connection->exec('PRAGMA encoding="UTF-8";');
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$connection;
    }
    public function execute_sql($sql,$parms=null){
        try {
            $db = $this->get();
            $ints= $db->prepare ( $sql );
            if ($ints->execute($parms)) {
                return $ints;
            }
        }
        catch (PDOException $e) {
            echo '<h1>Error en la base de datos: ' . $e->getMessage() . '</h1>';
        }
        return "";
    }
}
class User{
    public static function session_start(){
        if(session_status () === PHP_SESSION_NONE){
            session_start();
        }
    }
    public static function getLoggedUser(){ //Devuelve un array con los datos del cuenta o false
        self::session_start();
        if(!isset($_SESSION['user'])) return false;
        return $_SESSION['user'];
    }
    public static function login($usuario,$pass){ //Devuelve verdadero o falso según
        self::session_start();
        $db=DB::get();
        $inst=$db->prepare('SELECT * FROM usuarios WHERE usuario=? and clave=?');
        $inst->execute(array($usuario,md5($pass)));
        $inst->setFetchMode(PDO::FETCH_NAMED);
        $res=$inst->fetchAll();
        if(count($res)==1){
            $_SESSION['user']=$res[0]; //Almacena datos del usuario en la sesión
            return true;
        }
        return false;
    }
    public static function logout(){
        self::session_start();
        unset($_SESSION['user']);
    }
}
