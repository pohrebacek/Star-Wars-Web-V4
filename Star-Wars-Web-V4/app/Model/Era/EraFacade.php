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
}