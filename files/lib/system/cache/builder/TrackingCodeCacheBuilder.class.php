<?php
namespace wcf\system\cache\builder;
use wcf\system\tracking\TrackingHandler;

/**
 * Caches the tracking code. 
 * 
 * @author           Magnus Kühn
 * @copyright        2013 Magnus Kühn
 * @package          com.mrk.wcf.tracking
 */
class TrackingCodeCacheBuilder extends AbstractCacheBuilder {
	/**
	 * @see	\wcf\system\cache\builder\AbstractCacheBuilder::rebuild()
	 */
	protected function rebuild(array $parameters) {
		$tracking = '';
		$optOut = '';
		foreach (TrackingHandler::getInstance()->getTrackingProviders() as $trackingProvider) {
			$provider = $trackingProvider->getProvider();
			$tracking .= $provider->getTrackingCode($trackingProvider);
			$optOut .= $provider->getOptOutCode($trackingProvider);
		}
		
		return array('tracking' => $this->minifyCode($tracking), 'optOut' => $this->minifyCode($optOut));
	}
	
	/**
	 * Minifies html code
	 * 
	 * @param string $code
	 * @return string
	 */
	protected function minifyCode($code) {
		return preg_replace('/\s+/', ' ', str_replace(array('//<![CDATA[', '//]]>'), '', $code));
	}
}
