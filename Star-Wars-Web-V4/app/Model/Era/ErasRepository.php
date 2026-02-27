<?php

namespace App\Model\Era;

use App\Model\Base\BaseRepository;

final class ErasRepository extends BaseRepository
{
    public function __construct(
        protected \Nette\Database\Explorer $database
    ) {
        $this->tableName = "eras";
    }
}