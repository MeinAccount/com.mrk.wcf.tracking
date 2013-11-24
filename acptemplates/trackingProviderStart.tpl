{include file='header' pageTitle='wcf.acp.tracking.provider.add'}

<script data-relocate="true" src="{@$__wcf->getPath('wcf')}js/WCF.Tracking{if !ENABLE_DEBUG_MODE}.min{/if}.js?v={@$__wcfVersion}"></script>
<script data-relocate="true">
	//<![CDATA[
	$(function() {
		WCF.TabMenu.init();
		new WCF.Tracking.ProviderStart();
		
		WCF.Language.addObject({
			'wcf.acp.tracking.provider.className.error.invalid': '{lang}wcf.acp.tracking.provider.className.error.invalid{/lang}',
			'wcf.acp.tracking.provider.className.error.notFound': '{lang}wcf.acp.tracking.provider.className.error.notFound{/lang}'
		});
	});
	//]]>
</script>

<header class="boxHeadline">
	<h1>{lang}wcf.acp.tracking.provider.add{/lang}</h1>
</header>

{include file='formError'}

<div class="contentNavigation">
	<nav>
		<ul>
			<li><a href="{link controller='TrackingProviderList'}{/link}" class="button"><span class="icon icon16 icon-list"></span> <span>{lang}wcf.acp.tracking.provider.list{/lang}</span></a></li>

			{event name='contentNavigationButtons'}
		</ul>
	</nav>
</div>

<div class="tabMenuContainer" data-active="objectTypes" data-store="activeTabMenuItem">
	<nav class="tabMenu">
		<ul>
			<li><a href="{@$__wcf->getAnchor('preset')}">{lang}wcf.acp.tracking.provider.start.preset{/lang}</a></li>
			<li><a href="{@$__wcf->getAnchor('custom')}">{lang}wcf.acp.tracking.provider.start.custom{/lang}</a></li>
		</ul>
	</nav>

	<div id="preset" class="container containerPadding tabMenuContent">
		<fieldset>
			<legend>{lang}wcf.acp.tracking.provider.start.preset{/lang}</legend>
			
			{foreach from=$objectTypes item=objectType}
				<dl>
					<dt><label for="objectType{$objectType->objectTypeID}">{lang}wcf.acp.tracking.provider.{$objectType->objectType}{/lang}</label></dt>
					<dd><a href="{link controller='TrackingProviderAdd' className=$objectType->className}{/link}" id="objectType{$objectType->objectTypeID}">{$objectType->className}</a></dd>
				</dl>
			{/foreach}
		</fieldset>
	</div>

	<div id="custom" class="container containerPadding tabMenuContent">
		<form method="get" action="{link controller='TrackingProviderAdd'}{/link}" id="classNameForm">
			<fieldset>
				<legend>{lang}wcf.acp.tracking.provider.start.custom{/lang}</legend>

				<dl>
					<dt><label for="className">{lang}wcf.acp.tracking.provider.className{/lang}</label></dt>
					<dd>
						<input type="text" id="className" name="className" value="wcf\system\tracking\provider\AbcTrackingProvider" required="required" pattern="^\\?([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*\\)*[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$" class="long" />
						<small class="innerError invisible"></small>
					</dd>
				</dl>

				{event name='sourceFields'}
			</fieldset>

			{event name='fieldsets'}

			<div class="formSubmit">
				<input type="submit" name="submitButton" value="{lang}wcf.global.button.next{/lang}" accesskey="s" />
				{@SID_INPUT_TAG}{@SECURITY_TOKEN_INPUT_TAG}
			</div>
		</form>
	</div>
</div>

{include file='footer'}
