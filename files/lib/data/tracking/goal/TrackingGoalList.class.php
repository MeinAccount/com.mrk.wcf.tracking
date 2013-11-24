<?php
namespace wcf\data\tracking\goal;
use wcf\data\DatabaseObjectList;

/**
 * Represents a list of tracking goals.
 *
 * @author	Magnus Kühn
 * @copyright	2013 Magnus Kühn
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-2.1.txt>
 * @package	com.mrk.wcf.tracking
 */
class TrackingGoalList extends DatabaseObjectList {
	/**
	 * @see	\wcf\data\DatabaseObjectList::$className
	 */
	public $className = 'wcf\data\tracking\goal\TrackingGoal';
}
