<?php
namespace wcf\data\tracking\goal;
use wcf\data\DatabaseObject;
use wcf\system\request\IRouteController;

/**
 * Represents a tracking goal.
 *
 * @author	Magnus Kühn
 * @copyright	2013 Magnus Kühn
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-2.1.txt>
 * @package	com.mrk.wcf.tracking
 */
class TrackingGoal extends DatabaseObject implements IRouteController {
	/**
	 * @see	\wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'tracking_goal';
	
	/**
	 * @see	\wcf\data\DatabaseObject::$databaseTableIndexName
	 */
	protected static $databaseTableIndexName = 'trackingGoalID';
	
	/**
	 * @var	integer
	 */
	protected $revenue = null;
	
	/**
	 * @see	\wcf\data\ITitledObject::getTitle()
	 */
	public function getTitle() {
		return $this->goalName;
	}
	
	/**
	 * Returns the revenue
	 *
	 * @return	integer
	 */
	public function getRevenue() {
		return $this->revenue;
	}
	
	/**
	 * Sets the revenue
	 * 
	 * @param	integer	$revenue
	 */
	public function setRevenue($revenue) {
		$this->revenue = $revenue;
	}
}
