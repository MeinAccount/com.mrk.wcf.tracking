{include file='header' pageTitle='wcf.acp.tracking.provider.add'}

<script data-relocate="true" src="{@$__wcf->getPath('wcf')}js/WCF.Tracking{if !ENABLE_DEBUG_MODE}.min{/if}.js?v={@$__wcfVersion}" xmlns="http://www.w3.org/1999/html"></script>
<script data-relocate="true">
	//<![CDATA[
	$(function() {
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

<form method="get" action="{link controller='TrackingProviderAdd'}{/link}" id="classNameForm" class="marginTop">
	<div class="container containerPadding marginTop">
		<fieldset>
			<legend>{lang}wcf.acp.tracking.provider{/lang}</legend>
			
			{foreach from=$objectTypes item=objectType}
				<dl>
					<dt><label for="objectType{$objectType->objectTypeID}">{lang}wcf.acp.tracking.provider.{$objectType->objectType}{/lang}</label></dt>
					<dd><a href="{link controller='TrackingProviderAdd' className=$objectType->className}{/link}" id="objectType{$objectType->objectTypeID}">{$objectType->className}</a></dd>
				</dl>
			{/foreach}
		</fieldset>
		
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
	</div>
</form>

{include file='footer'}
