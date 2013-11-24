<?php
namespace wcf\system\tracking\provider;
use wcf\data\tracking\provider\TrackingProvider;

/**
 * Interface for tracking providers
 * 
 * @author	Magnus Kühn
 * @copyright	2013 Magnus Kühn
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-2.1.txt>
 * @package	com.mrk.wcf.tracking
 */
interface ITrackingProvider {
	/**
	 * Returns the tracking code
	 * 
	 * @param	\wcf\data\tracking\provider\TrackingProvider	$trackingProvider
	 * @return	string
	 */
	public function getTrackingCode(TrackingProvider $trackingProvider);
	
	/**
	 * Returns the opt out code
	 *
	 * @param	\wcf\data\tracking\provider\TrackingProvider	$trackingProvider
	 * @return	string
	 */
	public function getOptOutCode(TrackingProvider $trackingProvider);
	
	/**
	 * Checks whether the tracking provider requires an URL 
	 * 
	 * @return	boolean
	 */
	public function requiresURL();
	
	/**
	 * Checks whether the tracking provider requires an tracking id
	 *
	 * @return	boolean
	 */
	public function requiresID();
	
	/**
	 * Checks whether the tracking provider supports goal tracking
	 * 
	 * @return	boolean
	 */
	public function supportsGoalTracking();
}
