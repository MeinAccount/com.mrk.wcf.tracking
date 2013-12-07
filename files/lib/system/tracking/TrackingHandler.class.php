<?php
namespace wcf\system\tracking;
use wcf\system\cache\builder\TrackingCodeCacheBuilder;
use wcf\system\cache\builder\TrackingGoalCacheBuilder;
use wcf\system\cache\builder\TrackingProviderCacheBuilder;
use wcf\system\SingletonFactory;
use wcf\system\WCF;
use wcf\util\ClassUtil;

/**
 * Handles tracking
 * 
 * @author	Magnus Kühn
 * @copyright	2013 Magnus Kühn
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-2.1.txt>
 * @package	com.mrk.wcf.tracking
 */
class TrackingHandler extends SingletonFactory {
	/**
	 * fulfilled goals
	 * @var	array<\wcf\data\tracking\goal\TrackingGoal>
	 */
	protected $fulfilledGoals = array();

	/**
	 * Returns all fulfilled goals
	 *
	 * array<\wcf\data\tracking\goal\TrackingGoal>
	 */
	public function getFulfilledGoals() {
		return $this->fulfilledGoals;
	}
	
	/**
	 * Gets the tracking code
	 * 
	 * @return	string
	 */
	public function getTrackingCode() {
		if ($this->shouldTrackUser()) {
			$code = '';
			foreach (TrackingCodeCacheBuilder::getInstance()->getData(array(), 'tracking') as $trackingProviderID => $trackingCode) {
				$trackingProvider = TrackingProviderCacheBuilder::getInstance()->getData(array(), $trackingProviderID);
				$code .= $trackingProvider->getProvider()->getAdditionalTrackingCode($trackingProvider, $trackingCode);
			}
			
			return $code;
		}
	}
	
	/**
	 * Gets the opt out code
	 *
	 * @return	string
	 */
	public function getOptOutCode() {
		if ($this->shouldTrackUser() && MODULE_TRACKING_OPT_OUT) {
			return TrackingCodeCacheBuilder::getInstance()->getData(array(), 'optOut');
		}
	}
	
	/**
	 * Checks if the given class name is a valid tracking provider
	 * 
	 * @param	string	$className
	 * @return	boolean
	 */
	public function isValidProvider($className) {
		if (!class_exists($className)) {
			return false;
		}
		
		return ClassUtil::isInstanceOf($className, 'wcf\system\tracking\provider\ITrackingProvider');
	}
	
	/**
	 * Checks if the user should be tracked.
	 *
	 * @return	boolean
	 */
	public function shouldTrackUser() {
		return (MODULE_TRACKING && !WCF::getSession()->getPermission('admin.user.isNotTracked'));
	}
	
	/**
	 * Tracks a goal
	 *
	 * @param	string	$goalName
	 * @param	integer	$revenue
	 */
	public function trackGoal($goalName, $revenue = null) {
		$trackingGoal = TrackingGoalCacheBuilder::getInstance()->getData(array(), $goalName);
		if ($trackingGoal !== null && !$trackingGoal->isDisabled) {
			$trackingGoal->setRevenue($revenue);
			$this->fulfilledGoals[] = $trackingGoal;
		}
	}
}
