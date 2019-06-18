<?php
    /**
     * Plugin Name: TNA RSS feed plugin
     * Description: A plugin which creates iTunes compatible XML for podcasts from the podcasts RSS feed
     * Plugin URI: https://github.com/nationalarchives/tna-rss-feed-plugin
     * Version: 0.1.0
     * Author: James Chan
     * Author URI: https://github.com/nationalarchives
     */

function generate_rss_xml (){
    ob_start();
    ob_clean();
    include 'rss-xml-template.php';
    $content = ob_get_contents();
    ob_end_clean();
    echo $content;
    exit();
}

/* /wp-json/ will be prepended to the URL namespace by the wordpress REST API by default */
function register_rss_endpoint() {
    register_rest_route( 'rss', 'podcasts.xml', array(
            'methods' => 'GET',
            'callback' => 'generate_rss_xml',
        )
    );
}

add_action( 'rest_api_init', 'register_rss_endpoint' );
