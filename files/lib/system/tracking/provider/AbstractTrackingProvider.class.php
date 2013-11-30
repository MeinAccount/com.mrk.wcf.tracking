<?php
namespace wcf\system\tracking\provider;
use wcf\data\tracking\goal\TrackingGoal;
use wcf\data\tracking\provider\TrackingProvider;
use wcf\system\tracking\TrackingHandler;
use wcf\system\WCF;

/**
 * Abstract implementation of tracking providers
 *
 * @author           Magnus Kühn
 * @copyright        2013 Magnus Kühn
 * @package          com.mrk.wcf.tracking
 */
abstract class AbstractTrackingProvider implements ITrackingProvider {
	/**
	 * template name
	 * @var	string
	 */
	protected $templateName = null;

	/**
	 * @see	\wcf\system\tracking\provider\ITrackingProvider::getAdditionalTrackingCode()
	 */
	public function getAdditionalTrackingCode(TrackingProvider $trackingProvider, $trackingCode) {
		if ($this->supportsGoalTracking()) { // fetch goal tracking code
			$goalCode = '';
			if (TRACKING_GOAL_PROVIDER == $trackingProvider->trackingProviderID) {
				foreach (TrackingHandler::getInstance()->getFulfilledGoals() as $trackingGoal) {
					$goalCode .= $this->getGoalTrackingCode($trackingProvider, $trackingGoal);
				}
			}

			return str_replace('<!-- com.mrk.wcf.tracking.goal.codePlaceholder -->', $goalCode, $trackingCode);
		}
		
		return $trackingCode;
	}

	/**
	 * Returns the goal tracking code
	 *
	 * @param	\wcf\data\tracking\provider\TrackingProvider	$trackingProvider
	 * @param	\wcf\data\tracking\goal\TrackingGoal		$trackingGoal
	 * @return	string
	 */
	abstract protected function getGoalTrackingCode(TrackingProvider $trackingProvider, TrackingGoal $trackingGoal);
	
	/**
	 * @see	\wcf\system\tracking\provider\ITrackingProvider::getTrackingCode()
	 */
	public function getTrackingCode(TrackingProvider $trackingProvider) {
		return $this->fetchTemplate('trackingCode', $trackingProvider);
	}
	
	/**
	 * @see	\wcf\system\tracking\provider\ITrackingProvider::getTrackingCode()
	 */
	public function getOptOutCode(TrackingProvider $trackingProvider) {
		return $this->fetchTemplate('trackingOptOut', $trackingProvider);
	}
	
	/**
	 * Fetches a template
	 *
	 * @param	string						$template
	 * @param	\wcf\data\tracking\provider\TrackingProvider	$trackingProvider
	 * @return	string
	 */
	protected function fetchTemplate($template, TrackingProvider $trackingProvider) {
		return WCF::getTPL()->fetch($template . ucfirst($this->templateName), 'wcf', array('trackingID' => $trackingProvider->trackingID, 'trackingURL' => $trackingProvider->trackingURL, 'trackingProvider' => $trackingProvider));
	}
	
	/**
	 * @see	\wcf\system\tracking\provider\ITrackingProvider::requiresID()
	 */
	public function requiresID() {
		return true;
	}
	
	/**
	 * @see	\wcf\system\tracking\provider\ITrackingProvider::requiresURL()
	 */
	public function requiresURL() {
		return true;
	}
	
	/**
	 * @see	\wcf\system\tracking\provider\ITrackingProvider::supportsGoalTracking()
	 */
	public function supportsGoalTracking() {
		return true;
	}
}
