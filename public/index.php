<?php

require '../vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

if (isset($_GET['page']) && $_GET['page'] === '1') {
       $uri =  explode('?', $_SERVER['REQUEST_URI'])[0];
       $get = $_GET;
       unset($get['page']);
       $query = http_build_query($get);
       if (!empty($query)) {
              $uri = $uri . '?' . $query;
       }
       http_response_code(301);
       header('Location: ' . $uri);
       exit();
}

$router = new App\Router(dirname(__DIR__) . '/views');
$router
       ->get('/bjobs', 'index.php', 'index')
       ->match('/bjobs/advertissements', 'ads/index.php', 'ads')
       ->get('/bjobs/[*:slug]-[i:id]', 'ads/show.php', 'post')
       ->match('/bjobs/login', 'authentification/login.php', 'login')
       ->match('/bjobs/logout', 'authentification/logout.php', 'logout')
       ->match('/bjobs/register', 'authentification/register.php', 'register')
       ->match('/bjobs/myprofil', 'profil.php', 'myprofil')
       ->get('/bjobs/companies', 'companies/companies.php', 'companies')
       ->match('/bjobs/companies', 'companies/new.php', 'companies_create')
       ->get('/admin/ads', 'admin/ads/index.php', 'admin_ads')
       ->match('/admin/ads/[i:id]', 'admin/ads/edit.php', 'admin_ads_edit')
       ->post('/admin/ads/[i:id]/delete', 'admin/ads/delete.php', 'admin_ads_delete')
       ->match('/admin/ads/new', 'admin/ads/new.php', 'admin_ads_new')
       ->get('/admin/user', 'admin/user/index.php', 'admin_user')
       ->match('/admin/user/[i:id]', 'admin/user/edit.php', 'admin_user_edit')
       ->post('/admin/user/[i:id]/delete', 'admin/user/delete.php', 'admin_user_delete')
       ->match('/admin/user/new', 'admin/user/new.php', 'admin_user_new')
       ->get('/admin/companies', 'admin/companies/index.php', 'admin_companies')
       ->match('/admin/companies/[i:id]', 'admin/companies/edit.php', 'admin_companies_edit')
       ->post('/admin/companies/[i:id]/delete', 'admin/companies/delete.php', 'admin_companies_delete')
       ->match('/admin/companies/new', 'admin/companies/new.php', 'admin_companies_new')
       ->run();
?>