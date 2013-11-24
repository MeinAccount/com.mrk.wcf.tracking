{include file='header' pageTitle='wcf.acp.tracking.goal.'|concat:$action}

<header class="boxHeadline">
	<h1>{lang}wcf.acp.tracking.goal.{$action}{/lang}</h1>
</header>

{include file='formError'}
{if $success|isset}<p class="success">{lang}wcf.global.success.{$action}{/lang}</p>
{elseif $action == 'edit' && !$trackingGoal->trackingID}<p class="warning">{lang}wcf.acp.tracking.goal.trackingID.required{/lang}</p>{/if}

<div class="contentNavigation">
	<nav>
		<ul>
			<li><a href="{link controller='TrackingGoalList'}{/link}" class="button"><span class="icon icon16 icon-list"></span> <span>{lang}wcf.acp.tracking.goal.list{/lang}</span></a></li>
			
			{event name='contentNavigationButtons'}
		</ul>
	</nav>
</div>

<form method="post" action="{if $action == 'add'}{link controller='TrackingGoalAdd'}{/link}{else}{link controller='TrackingGoalEdit' object=$trackingGoal}{/link}{/if}">
	<div class="container containerPadding marginTop">
		<fieldset>
			<legend>{lang}wcf.global.form.data{/lang}</legend>
			
			<dl{if $errorField == 'goalName'} class="formError"{/if}>
				<dt><label for="goalName">{lang}wcf.acp.tracking.goal.goalName{/lang}</label></dt>
				<dd>
					<input type="text" id="goalName" name="goalName" value="{$goalName}" required="required" autofocus="autofocus" class="long" />
					{if $errorField == 'goalName'}<small class="innerError">{if $errorType == 'empty'}{lang}wcf.global.form.error.empty{/lang}{else}{lang}wcf.acp.tracking.goal.goalName.error.notUnique{/lang}{/if}</small>{/if}
				</dd>
			</dl>
			
			<dl{if $errorField == 'description'} class="formError"{/if}>
				<dt><label for="description">{lang}wcf.acp.tracking.goal.description{/lang}</label></dt>
				<dd>
					<input type="text" id="description" name="description" value="{$i18nPlainValues['description']}" class="long" />
					{if $errorField == 'description'}<small class="innerError">{lang}wcf.global.form.error.{@$errorType}{/lang}</small>{/if}
				</dd>
			</dl>
			{include file='multipleLanguageInputJavascript' elementIdentifier='description' forceSelection=false}

			<dl{if $errorField == 'trackingID'} class="formError"{/if}>
				<dt><label for="trackingID">{lang}wcf.acp.tracking.goal.trackingID{/lang}</label></dt>
				<dd>
					<input type="number" id="trackingID" name="trackingID" value="{$trackingID}" class="medium" />
					{if $errorField == 'trackingID'}<small class="innerError">{lang}wcf.global.form.error.empty{/lang}</small>{/if}
					<small>{lang}wcf.acp.tracking.goal.trackingID.description{/lang}</small>
				</dd>
			</dl>
			
			{event name='dataFields'}
		</fieldset>
		
		{event name='fieldsets'}
	</div>
	
	<div class="formSubmit">
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
		{@SECURITY_TOKEN_INPUT_TAG}
	</div>
</form>

{include file='footer'}
