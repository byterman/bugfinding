<?php
    class Usuario{
        // Conneccion
        private $conn;
        // Tabla
        private $db_table = "usuarios";
        // Columnas
        public $id;
        public $nick;
        public $nombre;
        public $apellido;
        public $telefono;
        public $imagen;
        public $imagen2;
        public $descripcion;
        public $email;
        public $status;
        public $es_empresa;

        // Db conneccion
        public function __construct($db){
            $this->conn = $db;
        }
        // GET ALL
        public function getUsuarios(){
            $sqlQuery = "SELECT * FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
        // CREATE
        public function createUsuario(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        nick = :nick, 
                        nombre = :nombre, 
                        apellido = :apellido, 
                        telefono = :telefono, 
                        imagen = :imagen,
                        imagen2 = :imagen2,
                        descripcion = :descripcion,
                        email = :email,
                        status = :status,
                        es_empresa = :es_empresa"
                        ;
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->nick=htmlspecialchars(strip_tags($this->nick));
            $this->nombre=htmlspecialchars(strip_tags($this->nombre));
            $this->apellido=htmlspecialchars(strip_tags($this->apellido));
            $this->telefono=htmlspecialchars(strip_tags($this->telefono));
            $this->imagen=htmlspecialchars(strip_tags($this->imagen));
            $this->imagen2=htmlspecialchars(strip_tags($this->imagen2));
            $this->descripcion=htmlspecialchars(strip_tags($this->descripcion));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->status=htmlspecialchars(strip_tags($this->status));
            $this->es_empresa=htmlspecialchars(strip_tags($this->es_empresa));

        
            // bind data
            $stmt->bindParam(":nick", $this->nick);
            $stmt->bindParam(":nombre", $this->nombre);
            $stmt->bindParam(":apellido", $this->apellido);
            $stmt->bindParam(":telefono", $this->telefono);
            $stmt->bindParam(":imagen", $this->imagen);
            $stmt->bindParam(":imagen2", $this->imagen2);
            $stmt->bindParam(":descripcion", $this->descripcion);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":status", $this->status);
            $stmt->bindParam(":es_empresa", $this->es_empresa);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }
        // READ single
        public function getSingleUser(){
            $sqlQuery = "SELECT * FROM ". $this->db_table ." WHERE id = ? LIMIT 0,1";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->nick = $dataRow['nick'];
            $this->nombre = $dataRow['nombre'];
            $this->apellido = $dataRow['apellido'];
            $this->telefono = $dataRow['telefono'];
            $this->imagen = $dataRow['imagen'];
            $this->imagen2 = $dataRow['imagen2'];
            $this->descripcion = $dataRow['descripcion'];
            $this->email = $dataRow['email'];
            $this->status = $dataRow['status'];
            $this->es_empresa = $dataRow['es_empresa'];
        }        
        // UPDATE
        public function updateUsuario(){
            $sqlQuery = "UPDATE ". $this->db_table ." SET name = :name, email = :email, age = :age, designation = :designation, created = :created WHERE id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->nick=htmlspecialchars(strip_tags($this->nick));
            $this->nombre=htmlspecialchars(strip_tags($this->nombre));
            $this->apellido=htmlspecialchars(strip_tags($this->apellido));
            $this->telefono=htmlspecialchars(strip_tags($this->telefono));
            $this->imagen=htmlspecialchars(strip_tags($this->imagen));
            $this->imagen2=htmlspecialchars(strip_tags($this->imagen2));
            $this->descripcion=htmlspecialchars(strip_tags($this->descripcion));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->status=htmlspecialchars(strip_tags($this->status));
            $this->es_empresa=htmlspecialchars(strip_tags($this->es_empresa));
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            // bind data
            $stmt->bindParam(":nick", $this->nick);
            $stmt->bindParam(":nombre", $this->nombre);
            $stmt->bindParam(":apellido", $this->apellido);
            $stmt->bindParam(":telefono", $this->telefono);
            $stmt->bindParam(":imagen", $this->imagen);
            $stmt->bindParam(":imagen2", $this->imagen2);
            $stmt->bindParam(":descripcion", $this->descripcion);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":status", $this->status);
            $stmt->bindParam(":es_empresa", $this->es_empresa);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }
        // DELETE
        function deleteEmployee(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }
    }
?>