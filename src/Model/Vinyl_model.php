<?php

namespace App\Model;

//use Cassandra\Date;

class VinylModel
{
    public function __construct(
        private int $record_id,
        private string $record_name,
        private string $record_image,
        private string $artist_name,
        private date $created_at,
        private int $record_sequence,
    )
    {

    }

    /**
     * @return string
     */
    public function getGenre(): string
    {
        return $this->genre;
    }

    /**
     * @return string
     */
    public function getAlbumTitle(): string
    {
        return $this->album_title;
    }

    public function getArtist(): string
    {
        return $this->artist;
    }

    public function getReleaseDate(): string
    {
        return $this->release_date;
    }

}