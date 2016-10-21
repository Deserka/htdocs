<?php
/*
 *  DATE FORMAT
 * 01-01-2015 21:24         -> '%d-%m-%Y %H:%i'
 * 01-01-2015               -> '%d-%m-%Y'
 * 01-2015                  -> '%m-%Y'
 * 01/01/2015 21:24         -> '%d/%m/%Y %H:%i'
 * 01/01/2015               -> '%d/%m/%Y'
 * 01/2015                  -> '%m/%Y'
 * 01 January 2015 21:24    -> '%d %M %Y %H:%i'
 * 01 January 2015          -> '%d %M %Y'
 * January 2015             -> '%M %Y'
 * 1st February 2015 21:24  -> '%D %M %Y %H:%i'
 * 1st January 2015         -> '%D %M %Y'
 * January 1, 2015          -> '%M %e, %Y'
 * January 1st, 2015        -> '%M %D, %Y'
 * 
 */
$configuration =
[
    // What language versions are allowed
    'langs' => $langs = array('en', 'de'),
    'default_lang' => 'pl',
    // Date format for website
    'date_format' => '%d-%m-%Y',
    // What ALL model should take from database
    'newest_articles'   => 0,   // amount
    'newest_comments'   => 0,
    'newest_titbits'    => 0,
    'newest_news'       => 0,
    'most_red_articles' => 0,
    'all_categories'    => 1,   // 0 or 1
    'all_subcategories' => 0,
    'all_tags'          => 0,
/* Aktualności */
'aktualnosci_gallery_max_size' => 1000, // kb
'aktualnosci_gallery_max_width' => 1920,
'aktualnosci_gallery_max_height' => 1080,
'aktualnosci_gallery_required_width' => 1000,
'aktualnosci_gallery_required_height' => 800,
/* End Aktualności */
/* Kontakt */
'contact_gallery_max_size' => 1000, // kb
'contact_gallery_max_width' => 1920,
'contact_gallery_max_height' => 1080,
'contact_gallery_required_width' => 1000,
'contact_gallery_required_height' => 800,
/* End Kontakt */
/* Adder */
/****adding***/
];
?>
