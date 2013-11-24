<?php
namespace wcf\data\tracking\goal;
use wcf\data\DatabaseObjectEditor;
use wcf\data\IEditableCachedObject;

/**
 * Provides functions to edit tracking goals.
 *
 * @author	Magnus Kühn
 * @copyright	2013 Magnus Kühn
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-2.1.txt>
 * @package	com.mrk.wcf.tracking
 */
class TrackingGoalEditor extends DatabaseObjectEditor implements IEditableCachedObject {
	/**
	 * @see	\wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'wcf\data\tracking\goal\TrackingGoal';
	
	/**
	 * @see	\wcf\data\IEditableCachedObject::resetCache()
	 */
	public static function resetCache() {
		// @todo implement
	}
}
