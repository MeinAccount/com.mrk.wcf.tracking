<?php
namespace wcf\data\tracking\provider;
use wcf\data\DatabaseObject;
use wcf\system\request\IRouteController;
use wcf\system\request\RouteHandler;

/**
 * Represents a tracking provider.
 *
 * @author	Magnus Kühn
 * @copyright	2013 Magnus Kühn
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-2.1.txt>
 * @package	com.mrk.wcf.tracking
 */
class TrackingProvider extends DatabaseObject implements IRouteController {
	/**
	 * @see	\wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'tracking_provider';
	
	/**
	 * @see	\wcf\data\DatabaseObject::$databaseTableIndexName
	 */
	protected static $databaseTableIndexName = 'trackingProviderID';
	
	/**
	 * Returns the title of the object.
	 *
	 * @return        string
	 */
	public function getTitle() {
		return $this->providerName;
	}

	/**
	 * Returns the tracking url
	 * 
	 * @return string
	 */
	public function getTrackingURL() {
		return rawurlencode(RouteHandler::getInstance()->getProtocol().$this->trackingURL);
	}
}
