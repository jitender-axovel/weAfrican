<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return array(

    /*
     |.....................................................................
     |  images paths
     |.....................................................................
     |
     */
    'api_image_path' => str_replace('\\','/',public_path()). '/uploads/apiImages/',
    'logo_image_path' => str_replace('\\','/',public_path()). '/uploads/images/logo/',
    'category_image_path' => str_replace('\\','/',public_path()). '/uploads/images/categories/',
    'banner_image_path' => str_replace('\\','/',public_path()). '/uploads/images/banners/',
    'product_image_path' => str_replace('\\','/',public_path()). '/uploads/images/products/',
    'document_path' => str_replace('\\','/',public_path()). '/uploads/documents/',
    /*
     |.....................................................................
     |  images urls
     |.....................................................................
     |
     */

    'logo_image_url' => '/uploads/images/logo/',
    'category_image_url' => '/uploads/images/categories/',
    'banner_image_url' => '/uploads/images/banners/',
    'product_image_url' => '/uploads/images/products/',
    'document_url' => '/uploads/documents/',

    /*
     |.....................................................................
     |  User Images
     |.....................................................................
     |
     */

    /*
     |.....................................................................
     |  Image thumbnail sizes
     |.....................................................................
     |
     */
     
    'small_thumbnail_height' => '100',
    'small_thumbnail_width' => '200',

    'medium_thumbnail_height' => '480',
    'medium_thumbnail_width' => '640',

    'large_thumbnail_height' => '600',
    'large_thumbnail_width' => '800'

);
