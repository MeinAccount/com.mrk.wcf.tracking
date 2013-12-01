<?php
namespace wcf\system\cache\builder;
use wcf\data\tracking\goal\TrackingGoalList;

/**
 * Caches all enabled tracking goals
 *
 * @author           Magnus Kühn
 * @copyright        2013 Magnus Kühn
 * @package          com.mrk.wcf.tracking
 */
class TrackingGoalCacheBuilder extends AbstractCacheBuilder {
	/**
	 * @see	\wcf\system\cache\builder\AbstractCacheBuilder::rebuild()
	 */
	protected function rebuild(array $parameters) {
		$trackingGoalList = new TrackingGoalList();
		$trackingGoalList->getConditionBuilder()->add('isDisabled = ?', array(0));
		$trackingGoalList->readObjects();
		
		// use name as index
		$trackingGoals = array();
		foreach ($trackingGoalList->getObjects() as $trackingGoal) {
			$trackingGoals[$trackingGoal->goalName] = $trackingGoal;
		}
		
		return $trackingGoals;
	}
}
