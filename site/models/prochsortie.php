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
class GbloModelProchsortie extends JModelLegacy{

	private $_data;
	private $article = '';
	private $flag_data = '0';
	
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
		$articleId = $app->input->getInt('idarticle');
		$db = Factory::getDBO();
		$sortieChoisie = false;

		if (!($articleId == null)) {
			
// cas où une sortie quelconque est demandée ; on met la date du jour
			$date = date('Y-m-d',time());
			if(empty($this->_data)){
				$this->_data = (object) ['dates' => $date ];
			}
			$sortieChoisie = true;
			
		}else{
// cas du fonctionement automatique sur la sortie de la semaine, on récupère les infos de l'évènement
			if (empty( $this->_data )){
				$query = $db->getQuery(true);
		/*		$query = "SELECT title, dates, introtext FROM `#__jem_events`
				WHERE (dates > curdate()-1) AND (published = 1) AND introtext like '<p>{article%' ORDER BY dates LIMIT 0 , 1"; */
				$query 
					->select($db->qn(array('title', 'dates', 'introtext')))
					->from($db->qn('#__jem_events'))
					->where($db->qn('dates') . '> curdate()' . '-' . $db->q('1'))
					->where($db->qn('published') . '=' . $db->q('1'))
					->where($db->qn('introtext') . 'LIKE' . $db->q('<p>{article%'))
					->order($db->qn('dates'))
					->setLimit($db->q('1'));  
 		
				$db->setQuery($query);
				$this->_data = $db->loadObject();
				if(empty($this->_data)){
					$this->_data = (object) ['flag' => '2'];
					return $this->_data;
				}
			}
			
	// et on extrait l'identifiant de l'article	du texte de l'évènement
			$introtext = $this->_data->introtext;
			if (preg_match('~[0-9]+~', $introtext, $ontrouve) != 1) {
				$this->_data->flag = '2';
			}else{
			unset($this->_data->introtext);
			$articleId = (int) $ontrouve[0];}
		}		

// récupère l'article et extrait les infos en traitant le texte
		$query = $db->getQuery(true);

		$query
			->select($db->qn(array('title', 'introtext')))
			->from($db->qn('#__content'))
			->where($db->qn('id') . '=' . (int) $articleId);
			
		$db->setQuery($query); 
		$result = $db->loadAssoc();
		if (empty($result)) { 
				$this->_data->flag = '2';
				return $this->_data;
		}
		if($sortieChoisie) { $this->_data->title = $result['title'];}
		$article = 	$result['introtext'];
		if ($this->traitArticle($article) != false) {
			list ($itiPark, $latPark, $lonPark, $itiRdV, $latRdV, $lonRdV, $flag_data) = $this->traitArticle($article);

// finalise le contenu de $_data
			$this->_data->itiPark = $itiPark;
			$this->_data->latPark = $latPark;
			$this->_data->lonPark = $lonPark;
			$this->_data->itiRdV = $itiRdV;
			$this->_data->latRdV = $latRdV;
			$this->_data->lonRdV = $lonRdV;
			$this->_data->flag = $flag_data;
		} else {
			$this->_data->flag = '2';
		}
		
//echo "<pre>"; print_r($this->_data); echo" </pre>";
//exit (0);
		return $this->_data;        
	}
	

	function traitArticle($texte) {

		$itiPark = '';
		$latPark = '';
		$lonPark = '';
		$itiRdV = '';
		$latRdV = '';
		$lonRdV = '';
		$flag_data = '0';
		$nbr_infos = 0;

// remplace soulignement par gras (android ne veut pas du text-decoration)
		$texte = str_replace('<span style="text-decoration: underline;">', '<b>',$texte);
		$texte = str_replace('</span', '</b',$texte);
		
// découpe en lignes et traite ligne par ligne
		$morceaux = explode('<li', $texte);
		$taille = count($morceaux);
		if ($taille <2) return false;
		$indexRdV = 0;
		$indexCar = 0;

		for ($i=0; $i<$taille; $i++) {
// si la ligne contient Accès on récupère lat et lon parking			
			if (strpos($morceaux[$i], 'Acc') != false) {
				$leBout = substr($morceaux[$i], -50);
				if ($leBout == false) { return false;}else{
					if (preg_match( '~48\.[0-9]+~', $leBout, $matches) == 1) {
						$latPark = $matches [0];
						$nbr_infos = $nbr_infos + 1;
					}
					if (preg_match( '~2\.[0-9]+~', $leBout, $matches) == 1) {
						$lonPark = $matches [0];
						$nbr_infos = $nbr_infos + 1;
					} 
				}
// si la ligne contient RdV on note son numéro								
			} elseif(strpos($morceaux[$i], 'RdV') != false) {
					$indexRdV = $i;
// si la ligne contient Cooordonnées on récupère lat et long de RdV					
			} elseif(strpos($morceaux[$i], 'Coo') != false) {
				$leBout = substr($morceaux[$i], -50);
				if ($leBout == false) { return false;}else{
					if (preg_match( '~48\.[0-9]+~', $leBout, $matches) == 1) {
						$latRdV = $matches [0];
						$nbr_infos = $nbr_infos + 1;
					}
					if (preg_match( '~2\.[0-9]+~', $leBout, $matches) == 1) {
						$lonRdV = $matches [0];
						$nbr_infos = $nbr_infos + 1;
					}
				}
// si la ligne contient Carte on note son numéro													
			} elseif(strpos($morceaux[$i], 'Cart') != false) {
				$indexCar = $i;
			}		
		}
		
// flag à 1 si problème pour récupérer les coordonnées
		if ($nbr_infos < 4) { $flag_data = '1';}

		
// on assemble toutes les lignes jusqu'à celle qui précède RdV pour l'itinéraire parking
		$itiPark = '';
		for($i=1; $i<$indexRdV; $i++) {
			$itiPark = $itiPark.'<li'.$morceaux[$i];
		}
		
// on assemble toutes les lignes à partir de RdV en ignorant la ligne Carte
		for($i=$indexRdV; $i<$taille; $i++) {
			if ($i != $indexCar) {
				$itiRdV = $itiRdV.'<li'.$morceaux[$i];
			}
		}
		
		return array ($itiPark, $latPark, $lonPark, $itiRdV, $latRdV, $lonRdV, $flag_data);
				
//echo ('latPark ='.$latPark.' lonPark='.$lonPark.' latRdv='.$latRdV.' lonRdv='.$lonRdV.' indexRdv='.$indexRdV.' indexCar='.$indexCar.' itiPark='.$itiPark.' itiRdV='.$itiRdV);
//echo "<pre>"; print_r($morceaux); echo" </pre>";
//exit (0);
		
	}
}
