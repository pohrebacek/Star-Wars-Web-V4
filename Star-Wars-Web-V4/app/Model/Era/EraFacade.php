<?php

namespace App\Model\Era;

final class EraFacade
{
    public function __construct(
        private EraMapper $eraMapper,
        private ErasRepository $erasRepository
    ) {}

    public function getEraDTO (int $id): EraDTO
    {
        $eraRow = $this->erasRepository->getRowById($id);
        return $this->eraMapper->map($eraRow);
    }

    public function getAllEras(): array
    {
        $erasRows = $this->erasRepository->getAll();
        $eras = array();
        foreach ($erasRows as $eraRow) {
            $eras[] = $eraRow->era_name;
        }
        return $eras;
    }
}