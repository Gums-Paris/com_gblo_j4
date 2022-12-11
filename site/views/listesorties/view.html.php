<?php
/**
 * @package Joomla
 * @subpackage Gblo
 */
// No direct access
defined('_JEXEC') or die;

use \Joomla\CMS\Factory;

jimport('joomla.application.component.view');

class GbloViewListesorties extends JViewLegacy
{
	protected $state;
	protected $items;
	protected $pagination;

	function display($tpl = null)
	{
		$app		= Factory::getApplication();
		$params		= $app->getParams();

		// Get some data from the models
		$state		= $this->get('State');
		$items		= $this->get('Items');
		$pagination	= $this->get('Pagination');

		$document       = Factory::getDocument();
 
		$this->_prepareDocument();

		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{
		$app		= Factory::getApplication();
		$menus		= $app->getMenu();
		$pathway	= $app->getPathway();
		$title 		= null;


		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();
	}
}
