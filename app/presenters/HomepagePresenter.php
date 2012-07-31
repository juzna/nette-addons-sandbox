<?php

/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';

		$vp = new VisualPaginator($this, 'vp');
		$pag = $vp->getPaginator();
		$pag->itemsPerPage = 10;
		$pag->itemCount = 51;
	}

	protected function createComponentRecords()
	{
		return new RecordsGrid($this->context->database->table('records'));
	}

}
