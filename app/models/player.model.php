<?php

class playerModel
{
    private $db;


    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=db_tpeqatar;charset=utf8', 'root', '');
    }

    public function getAllPlayers() //OBTENGO TODOS LOS JUGADORES
    {

        $query = $this->db->prepare("SELECT * FROM players");

        $query->execute();
        $players = $query->fetchAll(PDO::FETCH_OBJ);
        return $players;
    }

    public function order($sortField, $sortType) //ORDENO
    {

        $query = $this->db->prepare("SELECT * FROM players ORDER BY $sortField $sortType ");

        $query->execute();
        $players = $query->fetchAll(PDO::FETCH_OBJ);
        return $players;
    }

    public function filter($position) //FILTRO
    {
        $query = $this->db->prepare("SELECT * FROM players WHERE position = '$position' ");
        $query->execute();
        $players = $query->fetchAll(PDO::FETCH_OBJ);
        return $players;
    }

    public function filterAndOrder($position, $field, $type) //ORDENO Y FILTRO
    {
        $query = $this->db->prepare("SELECT * FROM PLAYERS WHERE POSITION = '$position' ORDER BY $field $type");
        $query->execute();
        $players = $query->fetchAll(PDO::FETCH_OBJ);
        return $players;
    }




    public function getPlayer($id) //OBTENGO JUGADOR POR ID
    {
        $query = $this->db->prepare("SELECT * FROM players WHERE id = ?");

        $query->execute([$id]);

        $player = $query->fetch(PDO::FETCH_OBJ);

        return $player;
    }

    public function deletePlayerById($id) //ELIMINO JUGADOR POR ID
    {
        $query = $this->db->prepare('DELETE FROM players WHERE id = ?');
        $query->execute([$id]);
    }

    public function insertNewPlayer($nombre, $position, $team, $league) //INTRODUZCO UN NUEVO JUGADOR
    {
        $query = $this->db->prepare("INSERT INTO players (nombre, position, team, league) VALUES (?, ?, ?, ?)");
        $query->execute([$nombre, $position, $team, $league]);

        return $this->db->lastInsertId();
    }

    public function updatePlayerById($id, $newPlayer, $position, $team, $league) //EDITO JUGADOR POR ID
    {
        $query = $this->db->prepare("UPDATE players SET nombre = ?, position = ?, team = ?, league = ? WHERE id = ?");
        $query->execute([$newPlayer, $position, $team, $league, $id]);
    }
}
