<?php

namespace App\Model\Media;

final class MediaFacade
{
    public function __construct(
      private MediaRepository $mediaRepository,
      private MediaMapper $mediaMapper,
    ) {}

    public function getMediaDTO(int $id): MediaDTO
    {
        $mediaRow = $this->mediaRepository->getRowById($id);
        return $this->mediaMapper->map($mediaRow);
    }
}