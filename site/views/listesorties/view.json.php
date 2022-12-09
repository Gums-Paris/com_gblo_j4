<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_gblo
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;


class GbloViewListesorties extends JViewLegacy
{
	/**
	 * @return  un json contenant un array avec pour chaque sortie un array de deux éléments, nom de la sortie et id de l'article décrivant les itinéraires
	 * plus flag de valeur 0 si OK et 1 si la lecture dans la base s'est plantée
	 */
	private $_data;

	public function display($tpl = null)	{

		$liste = array();
		$db = JFactory::getDBO();
		if (empty( $_data )){
			$query = "SELECT title, id FROM `#__content` WHERE catid=59 AND state>0 ORDER BY title";
			$db->setQuery($query);
			$liste = $db->loadRowList();
			if(empty($liste)){
				$_data = (object) ['flag' => '1'];
				echo json_encode($_data);
			}
		} 
//		$_data = (object) ['flag' => '0'];
//		$_data->liste = $liste;
		$_data = (object) ['liste' => $liste];

//echo "<pre>"; print_r($_data); echo" </pre>";
//exit (0);

		echo json_encode($_data);
	}
}
