<?php
namespace wcf\system\event\listener;
use wcf\system\event\IEventListener;
use wcf\system\tracking\TrackingHandler;

/**
 * Tracks the 'com.woltlab.wcf.register'-goal.
 *
 * @author	Magnus Kühn
 * @copyright	2013 Magnus Kühn
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-2.1.txt>
 * @package	com.mrk.wcf.tracking
 */
class RegisterTrackingGoalEventListener implements IEventListener {
	/**
	 * @see	\wcf\system\event\IEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		TrackingHandler::getInstance()->trackGoal('com.woltlab.wcf.register');
	}
}
