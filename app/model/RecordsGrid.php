<?php

use Nette\Database\Table\Selection;
use Nette\Application\UI\Presenter;

/**
 * {RecordsGrid}
 *
 * @author Jan Dolecek <juzna.cz@gmail.com>
 */
class RecordsGrid extends \NiftyGrid\Grid
{
	/** @var Selection */
	protected $records;



	public function __construct(Selection $records)
	{
		parent::__construct();
		$this->records = $records;
	}



	protected function configure(Presenter $presenter)
	{
		$this->setDataSource(new \NiftyGrid\DataSource\NDataSource($this->records));

		$this->addColumn('id');
		$this->addColumn('message');
	}

}
