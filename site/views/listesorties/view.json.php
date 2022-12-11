<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_gblo
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use \Joomla\CMS\Factory;

class GbloViewListesorties extends JViewLegacy
{
	/**
	 * @return  un json contenant un array avec pour chaque sortie un array de deux éléments, nom de la sortie et id de l'article décrivant les itinéraires
	 * plus flag de valeur 0 si OK et 1 si la lecture dans la base s'est plantée
	 */
	private $_data;

	public function display($tpl = null)	{

		$liste = array();
		$db = Factory::getDBO();
		if (empty( $_data )){
			$query = $db->getQuery(true);
//			$query = "SELECT title, id FROM `#__content` WHERE catid=59 AND state>0 ORDER BY title";
			$query
				->select($db->qn(array('title', 'id')))
				->from($db->qn('#__content'))
				->where($db->qn('catid') . '=' . $db->q('59'))
				->where($db->qn('state') . '>' . $db->q('0'))
				->order($db->qn('title')); 
				
			$db->setQuery($query);
			$liste = $db->loadRowList();
			if(empty($liste)){
				$_data = (object) ['flag' => '1'];
				echo json_encode($_data);
			}
		}
		 
		$_data = (object) ['liste' => $liste];

//echo "<pre>"; print_r($_data); echo" </pre>";
//exit (0);

		echo json_encode($_data);
	}
}
