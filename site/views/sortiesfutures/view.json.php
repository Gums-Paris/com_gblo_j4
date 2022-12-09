<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_gblo
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;


class GbloViewSortiesfutures extends JViewLegacy
{
	/**
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise a Error object.
	 * Si on ne reçoit aucune info provenant du model le json expédié ne contient que "flag":"false". Sinon flag est à "true" 
	 * mais il peut y avoir des erreurs produites dans l'extraction des infos dans l'article. Le résultat reste exploitable (en principe...).
	 */

	public function display($tpl = null)	{


		// Get some data from the model
		$model			= $this->getModel();
		$data			= $model->getData();

//echo "<pre>"; print_r($data); echo" </pre>";
//exit (0);
				
		echo json_encode($data);
	}
}
