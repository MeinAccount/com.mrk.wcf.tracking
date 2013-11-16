{include file=documentHeader}
<head>
	<title>{lang}wcf.tracking.opt_out{/lang}- {PAGE_TITLE|language}</title>
	{include file=headInclude}

	<link rel="canonical" href="{link controller='Tracking'}{/link}" />
</head>

<body id="tpl{$templateName|ucfirst}">
{include file='header'}

<header class="boxHeadline">
	<h1>{lang}wcf.tracking.opt_out{/lang}</h1>
</header>

{@$__wcf->getTrackingHandler()->getOptOutCode()}

{include file='footer'}
</body>
</html>
