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

	// CURL request with error :)
	public function actionCurl()
	{
		$req = new \Kdyby\Extension\Curl\Request("http://localhost/xyz");
		$res = $this->context->kdyby->curl->send($req);
		dump($res);
	}

	protected function createComponentRecords()
	{
		return new RecordsGrid($this->context->database->table('records'));
	}

}
