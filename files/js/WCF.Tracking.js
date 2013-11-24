/**
 * Initialize tracking namespace
 */
WCF.Tracking = { };

/**
 * Basic implementation for classes with an AJAX-based proxy
 * @todo pull request to WCF?
 */
WCF.Tracking.ProxyClass = Class.extend({
	/**
	 * @var	WCF.Action.Proxy
	 */
	_proxy: undefined,
	
	/**
	 * Creates the ajax proxy
	 */
	_createProxy: function() {
		if (this._proxy === undefined) {
			this._proxy = new WCF.Action.Proxy({
				success: $.proxy(this._success, this),
				failure: $.proxy(this._failure, this)
			});
		}
	},

	/**
	 * Sends an AJAX request
	 * @param	object	data
	 */
	_sendRequest: function(data) {
		this._createProxy();
		
		this._proxy.setOption('data', data);
		this._proxy.sendRequest();
	},

	/**
	 * Handles successful AJAX requests
	 *
	 * @param	object		data
	 * @param	string		textStatus
	 * @param	object		jqXHR
	 */
	_success: function(data, jqXHR, textStatus) { },
	
	/**
	 * Handles AJAX errors
	 * 
	 * @param	object	data
	 * @param	object	jqXHR
	 * @param	string	textStatus
	 * @param	string	errorThrown
	 */
	_failure: function(data, jqXHR, textStatus, errorThrown) { }
});

/**
 * Implementation for AJAXProxy-based toggle actions.
 * Handles the clipboard actions 'enable' and 'disable'.
 * @todo pull request to WCF?
 */
WCF.Tracking.ClipboardToggle = WCF.Action.Toggle.extend({
	/**
	 * object type used in the clipboard
	 * @var	string
	 */
	_objectType: undefined,
	
	/**
	 * @see		WCF.Action.Toggle.init()
	 * @param	string		buttonSelector
	 */
	init: function(className, containerSelector, buttonSelector, objectType) {
		this._super(className, containerSelector, buttonSelector);
		this._objectType = objectType;
		
		// bind listener
		$('.jsClipboardEditor').each($.proxy(function(index, container) {
			var $container = $(container);
			var $types = eval($container.data('types'));
			if (WCF.inArray(this._objectType, $types)) {
				$container.on('clipboardAction', $.proxy(this._execute, this));
				return false;
			}
		}, this));
	},
	
	/**
	 * Handles clipboard actions.
	 *
	 * @param	object		event
	 * @param	string		type
	 * @param	string		actionName
	 * @param	object		parameters
	 */
	_execute: function(event, type, actionName, parameters) {
		if (actionName == this._objectType + '.enable' || actionName == this._objectType + '.disable') {
			this.proxy.setOption('data', {
				actionName: 'toggle',
				className: this._className,
				interfaceName: 'wcf\\data\\IToggleAction',
				objectIDs: parameters.objectIDs
			});
			
			this.proxy.sendRequest();
		}
	},
	
	/**
	 * @see	WCF.Action.Toggle._success()
	 */
	_success: function(data, textStatus, jqXHR) {
		this._super(data, textStatus, jqXHR);
		WCF.Clipboard.reload();
	}
});

/**
 * Handler for TrackingGoalListPage
 * Allows selection of a tracking provider for goal tracking
 */
WCF.Tracking.GoalList = WCF.Tracking.ProxyClass.extend({
	/**
	 * Initializes the goal tracking provider selection form.
	 */
	init: function() {
		$('#goalTrackingProvider').submit($.proxy(this._submit, this));
	},

	/**
	 * Submits the form
	 */
	_submit: function(event) {
		event.preventDefault();
		this._sendRequest({
			className: 'wcf\\data\\tracking\\goal\\TrackingGoalAction',
			actionName: 'setTrackingProvider',
			objectIDs: [ $('#trackingProvider').val() ]
		});
	},

	/**
	 * @see	WCF.Tracking.ProxyClass._success()
	 */
	_success: function() {
		$('#goalTrackingProvider small').removeClass('innerError');
		
		new WCF.System.Notification(WCF.Language.get('wcf.global.success.edit')).show();
	},
	
	/**
	 * @see	WCF.Tracking.ProxyClass._success()
	 */
	_failure: function() {
		$('#goalTrackingProvider small').addClass('innerError');
	}
});

/**
 * Handler for the TrackingProviderStartPage
 */
WCF.Tracking.ProviderStart = WCF.Tracking.ProxyClass.extend({
	/**
	 * Initializes the TrackingProviderStartPage
	 */
	init: function() {
		$('#classNameForm').submit($.proxy(this._submit, this));
	},

	/**
	 * Submits the form
	 */
	_submit: function(event) {
		event.preventDefault();
		this._sendRequest({
			className: 'wcf\\data\\tracking\\provider\\TrackingProviderAction',
			actionName: 'checkClassName',
			parameters: {
				className: $('#className').val()
			}
		});
	},

	/**
	 * @see	WCF.Tracking.ProxyClass._success()
	 */
	_success: function(data) {
		if (data.returnValues == 'valid') {
			$('#classNameForm').off().submit();
		} else {
			$('#classNameForm dl').addClass('formError');
			$('#classNameForm small').removeClass('invisible').text(WCF.Language.get('wcf.acp.tracking.provider.className.error.'+data.returnValues));
		}
	}
});
