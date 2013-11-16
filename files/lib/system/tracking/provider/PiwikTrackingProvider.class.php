<?php
namespace wcf\system\tracking\provider;

/**
 * Tracking provider for piwik
 * 
 * @author           Magnus Kühn
 * @copyright        2013 Magnus Kühn
 * @package          com.mrk.wcf.tracking
 */
class PiwikTrackingProvider extends AbstractTrackingProvider {
	/**
	 * @see	\wcf\system\tracking\provider\AbstractTrackingProvider::$templateName
	 */
	protected $templateName = 'piwik';
}
