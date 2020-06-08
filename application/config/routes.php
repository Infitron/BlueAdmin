<?php
defined('BASEPATH') OR exit('No direct script access allowed');



/*** Dashboard   ****/
$route['addArtisan'] = "admin/addArtisan";
$route['newArtisan'] = "admin/newArtisan";



/**** Admin controller section ****/
$route['export_users'] = "admin/export_users";
$route['updateUser'] = "admin/updateUser";
$route['allUsers'] = "admin/allUsers";
$route['editUser'] = "admin/editUser";
$route['editUser/(:num)'] = "admin/editUser/$1";

$route['articles'] = "admin/articles";
$route['editArticle'] = "admin/editArticle";
$route['editArticle/(:num)'] = "admin/editArticle/$1";
$route['updateArticle'] = "admin/updateArticle";

$route['bookings'] = "admin/bookings";
$route['project'] = "admin/project";

$route['dashboard'] = "admin/dashboard";






/**** Login controller section ****/
$route['postLogin'] = "login/postLogin";
$route['logout'] = "login/logout";



$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
