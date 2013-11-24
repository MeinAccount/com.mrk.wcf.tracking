<?php
namespace wcf\data\tracking\goal;
use wcf\data\DatabaseObject;
use wcf\system\cache\builder\TrackingProviderCacheBuilder;
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
	 * @see	\wcf\data\ITitledObject::getTitle()
	 */
	public function getTitle() {
		return $this->goalName;
	}

	/**
	 * Returns the tracking provider
	 * 
	 * @return	\wcf\data\tracking\provider\TrackingProvider
	 */
	public function getTrackingProvider() {
		return TrackingProviderCacheBuilder::getInstance()->getData(array(), $this->trackingProviderID);
	}
}
