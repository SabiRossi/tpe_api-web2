<?php
require_once './app/models/player.model.php';
require_once './app/views/api.view.php';
require_once './app/helpers/auth-api.helper.php';

class PlayerApiController
{
    private $model;
    private $view;
    private $data;
    private $authHelper;

    private $filterPosition;
    private $sortType;
    private $sortField;


    // CONSTRUCTOR 
    public function __construct()
    {
        $this->model = new playerModel();
        $this->view = new apiView();
        $this->authHelper = new authApiHelper;

        $this->data = file_get_contents("php://input");
        $this->filterPosition = isset($_GET['position']) ? $_GET['position'] : null;
        $this->sortType = isset($_GET['sortType']) ?   $_GET['sortType'] : null;
        $this->sortField = isset($_GET['sortField']) ?   $_GET['sortField'] : null;
    }

    private function getData()
    {
        return json_decode($this->data);
    }

    public function getPlayers()
    {
        //VERIFICO CAMPOS 

        if (!empty($this->filterPosition) && !empty($this->sortField) && !empty($this->sortType)) {

            $position = $this->filterPosition;
            $field = $this->sortField;
            $type = $this->sortType;
            //VERIFICO CAMPOS Y FILTRO Y ORDENO
            if ($this->verifyField() && (($type == 'desc') || ($type ==  'asc')) && (isset($position)) && is_numeric($position)) {

                $players = $this->model->filterAndOrder($position, $field, $type);
                $this->view->response($players, 200);
            } else {
                $this->view->response("No es posible el filtrado y ordenamiento", 404);
            }
        } else if ($this->verifyField() || (isset($this->sortType)) || isset($this->sortField)) {
            $type = $this->sortType;
            $field = $this->sortField;

            if ((($type != 'desc') && ($type != 'asc')) || !$this->verifyField()) {

                $this->view->response("No se puede ordenar", 404);
                return;
            } else {
                // ORDENO
                $players =  $this->model->order($this->sortField, $this->sortType);
                $this->view->response($players, 200);
            }
        } else if (isset($this->filterPosition) && is_numeric($this->filterPosition)) { //VERIFICO Y HAGO FILTRADO

            $position = $this->filterPosition;

            if (($position != '11') && ($position != '12') && ($position != '13') && ($position != '14') && ($position != '15')) {

                $this->view->response("No es posible realizar el filtrado", 404);
            } else {
                $filterPlayers = $this->model->filter($this->filterPosition);

                $this->view->response($filterPlayers, 200);
            }
        } else {
            $players =  $this->model->getAllPlayers();
            if ($players)
                $this->view->response($players, 200);
        }


        //sort type = ASC|DESC
        //sort field = COLUMN
    }

    private function verifyField() //VERIFICO CAMPOS
    {
        $whiteList = array(
            "id",
            "nombre",
            "position",
            "team",
            "league"

        );

        if (in_array($this->sortField, $whiteList)) {
            return true;
        }
        return false;
    }


    public function getPlayerById($params = null) //OBTENGO JUGADOR POR ID
    {
        $id = $params[':ID'];
        $player = $this->model->getPlayer($id);

        if ($player)
            $this->view->response($player, 200);
        else
            $this->view->response("El jugador con el id = $id no existe", 404);
    }

    public function deletePlayer($params = null) //ELIMINO JUGADOR POR ID
    {
        $id = $params[':ID'];

        $player = $this->model->getPlayer($id);

        if ($player) {
            $this->model->deletePlayerById($id);
            $this->view->response("El jugador " . $player->nombre . " ha sido eliminado ", 200);
        } else {
            $this->view->response("El jugador con el id = $id no existe", 404);
        }
    }

    public function insertPlayer($params = null) //AGREGO JUGADOR 
    {

        if (!$this->authHelper->isLoggedIn()) {
            $this->view->response("No se encuentra logeado", 401);
            return;
        }
        $player = $this->getData();
        if (empty($player->nombre) || empty($player->position) || empty($player->team) || empty($player->league)) {
            $this->view->response("Complete todos los datos", 404);
        } else {
            $id = $this->model->insertNewPlayer($player->nombre, $player->position, $player->team, $player->league);
            $player = $this->model->getPlayer($id);
            $this->view->response("El jugador " . $player->nombre  . " " . $player->id  . " ha sido agregado ", 201);
        }
    }

    public function updatePlayer($params = null) //EDITO JUGADOR
    {
        if (!$this->authHelper->isLoggedIn()) {
            $this->view->response("No se encuentra logueado", 401);
            return;
        }

        $id = $params[':ID'];
        $player = $this->getData();
        $playerById = $this->model->getPlayer($id);

        if (empty($player->nombre) || empty($player->position) || empty($player->team) || empty($player->league)) {
            $this->view->response('Complete todos los datos', 404);
        } else {
            $newPlayer = $player->nombre;
            $position = $player->position;
            $team = $player->team;
            $league = $player->league;
            if ($playerById) {
                $this->model->updatePlayerById($id, $newPlayer, $position, $team, $league);
                $updatePlayer = $this->model->getPlayer($id);
                $this->view->response("El jugador con el id = $id se ha modificado con exito", 200);
                $this->view->response($updatePlayer, 200);
            } else {
                $this->view->response("El jugador con el id = $id no existe", 404);
            }
        }
    }
}
