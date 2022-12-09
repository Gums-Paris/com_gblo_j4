<?php
/**
 * @package Joomla
 * @subpackage Gblo
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class GbloViewListesorties extends JViewLegacy
{
	protected $state;
	protected $items;
	protected $pagination;

	function display($tpl = null)
	{
		$app		= JFactory::getApplication();
		$params		= $app->getParams();

		// Get some data from the models
		$state		= $this->get('State');
		$items		= $this->get('Items');
		$pagination	= $this->get('Pagination');

		// Check for errors.
/*		if (count($errors = $this->get('Errors'))) {
			throw new Exception(implode("\n", $errors), 500);
		} */

		$document       = JFactory::getDocument();
 /*               $document->setTitle( $params->get( 'page_title' ));
                $document->addStyleSheet('components/com_abook/assets/css/style.css');

		// Prepare the data.
		// Compute the item slug.
		for ($i = 0, $n = count($items); $i < $n; $i++)
		{
			$item		= &$items[$i];
			$item->slug	= $item->alias ? ($item->id.':'.$item->alias) : $item->id;
		} */

/*		$this->assignRef('state',		$state);
		$this->assignRef('items',		$items);
		$this->assignRef('params',		$params);
		$this->assignRef('pagination',	$pagination);*/

		$this->_prepareDocument();

		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{
		$app		= JFactory::getApplication();
		$menus		= $app->getMenu();
		$pathway	= $app->getPathway();
		$title 		= null;


		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();
	}
}
