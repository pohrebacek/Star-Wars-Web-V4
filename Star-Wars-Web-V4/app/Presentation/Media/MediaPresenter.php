<?php

namespace App\Presentation\Media;

use App\Model\Media\CanonStatus;
use App\Model\Media\MediaType;
use App\Model\Media\MediaRepository;
use App\Model\Media\MediaStatus;
use App\Model\Era\EraFacade;
use App\Presentation\Base\BasePresenter;
use Nette;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

final class MediaPresenter extends BasePresenter
{
    public function __construct(
      private EraFacade $eraFacade,
        private MediaRepository $mediaRepository,
    ) {}

    public function renderAdd():void
    {

    }

    protected function createComponentAddForm(): Form
    {
        $form = new Form();

        $form->addText('title', "Název díla: ")
            ->setRequired('Vyplň název díla!')
            ->setHtmlAttribute('class', 'form-control');
        $form->addTextArea('description', "Popis (nepovinné, max 255 znaků): ")
            ->setHtmlAttribute('maxlength', 255)
            ->addRule($form::MaxLength, 'Maximálně 255 znaků.', 255);
        $form->addSelect("canon_status", "Zvol canon/legends", array_combine(
            array_map(fn($s) => $s->value, CanonStatus::forAdd()),
            array_map(fn($s) => $s->label(), CanonStatus::forAdd())
            ))
            ->setRequired("Vyber canon status")
            ->setHtmlAttribute('class', 'form-control');
        $form->addSelect("media_type", "Zvol typ díla", array_combine(
            array_map(fn($s) => $s->value, MediaType::forAdd()),
            array_map(fn($s) => $s->label(), MediaType::forAdd())
            ))
            ->setRequired("Vyber typ díla")
            ->setHtmlAttribute('class', 'form-control');
        $form->addInteger('start_year', 'Zadej v jakém SW roce dílo začíná (BBY => záporné číslo, ABY => kladné číslo')
            ->setRequired('Zadej počáteční rok díla')
            ->setHtmlAttribute('class', 'form-control');
        $form->addInteger('end_year', 'Zadej v jakém SW roce dílo končí (BBY => záporné číslo, ABY => kladné číslo')
            ->setRequired('Zadej konečný rok díla')
            ->setHtmlAttribute('class', 'form-control');
        $form->addSelect('era_id', 'Vyber éru, do které dílo spadá: ', $this->eraFacade->getAllEras())
            ->setRequired('Vyber éru díla')
            ->setHtmlAttribute('class', 'form-control');
        $form->addText('part_label', 'Zadej část díla (nepovinné): ')
            ->setHtmlAttribute('class', 'form-control');
        $form->addDate('release_date', 'Datum vydání: ')
            ->setHtmlAttribute('class', 'form-control')
            ->setHtmlAttribute('min', date('Y-m-d'));
        $form->addUpload('image_url', 'Vyber obrázek: ')
            ->setHtmlAttribute('class', 'form-control')
            ->addRule(function ($item) {
                $mimeType = mime_content_type($item->getValue()->getTemporaryFile());
                return in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif']);
            }, 'Soubor musí být platný obrázek (JPG/PNG/GIF).');

        $form->onSuccess[] = [$this, 'addFormSucceeded'];
        return $form;
    }

    public function getImageFromForm(): ?string
    {
        if(isset($_FILES["image_url"]) && $_FILES["image_url"]["error"] == UPLOAD_ERR_OK){
            $tempPath = $_FILES["image_url"]["tmp_name"];

            $uploadDir = './images';
            $targetFile = $uploadDir . '/' .basename($_FILES["image_url"]["name"]);

            if (!file_exists($targetFile)) {
                move_uploaded_file($tempPath, $targetFile);
                bdump($tempPath);
            }
            return "http://www.localhost:8000/images/" . basename($_FILES['image']['name']);
        } else {
            return null;
        }
    }

    public function addFormSucceeded(Form $form): void
    {
        try {
            $formData = $form->getValues();
            bdump($formData);

            //uživatl bude mít na výběr vybrat dílo po kterym se to new odehrává a dílo před kterym se odehrává, musí vybrat aspoň jedno, pokud by výběr nesouhlasil s rokem díla v sw timeline tak to usera upozorní

            $data = ArrayHash::from([
                'title' => $formData['title'],
                'description' => $formData['description'],
                'canon_status' => $formData['canon_status'],
                'media_type' => $formData['media_type'],
                'start_year' => $formData['start_year'],
                'end_year' => $formData['end_year'],
                //'era_id' => $formData['era_id'],    //TODO
                'part_label' => $formData['part_label'],
                //'timeline_order' => $formData['timeline_order'], //TODO
                'release_date' => $formData['release_date'],
                ///'image_url' => $formData['image_url'],  //TODO
                'status' => MediaStatus::PLANNED->value
            ]);

            $media = $this->mediaRepository->saveRow((array) $data, null);
            if ($media) {
                $this->flashMessage('Dílo bylo úspěšně přidáno', 'success');
                $this->redirect('Timeline:show');
            }
            $this->flashMessage('Dílo se nepovedlo přidat', 'danger');
            $this->redirect('Timeline:show');
        } catch (Nette\Database\DriverException $e) {
            $this->flashMessage('Použij normální znaky', 'danger');
        }
    }

}