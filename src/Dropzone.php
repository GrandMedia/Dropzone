<?php declare(strict_types = 1);

namespace GrandMedia\Dropzone;

use Nette\Application\UI\Form;
use Nette\Http\FileUpload;

/**
 * @method onUpload(FileUpload $fileUpload)
 * @method onRefresh()
 */
final class Dropzone extends \Nette\Application\UI\Control
{

	/**
	 * @var callable[]
	 */
	public $onUpload;

	/**
	 * @var callable[]
	 */
	public $onRefresh;

	public function handleRefresh(): void
	{
		$this->onRefresh();
	}

	public function render(): void
	{
		/** @var \Nette\Bridges\ApplicationLatte\Template $template */
		$template = $this->getTemplate();
		$template->setFile(__DIR__ . '/templates/dropzone.latte');

		$template->setParameters(
			[
				'refreshLink' => $this->link('refresh'),
			]
		);

		$template->render();
	}

	protected function createComponentForm(): Form
	{
		$form = new Form();

		$form->addUpload('file', null);

		$form->onSuccess[] = function (Form $form): void {
			$values = $form->getValues();

			$this->onUpload($values->file);
		};

		return $form;
	}

}
