<?php
/**
 * Created by PhpStorm.
 * User: callu
 * Date: 05/05/2018
 * Time: 19:09
 */

include "db.php";

class Catalogue extends Database {
    public $artists;
    public $cds;
    public $tracks;

    public function __construct() {
        parent::__construct("localhost:3306", "root", "ttglrf", "dbi coursework");
        $this->artists = new Artists($this->conn);
        $this->cds = new CDs($this->conn);
        $this->tracks = new Tracks($this->conn);
        $this->read();
    }

    function read() {
        $stmt = read($this->conn, $this->artists->table_name, null);
        $id = null;
        $name = null;
        $stmt->bind_result($id, $name);
        while ($stmt->fetch()) {
            array_push($this->artists->artists, new Artist($id, $name));
        }

        $stmt = read($this->conn, $this->cds->table_name, null);
        $id = null;
        $artist_id = null;
        $title = null;
        $price = null;
        $genre = null;
        $num_tracks = null;
        $stmt->bind_result($id, $artist_id, $title, $price, $genre, $num_tracks);
        while ($stmt->fetch()) {
            array_push($this->cds->cds, new CD($id, $this->artists->get_by_id($artist_id), $title, $price, $genre, $num_tracks));
        }

        $stmt = read($this->conn, $this->tracks->table_name, null);
        $no = null;
        $cd_id = null;
        $name = null;
        $length = null;
        $stmt->bind_result($no, $cd_id, $name, $length);
        while ($stmt->fetch()) {
            array_push($this->tracks->tracks, new Track($no, $this->cds->get_by_id($cd_id), $name, $length));
        }
    }
}

class Artists extends Table {
    public $artists = array();

    public function __construct($conn) {
        parent::__construct("artist", $conn);
    }

    public function insert($values) {
        insert($this->conn, $this->table_name, "s",array("artName"), $values);
    }

    function table() {
        $values = array();
        foreach ($this->artists as $artist) {
            array_push($values, $artist->to_val_array());
        }
        draw_table(array("ID", "Name"), $values);
    }

    function get_by_id($id) {
        return $this->artists[$id-1];
    }

    function remove($id) {

    }
}

class CDs extends Table {
    public $cds = array();

    public function __construct($conn) {
        parent::__construct("cd", $conn);

    }

    function insert($entries) {
        // TODO: Implement insert() method.
    }

    function table() {
        $values = array();
        foreach ($this->cds as $cd) {
            array_push($values, $cd->to_val_array());
        }
        draw_table(array("ID", "Title","Artist", "Price", "Genre", "Number of Tracks"), $values);
    }

    function get_by_id($id) {
        return $this->cds[$id-1];
    }

    function remove($id) {
        remove($this->conn, $this->table_name, "i", array("cdID"), array($id));
    }
}

class Tracks extends Table {
    public $tracks = array();

    public function __construct($conn) {
        parent::__construct("track", $conn);
    }

    function insert($entries) {
    }

    function table() {
        $values = array();
        foreach ($this->tracks as $track) {
            array_push($values, $track->to_val_array());
        }
        draw_table(array("ID", "Track #","CD", "Name", "Length"), $values);
    }

    function get_by_id($id) {
        foreach ($this->tracks as $track){
            if($track->id == $id){
                return $track;
            }
        }
    }

    function remove($id) {
        $track = $this->get_by_id($id);
        remove($this->conn, $this->table_name, "ii", array("trackNo", "cdID"), array($track->no, $track->cd->id));
    }
}

class Artist extends Entity {
    public $cds = array();
    public $name;

    public function __construct($id, $name) {
        parent::__construct($id);
        $this->name = $name;
    }

    function to_val_array() {
        return array($this->id, $this->name);
    }
}

class CD extends Entity {
    public $tracks = array();
    public $artist;
    public $title;
    public $price;
    public $genre;
    public $num_tracks;

    public function __construct($id, $artist, $title, $price, $genre, $num_tracks) {
        parent::__construct($id);
        $this->artist = $artist;
        $this->title = $title;
        $this->price = $price;
        $this->genre = $genre;
        $this->num_tracks = $num_tracks;
    }

    function to_val_array() {
        return array($this->id, $this->title, $this->artist->name, $this->price, $this->genre, $this->num_tracks);
    }
}

class Track extends Entity {
    public $no;
    public $cd;
    public $name;
    public $length;

    public function __construct($no, $cd, $name, $length) {
        parent::__construct((int)($no . $cd->id));
        $this->no = $no;
        $this->cd = $cd;
        $this->name = $name;
        $this->length = $length;
    }

    function to_val_array() {
        return array($this->id, $this->no, $this->cd->title, $this->name, $this->length);
    }
}

