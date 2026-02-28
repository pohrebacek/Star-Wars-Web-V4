<?php

namespace App\Presentation\Timeline;

use App\Presentation\Base\BasePresenter;
use App\Model\Media\MediaFacade;
use Nette;

final class TimelinePresenter extends BasePresenter
{
    public function __construct(
        private MediaFacade $mediaFacade
    ) {}
    public function renderShow(): void
    {
        $this->template->mediaDTOs = $this->mediaFacade->getAllMediaDTOs();
    }

}