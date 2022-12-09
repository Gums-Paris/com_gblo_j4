<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_gblo
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;


class GbloViewProchsortie extends JViewLegacy
{
	/**
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise a Error object.
	 */

	public function display($tpl = null)
	{
/*		$app            = JFactory::getApplication();
		$document       = JFactory::getDocument();
		$document->link = JRoute::_('index.php?option=com_gblo&amp;view=raw');

		$app->input->set('limit', $app->getCfg('feed_limit'));

		// Get some data from the model
		$model			= $this->getModel();
		$modelBlogList	= $this->getModel( 'Blog' );
		$bloglists = $modelBlogList->fncGetBlogList();

		foreach ($bloglists as $bloglist)
		{			
			// Strip HTML from feed item title
			$title = $this->escape($bloglist->post_title);
			$title = html_entity_decode($title, ENT_COMPAT, 'UTF-8');

			// Strip HTML from feed item description text
			$description = $this->escape(substr( JText::_( $bloglist->post_desc),0,250));
			$description = strip_tags(html_entity_decode($description, ENT_COMPAT, 'UTF-8'));
			$author      = $bloglist->postedby;
			$date        = $bloglist->post_date;

			// Load individual item creator class
			$feeditem = new JFeedItem;
			$feeditem->title       = $title;
			$feeditem->link        = '/index.php?option=com_blog&amp;view=comments&amp;pid=' . (int) $bloglist->id;
			$feeditem->description = $description;
			$feeditem->date        = $date;
			$feeditem->author      = $author;

			// Load item info into RSS array
			$document->addItem($feeditem);
		} */

		echo ('Puiselet');

	}
}
