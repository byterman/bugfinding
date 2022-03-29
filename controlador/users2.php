<?php
    require_once("./model/users_m.php");
    class users2{    
        public function __construct($params, $body){
            $method = array_shift($params);
            switch ($method){
                case "GET":
                    $this->getPelicula($params);
                    break;
                case "POST":
                    $this->anadirUsuario($params, $body);
                    break;
                case "DELETE":
                    $this->deletePelicula($params);
                    break;
                default:
                    $this->notImplementedMethodPelicula($params, $body, $method);
                    break;
            }
        }


        private function anadirUsuario($params, $body){
            $model = new Users_m();
            $peliculas = $model->adduser($body);
            //$peliculas = $model->getPeliById($newuser);
            http_response_code(201);
            require_once("./vista/users_v.php");
        }





        private function getPelicula($params){
            $model = new Peliculas_model();
            if (count($params) == 0){
                $peliculas = $model->getPelis();
            }else{
                switch (strtolower($params[0])){
                    case "id":
                        $peliculas = $model->getPeliById($params[1]);
                        break;
                    case "anyo":
                        $peliculas = $model->getPelisByAnyo($params[1]);
                        break;
                    case "puntuacion":
                        $baix = 0;
                        $alt = 10;
                        if (count($params)>2){
                            $baix = $params[1];
                            $alt = $params[2];
                        }else{
                            $alt = $params[1];
                        }
                        $peliculas = $model->getPelisByPuntuacion($baix, $alt);
                        break;
                    default:
                        echo "bad request";
                }
            }
            require_once("./vista/peliculas_v.php");
        }



        private function postPelicula($params, $body){
            $model = new Peliculas_model();
            $newId = $model->appendPelicula($body);
            $peliculas = $model->getPeliById($newId);
            http_response_code(201);
            require_once("./vista/peliculas_v.php");
        }



        private function deletePelicula($params){
            $model = new Peliculas_model();
            if (count($params) == 0){
                echo "bad request";
            }else{
                switch (strtolower($params[0])){
                    case "id":
                        $peliculas = $model->deletePeliById($params[1]);
                        break;
                    default:
                        echo "bad request";
                }
            }
            http_response_code(204);
        }

        private function notImplementedMethodPelicula($params, $method){
            header('Content-Type: application/json');
            echo json_encode(array("error"=> "Not implemented method!", "method" => $method, "params" => $params)).PHP_EOL;
        }
    }
?>