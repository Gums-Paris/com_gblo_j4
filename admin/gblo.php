<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Gblo
 * @author     Pastre <claude.pastre@free.fr>
 * @copyright  2019 Pastre
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

use \Joomla\CMS\MVC\Controller\BaseController;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;

// Access check.
if (!Factory::getUser()->authorise('core.manage', 'com_gblo'))
{
	throw new Exception(Text::_('JERROR_ALERTNOAUTHOR'));
}

JLoader::registerPrefix('Gblo', JPATH_COMPONENT_ADMINISTRATOR);
JLoader::register('GbloHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'gblo.php');

$controller = BaseController::getInstance('Gblo');
$controller->execute(Factory::getApplication()->input->get('task'));
$controller->redirect();
