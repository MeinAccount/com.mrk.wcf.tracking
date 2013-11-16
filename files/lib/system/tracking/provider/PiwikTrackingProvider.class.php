<?php
namespace wcf\system\tracking\provider;

/**
 * Tracking provider for piwik
 * 
 * @author	Magnus Kühn
 * @copyright	2013 Magnus Kühn
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-2.1.txt>
 * @package	com.mrk.wcf.tracking
 */
class PiwikTrackingProvider extends AbstractTrackingProvider {
	/**
	 * @see	\wcf\system\tracking\provider\AbstractTrackingProvider::$templateName
	 */
	protected $templateName = 'piwik';
}
