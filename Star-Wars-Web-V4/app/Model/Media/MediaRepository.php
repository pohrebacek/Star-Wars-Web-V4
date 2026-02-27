<?php

namespace App\Model\Media;

use App\Model\Base\BaseRepository;
use Nette;

final class MediaRepository extends BaseRepository
{
    public function __construct(
        protected Nette\Database\Explorer $database,
    ) {
        $this->tableName = 'media';
    }
}