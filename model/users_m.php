<?php
    Class Users_m {
        private $db;
        private $user;
        public function __construct(){
            require_once("./model/connexio.php");
            $this->db=Connexio::connectar();
            $this->user=array();
        }


        public function adduser($usuario){
          
            if ($usuario){
                $consulta =  "INSERT INTO Users (nick,pasword,nombre,apellido,telefono,imagen_perfil,imagen_banner,descripcion,email,estatus,es_empresa,fecha_creacion) VALUES
                 (:nick,:pass,:nombre,:apellido,:telefono,:img_perfil,:img_banner,:descripcion,:email,:estatus,:es_empresa,:fecha_creacion);";
                



               
                $fechaActual=date("Y-m-d H:i:s");

                print($fechaActual.PHP_EOL);
                print( $usuario->nick." ".$usuario->pass." ".$usuario->nombre." ".$usuario->apellido." ".$usuario->telefono." ".$usuario->img_perfil." ".$usuario->img_banner." ".$usuario->descripcion." ".$usuario->email." ".$usuario->estatus." ".$usuario->es_empresa  .PHP_EOL);
                
                /*
                $opciones = [
                    'cost' => 11,
                    'salt' => "soyelsalt",
                ];

                $pwdEncriptada = password_hash($usuario->pass, PASSWORD_BCRYPT,$opciones);
                */

                $pwdEncriptada = password_hash($usuario->pass, PASSWORD_BCRYPT);

                echo password_verify($usuario->pass, $pwdEncriptada.PHP_EOL);

                print("esto es la pasword encritada:      ".$pwdEncriptada.PHP_EOL);

                $dades = [
                    'nick'=>$usuario->nick,
                    'pass'=>$pwdEncriptada,
                    'nombre'=>$usuario->nombre,
                    'apellido'=>$usuario->apellido,
                    'telefono'=>$usuario->telefono,
                    'img_perfil'=>$usuario->img_perfil,
                    'img_banner'=>$usuario->img_banner,
                    'descripcion'=>$usuario->descripcion,
                    'email'=>$usuario->email,
                    'estatus'=>$usuario->estatus,
                    'es_empresa'=>$usuario->es_empresa,
                    'fecha_creacion'=>$fechaActual
                ];
                $res_insert = $this->db->prepare($consulta)->execute($dades);
                
            }

            print("Llega al return".PHP_EOL);



            return $dades['nick'];
          
        }

        /*
        public function getUser($nick){
            $consulta = "SELECT * FROM PELICULA WHERE ID =". $id .";";
            $result = $this->db->query($consulta);
            while ($fila=$result->fetch(PDO::FETCH_ASSOC)){
                return $fila;
            }
            return null;
        }
        */

        ## - - - - - - -  - - - - - - - - 







        public function getPelis(){
            $consulta = "SELECT * FROM PELICULA";
            $result = $this->db->query($consulta);
            while ($fila=$result->fetch(PDO::FETCH_ASSOC)){
                $this->pelis[]=$fila;
            }
            return $this->pelis;
        }

        public function getPeliById($id){
            $consulta = "SELECT * FROM PELICULA WHERE ID =". $id .";";
            $result = $this->db->query($consulta);
            while ($fila=$result->fetch(PDO::FETCH_ASSOC)){
                return $fila;
            }
            return null;
        }

        public function getPelisByAnyo($anyo){
            $consulta = "SELECT * FROM PELICULA WHERE ANYO =". $anyo .";";
            $result = $this->db->query($consulta);
            while ($fila=$result->fetch(PDO::FETCH_ASSOC)){
                $this->pelis[]=$fila;
            }
            return $this->pelis;
        }

        public function getPelisByPuntuacion($baix, $alt){
            $consulta = "SELECT * FROM PELICULA WHERE PUNTUACION >=". $baix ." AND PUNTUACION <=". $alt .";";
            $result = $this->db->query($consulta);
            while ($fila=$result->fetch(PDO::FETCH_ASSOC)){
                $this->pelis[]=$fila;
            }
            return $this->pelis;
        }

        public function appendPelicula($pelicula){
            $new_id = -1;
            if ($pelicula){
                $consulta = "SELECT ID FROM PELICULA ORDER BY ID DESC LIMIT 1;";
                $result = $this->db->query($consulta);
                $last_id = $result->fetch(PDO::FETCH_ASSOC)["ID"];
                $new_id = $last_id + 1;
                $consulta = "INSERT INTO PELICULA (ID, TITULO, ANYO, PUNTUACION, VOTOS) VALUES(:id, :titulo, :anyo, :puntuacion, :votos);";
                $dades = [
                    'id'=>$new_id,
                    'titulo'=>$pelicula->titulo,
                    'anyo'=>$pelicula->anyo,
                    'puntuacion'=>$pelicula->puntuacion,
                    'votos'=>$pelicula->votos
                ];
                $res_insert = $this->db->prepare($consulta)->execute($dades);
            }
            return $new_id;
        }

        public function deletePeliById($id){
            $consulta = "DELETE FROM PELICULA WHERE ID=?;";
                
            $res_delete = $this->db->prepare($consulta)->execute(array($id));
        }
    }
?>