<?php
namespace wcf\system\tracking\provider;
use wcf\data\tracking\provider\TrackingProvider;
use wcf\system\WCF;

/**
 * Abstract implementation of tracking providers
 * 
 * @author           Magnus Kühn
 * @copyright        2013 Magnus Kühn
 * @package          com.mrk.wcf.tracking
 */
class AbstractTrackingProvider implements ITrackingProvider {
	/**
	 * name of the template for the tracking code
	 * @var string
	 */
	protected $templateName = null;
	
	/**
	 * Returns the tracking code
	 *
	 * @param        TrackingProvider $trackingProvider
	 * @return        mixed
	 */
	public function getTrackingCode(TrackingProvider $trackingProvider) {
		return WCF::getTPL()->fetch($this->templateName, 'wcf', array(
			'trackingID' => $trackingProvider->trackingID,
			'trackingURL' => $trackingProvider->trackingURL,
			'trackingProvider' => $trackingProvider
		));
	}

	/**
	 * Checks whether the tracking provider requires an URL
	 *
	 * @return boolean
	 */
	public function requiresURL() {
		return true;
	}

	/**
	 * Checks whether the tracking provider requires an tracking id
	 *
	 * @return boolean
	 */
	public function requiresID() {
		return true;
	}
}
