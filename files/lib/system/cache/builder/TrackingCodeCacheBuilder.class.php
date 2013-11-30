<?php
namespace wcf\system\cache\builder;

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
		$code = array('tracking' => array(), 'optOut' => array());
		foreach (TrackingProviderCacheBuilder::getInstance()->getData() as $trackingProvider) {
			if (!$trackingProvider->isDisabled) {
				$provider = $trackingProvider->getProvider();
				$code['tracking'][$trackingProvider->trackingProviderID] = $this->minifyCode($provider->getTrackingCode($trackingProvider));
				$code['optOut'][$trackingProvider->trackingProviderID] = $this->minifyCode($provider->getOptOutCode($trackingProvider));
			}
		}
		
		return $code;
	}
	
	/**
	 * Minifies html code
	 * 
	 * @param	string	$code
	 * @return	string
	 */
	protected function minifyCode($code) {
		if (ENABLE_DEBUG_MODE) {
			return $code;
		}
		
		return preg_replace('/\s+/', ' ', str_replace(array('//<![CDATA[', '//]]>'), '', $code));
	}
}
