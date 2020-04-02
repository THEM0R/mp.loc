<?php
use core\Router;

/*
 * admin
 */

/*
 * index
 */


Router::add('admin', 'admin:index','main');
Router::add('admin/auth', 'admin:auth','auth');
Router::add('admin/logout', 'admin:logout');
/*
 * category
 */
Router::add('admin/category', 'admin:category','category');
Router::add('admin/category/add', 'admin:categoryAdd','categoryAdd');
Router::add('admin/category/(id:int)/edit', 'admin:categoryEdit','categoryEdit');
Router::add('admin/category/(id:int)/delete', 'admin:categoryDelete','categoryDelete');
/*
 * upload
 */
Router::add('upload/url', 'upload:url');
Router::add('upload/delete', 'upload:delete');
/*
 * articles
 */

Router::add('admin/articles/(cat:int)', 'admin:articles','articles');

//Router::add('admin/articles', 'admin:articles','articles');
Router::add('admin/articles/add', 'admin:articlesAdd','articlesAdd');
//Router::add('admin/articles/(id:int)', 'admin:articlesView','articlesView');
Router::add('admin/articles/(id:int)/edit', 'admin:articlesEdit','articlesEdit');
Router::add('admin/articles/(id:int)/delete', 'admin:articlesDelete','articlesDelete');
/*
 * page
 */
Router::add('admin/page', 'admin:page','page');
Router::add('admin/page/add', 'admin:pageAdd','pageAdd');
Router::add('admin/page/(id:int)', 'admin:pageView','pageView');
Router::add('admin/page/(id:int)/edit', 'admin:pageEdit','pageEdit');
Router::add('admin/page/(id:int)/delete', 'admin:pageDelete','pageDelete');
/*
 * widgets
 */
Router::add('admin/widgets', 'admin:widgets','widgets');
Router::add('admin/widgets/add', 'admin:widgetsAdd','widgetsAdd');
/*
 * prais
 */
Router::add('admin/price/add', 'admin:priceAdd','priceAdd');
Router::add('admin/price/(category:int)', 'admin:price','price');
Router::add('admin/price/(id:int)/save', 'admin:priceSave');

/*
 * settings
 */
Router::add('admin/settings', 'admin:settings','settings');

/*
 * gallery
 */

Router::add('admin/gallery','admin:gallery','gallery');

/*
 * site
 */

//// test
//Router::add('contact', 'main:contact','contact');
//Router::add('prais', 'main:prais','prais');
//
//
//// gallery
//Router::add('gallery', 'gallery', 'gallery');
//
//// about
//Router::add('about', 'about','about');

// page
Router::add('gallery', 'gallery', 'gallery');

Router::add('page/(page:all)', 'page', 'page');

// category
Router::add('(category:all)', 'category', 'category');
// view
Router::add('(category:all)/price', 'category:price','price');
Router::add('(category:all)/(url:all)', 'article','article');



/* index */
Router::add('', 'main','main');
