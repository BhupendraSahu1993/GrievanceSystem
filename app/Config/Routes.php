<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

//Home
$routes->get('/', 'HomeController::index');
$routes->post('home/register_user', 'HomeController::Register');
$routes->post('home/login_user', 'HomeController::Login');
$routes->get('home/logout', 'HomeCOntroller::Logout');

//Admin
$routes->get('admin/showcomplaint', 'AdminController::ShowComplaint');
$routes->get('admin/userforapproval', 'AdminController::ShowUsersForApproval');
$routes->get('admin/user', 'AdminController::User');
$routes->get('admin/designation', 'AdminController::AddDesignation');
$routes->get('admin/rejectcomplaint', 'AdminController::RejectComplaint');
$routes->get('admin/solvedcomplaint', 'AdminController::ShowSolvedComplaint');
$routes->get('admin/solcompsendtousr', 'AdminController::SolveComplaintSendToUser');
$routes->get('admin/showimagevideo', 'AdminController::ShowImageVideo');
$routes->post('admin/insertdesignation', 'AdminController::InsertDesignation');
$routes->post('admin/registeruser', 'AdminController::RegisterUser');
$routes->post('admin/updatecompstatus', 'AdminController::UpdateComplaintStatus');
$routes->post('admin/decisiononuser', 'AdminController::DecisionOnUser');


//User
$routes->get('user/index', 'UserController::index');
$routes->get('user/complaint', 'UserController::complaint');
$routes->get('user/showcomplaintstatus', 'UserController::SubmitedComplaint');
$routes->get('user/subissuetype', 'UserController::SubIssueType');
$routes->post('user/submit_complaint', 'UserController::submit_complaint');
$routes->post('user/tempimageupload', 'UserController::TempImageUpload');

//Department
$routes->get('department/showcomplaint', 'DepartmentController::ShowComplaintToDept');
$routes->get('department/showcomplainttoteammember', 'DepartmentController::ShowComplaintToTeamMember');
$routes->get('department/getteamleader', 'DepartmentController::GetTeamLeader');
$routes->get('department/solvedcomplaint', 'DepartmentController::ShowSolvedComplaint');
$routes->get('department/showimagevideo', 'DepartmentController::ShowImageVideo');
$routes->post('department/complaintsolved', 'DepartmentController::ComplaintSolved');
$routes->post('department/refertomember', 'DepartmentController::ReferToTeamMember');
$routes->post('department/takedecionsolcomp', 'DepartmentController::TakeDecisionOnSolvedComplaint');

$routes->get('Pages/Dashboard', 'Pages::view');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
