<?php

namespace App\Model\Media;

use Nette\Utils\ArrayHash;

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

    public function getAllMediaNamesAndLabels(): array
    {
        $mediaRows = $this->mediaRepository->getAllByTimelineOrder();
        $mediaNamesAndLabels = array();
        foreach ($mediaRows as $mediaRow) {
            $mediaNamesAndLabels[] = $mediaRow->part_label ? $mediaRow->title . ': ' . $mediaRow->part_label : $mediaRow->title;
        }
        return $mediaNamesAndLabels;
    }

    public function getAllMediaDTOs(): array
    {
        $mediaRows = $this->mediaRepository->getAllByTimelineOrder();
        $mediaDTOs = array();
        foreach ($mediaRows as $mediaRow) {
            $mediaDTOs[] = $this->mediaMapper->map($mediaRow);
        }
        return $mediaDTOs;
    }

    public function getAllMediaDTOsForForm(): ArrayHash
    {
        $data = new ArrayHash();
        $mediaDTOs = $this->getAllMediaDTOs();
        foreach ($mediaDTOs as $mediaDTO) {
            $data[$mediaDTO->id] = $mediaDTO->partLabel ? $mediaDTO->title . ': ' . $mediaDTO->partLabel : $mediaDTO->title;
        }
        return $data;
    }


    public function calculateTimelineOrder(?int $mediaId): string
    {
        if ($mediaId) {
            $current = $this->mediaRepository->getRowById($mediaId);
            $next = $this->mediaRepository->getNextByTimelineOrder($current);
            if (!$next) {
                bdump('!$next');
                return bcadd($current->timeline_order, '1', 10);
            }
            bdump('$mediaId');
            $sum = bcadd($current->timeline_order, $next->timeline_order, 10);
            return bcdiv($sum, "2", 10);
        } else {
            $mediaDTO = $this->mediaMapper->map($this->mediaRepository->getFirstByTimelineOrder());
            if ($mediaDTO) {
                bdump('$mediaDTO');
                return bcsub($mediaDTO->timelineOrder, '1', 10);
            }
            bdump(':(');
            return strval(1);   //pokud v db neni žádnej záznam
        }
    }
}