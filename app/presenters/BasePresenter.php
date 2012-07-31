<?php

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	protected function createComponentCss()
	{
		return $this->context->cssLoader;
	}
}
