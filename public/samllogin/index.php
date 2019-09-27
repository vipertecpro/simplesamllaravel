<?php
/*
	----------------------------------------------------------------------------------------------------
	Master configuration file 									| config / config.php
	To authentication source which handles admin authentication | config / authsource.php
	SAML 2.0 IdP configuration for SimpleSAMLphp 				| metadata / saml20-idp-hosted.php
	SAML 2.0 remote IdP metadata for SimpleSAMLphp 				| metadata / saml20-idp-remote.php
	----------------------------------------------------------------------------------------------------
*/
//	require_once ('lib/_autoload.php');
//	$as = new SimpleSAML_Auth_Simple('default-sp');
//	$as->requireAuth();
//	// Get saml attitubtes
//	$attributes = $as->getAttributes();
//	// Get saml logout url
//	$url = $as->getLogoutURL();
//	$data = [
//		'samlUserData'  => [
//            'tenantId'         => $attributes['http://schemas.microsoft.com/identity/claims/tenantid'][0],
//            'objectIdentifier' => $attributes['http://schemas.microsoft.com/identity/claims/objectidentifier'][0],
//            'surname'          => $attributes['http://schemas.xmlsoap.org/ws/2005/05/identity/claims/surname'][0],
//            'givenName'        => $attributes['http://schemas.xmlsoap.org/ws/2005/05/identity/claims/givenname'][0],
//            'displayName'      => $attributes['http://schemas.microsoft.com/identity/claims/displayname'][0],
//            'emailAddress'     => $attributes['http://schemas.xmlsoap.org/ws/2005/05/identity/claims/emailaddress'][0],
//            'identityProvider' => $attributes['http://schemas.microsoft.com/identity/claims/identityprovider'][0],
//        ],
//		'logoutURL' => $url
//	];
//	print_r($data);
//	die();

$GLOBALS['samlIni'] = parse_ini_file('saml.ini');
header('location:'.$GLOBALS['samlIni']['SAML_PATH']);

