{include file=documentHeader}
<head>
	<title>{lang}wcf.tracking.opt_out{/lang} - {PAGE_TITLE|language}</title>
	{include file=headInclude}

	<link rel="canonical" href="{link controller='Tracking'}{/link}" />
</head>

<body id="tpl{$templateName|ucfirst}">
{include file='header'}

<header class="boxHeadline">
	<h1>{lang}wcf.tracking.opt_out{/lang}</h1>
</header>

{assign var=trackingOptOut value=$__wcf->getTrackingHandler()->getOptOutCode()}
{if $trackingOptOut}{@$trackingOptOut}{else}<p class="success">{lang}wcf.tracking.opt_out.notTracked{/lang}</p>{/if}

{include file='footer'}
</body>
</html>
