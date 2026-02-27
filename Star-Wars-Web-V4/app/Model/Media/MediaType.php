<?php

namespace App\Model\Media;

enum MediaType: string
{
    case MOVIE = "movie";
    case SERIES = "series";
    case GAME = "game";
    case BOOK = "book";
    case COMIC = "comic";
}
