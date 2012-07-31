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

		$dp = new \steky\nette\DatePaginator\VisualDatePaginator($this, 'dp');
		$dp->getPaginator()->setOldestDate(new DateTime("2012-01-01"));
		$dp->getPaginator()->setNewestDate(new DateTime("now"));
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
