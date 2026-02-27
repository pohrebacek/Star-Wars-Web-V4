<?php

namespace App\Model\Media;

readonly class MediaDTO
{
    function __construct(
        public int $id,
        public string $title,
        public CanonStatus $canonStatus,
        public MediaType $mediaType,
        public int $startYear,
        public int $endYear,
        public int $eraId,
        public string $partLabel,
        public string $timelineOrder,
        public DateTime $releaseDate,
        public MediaStatus $status,
    ) {}
}