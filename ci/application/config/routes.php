<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'index';
$route['contact-us'] = 'index/contact_us';
$route['socities'] = 'index/socities';
$route['signup'] = 'index/signup';
$route['logineventify'] = 'index/logineventify';
$route['congratulations'] = 'index/congratulations';
$route['error'] = 'index/error';
$route['errorregister'] = 'index/errorregister';
$route['errorregister2'] = 'index/errorregister2';
$route['logout'] = 'index/logout';



$route['contacted'] = 'index/contacted';
$route['register_individual']='index/register_individual';
$route['registered']='index/registered';
$route['register_choice']='index/register_choice';
$route['register_group/(:num)']='index/register_group/$1';


$route['ACM'] = 'index/ACM';
$route['DECS'] = 'index/DECS';
$route['TLC'] = 'index/TLC';
$route['WEBMASTERS'] = 'index/WEBMASTERS';
$route['CBS'] = 'index/CBS';
$route['FMS'] = 'index/FMS';
$route['TNC'] = 'index/TNC';
$route['addeventconfirm'] = 'index/addeventconfirm';

$route['SPORTICS'] = 'index/SPORTICS';
$route['dashboard'] = 'index/dashboard';
$route['dashboardprofile'] = 'index/dashboardprofile';
$route['dashboardaddevent']= 'index/dashboardaddevent';
$route['dashboardupdateevent/(:num)']= 'index/dashboardupdateevent/$1';

$route['registerevent/(:num)']= 'index/registerevent/$1';
$route['success'] = 'index/success';
$route['errorevent'] = 'index/errorevent';
$route['updatepassword'] = 'index/dashboardupdatepassword';
$route['dashboardevent'] = 'index/dashboardevent';
$route['dashboardregisteredevent'] = 'index/dashboardregisteredevent';
$route['dashboarddeleteevent/(:num)'] = 'index/dashboarddeleteevent/$1';
$route['detailedevent/(:num)'] = 'index/detailedevent/$1';
$route['email-verification/(:any)/(:any)'] = 'index/emailVerification/$1/$2';

//admin panel routes
$route['admin']= "admin/index_admin/index";
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
