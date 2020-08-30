<?php

class Song {
    private $con;
    private $id;
    private $mysqliData;
    private $artistId;
    private $genre;
    private $title;
    private $duration;
    private $albumId;
    private $path;

    public function __construct($con, $id) {
        $this->con = $con;
        $this->id = $id;

        $query = mysqli_query($this->con, "SELECT * FROM Songs WHERE id='$this->id'");
        $this->mysqliData = mysqli_fetch_array($query);
        $this->title = mysqliData['title'];
        $this->genre = mysqliData['genre'];
        $this->albumId = mysqliData['album'];
        $this->duration = mysqliData['duration'];
        $this->artistId = mysqliData['artist'];
        $this->path = mysqliData['path'];
    }

    public function getTitle() {
        return $this->title;
    }

    public function getArtist() {
        return new Artist($this->con, $this->artistId);
    }

    public function getAlbum() {
        return new Album($this->con, $this->albumId);
    }

    public function getGenre() {
        return $this->genre;
    }

    public function getDuration() {
        return $this->duration;
    }

    public function getPath() {
        return $this->path;
    }

    public function getMysqliData() {
        return $this->mysqliData;
    }
}

?>
