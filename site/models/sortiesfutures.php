<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

use \Joomla\CMS\Factory;

/**
 * Gblo Model production des données de la prochaine sortie
 *
 * @package    Joomla.Components
 * @subpackage 	Gblo
 */
class GbloModelSortiesfutures extends JModelLegacy{

	private $_data;
	private $flag_data = '0';
	private $liste = array();
	
	/**
	 * Gets the data
	 * @return mixed The data to be codées dans le json. 
	 * flag = 2 si le jem_event n'est pas récupéré, ou si on ne trouve pas l'id de l'article, ou si on ne récupère pas l'article 
	 * dans la base ou si on ne trouve aucune info dans l'article. 
	 * flag = 1 si on a des infos mais pas les quatre coordonnées nécessaires pour actionner GoogleNav et Iphigénie.
	 * flag = 0 si tout OK.
	 */
	function getData(){
  
        $app  = Factory::getApplication();
		$db = Factory::getDBO();
		
// on récupère un array d'objets (les 5 prochaines sorties)
		if (empty( $this->_data )){
			$query = $db->getQuery(true);
//			$query = "SELECT title, dates, introtext FROM `#__jem_events`
//			WHERE (dates > curdate()-1) AND (published = 1) AND introtext like '<p>{article%' ORDER BY dates LIMIT 0, 5";
			$query 
				->select($db->qn(array('title', 'dates', 'introtext')))
				->from($db->qn('#__jem_events'))
				->where($db->qn('dates') . '> curdate()' . '-' . $db->q('1'))
				->where($db->qn('published') . '=' . $db->q('1'))
				->where($db->qn('introtext') . 'LIKE' . $db->q('<p>{article%'))
				->order($db->qn('dates'))
				->setLimit('5');
				
			$db->setQuery($query);
			
			$this->liste = $db->loadObjectList();
			if(empty($this->liste)){
				$this->_data = (object) ['flag' => '1'];
				return $this->_data;
			}
		}

		foreach($this->liste as $s) {
// on extrait l'identifiant de l'article du texte de l'évènement et on le met à la place du texte
			$introtext = $s->introtext;
			if (preg_match('~[0-9]+~', $introtext, $ontrouve) != 1) {
				$this->_data->flag = '2';
			}else{
			unset($s->introtext);
			$s->articleId = (int) $ontrouve[0];}							
		}
			
		$this->_data = (object) ['liste' => $this->liste];
				
//echo "<pre>"; print_r($this->_data); echo" </pre>";
//exit (0);
		return $this->_data;        
	}
	
}
