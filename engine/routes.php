<?php
use core\Router;

/* admin */
Router::add('admin', 'admin:index','main');
Router::add('admin/category', 'admin:category','category');
Router::add('admin/product', 'admin:product','product');
Router::add('admin/widgets', 'admin:widgets','widgets');
Router::add('admin/widgets/add', 'admin:widgetsAdd','widgetsAdd');
/* admin */

/* pages */

// test
Router::add('contact', 'main:contact','contact');
Router::add('prais', 'main:prais','prais');


// gallery
Router::add('gallery', 'gallery', 'gallery');

// about
Router::add('about', 'about','about');


// Material
Router::add('material', 'material', 'material');
Router::add('material/(product:all)', 'material:product','material_product');
//Router::add('material/(product:all)/(url:all)', 'material:view','material_view');

// metal
Router::add('metal', 'metal', 'metal');
Router::add('metal/prais', 'metal:prais','metal_prais');
Router::add('metal/(url:all)', 'metal:view','metal_view');





/* index */
Router::add('', 'main','main');
