<?php

namespace libs;
use samdark\sitemap\Sitemap;
use samdark\sitemap\Index;

class Map
{
    public static function create(){

        $from = '_movie';

        $category_name = 'film_4';
        $category_url = 'film';
        $category_id = 1;

        $sitemap = new Sitemap(DIR.'/xml/sitemap_'.$category_name.'.xml', true);
        // Set URL limit to fit in default limit of 50000 (default limit / number of languages)
        $sitemap->setMaxUrls(25000);

//        $sitemap->addItem([
//            'ru' => 'http://example.com/ru/mylink2',
//            'en' => 'http://example.com/en/mylink2',
//        ], time());

        $limit = '0,2500';

        $sql = " SELECT id,url,category FROM _movie WHERE category = ? ORDER BY id ASC LIMIT 7500,2500 ";

        $movies = \R::getAll($sql,[$category_id]);

        foreach ($movies as $move){

            $sitemap->addItem([
                'ru' => 'https://mor.cx/ru/'.$category_url.'/'.$move['url'],
                'ua' => 'https://mor.cx/ua/'.$category_url.'/'.$move['url'],
            ], time(), Sitemap::DAILY, 0.8);
        }

        $sitemap->write();

    }
}