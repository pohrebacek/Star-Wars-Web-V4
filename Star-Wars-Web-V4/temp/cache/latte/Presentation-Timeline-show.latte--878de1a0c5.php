<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: /home/rizzek/Documents/GitHub/Star-Wars-Web-V4/Star-Wars-Web-V4/app/Presentation/Timeline/show.latte */
final class Template_878de1a0c5 extends Latte\Runtime\Template
{
	public const Source = '/home/rizzek/Documents/GitHub/Star-Wars-Web-V4/Star-Wars-Web-V4/app/Presentation/Timeline/show.latte';

	public const Blocks = [
		['content' => 'blockContent'],
	];


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		if ($this->global->snippetDriver?->renderSnippets($this->blocks[self::LayerSnippet], $this->params)) {
			return;
		}

		$this->renderBlock('content', get_defined_vars()) /* line 1 */;
	}


	public function prepare(): array
	{
		extract($this->params);

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['mediaDTO' => '6'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		return get_defined_vars();
	}


	/** {block content} on line 1 */
	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<div>
    <a href="';
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Media:add')) /* line 3 */;
		echo '" class="btn btn-light">Add media</a>
</div>

';
		foreach ($mediaDTOs as $mediaDTO) /* line 6 */ {
			echo '<div class="container2">
    <div class="container">
        <div class="imageAYear">
            <img src="';
			echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($mediaDTO->imageUrl)) /* line 9 */;
			echo '" class="image">
            <div>
';
			if ($mediaDTO->endYear == $mediaDTO->startYear) /* line 11 */ {
				echo '                    <p class="Year">';
				echo LR\Filters::escapeHtmlText($mediaDTO->startYear) /* line 12 */;
				echo '</p>
';
			} else /* line 13 */ {
				echo '                    <p class="Year">';
				echo LR\Filters::escapeHtmlText($mediaDTO->startYear) /* line 14 */;
				echo ' - ';
				echo LR\Filters::escapeHtmlText($mediaDTO->endYear) /* line 14 */;
				echo '</p>
';
			}
			echo '                <p class="Status">';
			echo LR\Filters::escapeHtmlText($mediaDTO->canonStatus->value) /* line 16 */;
			echo '</p>
            </div>

        </div>

        <div class="nadpisAText">
            <h1>';
			echo LR\Filters::escapeHtmlText($mediaDTO->title) /* line 22 */;
			echo '</h1>
            <div class="line"></div>
            <p>';
			echo LR\Filters::escapeHtmlText($mediaDTO->description) /* line 24 */;
			echo '</p>
            <div class="line2"></div>
            <div class="stav">

            </div>

        </div>
    </div>
</div>';
		}
	}
}
