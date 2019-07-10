<?php
/**
 * Template Name: Custom RSS Template - Feedname
 */

$args = array(
    'category_name' => 'Audio',
    'numberposts' => -1
);

$the_query = get_posts($args);

header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
?>

<rss version="2.0"
     xmlns:content="http://purl.org/rss/1.0/modules/content/"
     xmlns:wfw="http://wellformedweb.org/CommentAPI/"
     xmlns:dc="http://purl.org/dc/elements/1.1/"
     xmlns:atom="http://www.w3.org/2005/Atom"
     xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
     xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
     xmlns:itunes="http://www.itunes.com/DTDs/Podcast-1.0.dtd">
    <?php do_action('rss2_ns'); ?>
    <channel>
        <title><?php bloginfo_rss('name'); ?></title>
        <link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
        <link><?php bloginfo_rss('url') ?></link>
        <description><?php bloginfo_rss('description') ?></description>
        <language><?php echo get_option('rss_language'); ?></language>
        <copyright>Copyright: (C) The National Archives, see http://www.nationalarchives.gov.uk/legal/copyright.htm for terms and conditions of reuse</copyright>
        <webMaster>webmaster@nationalarchives.gov.uk (Webmaster)</webMaster>
        <lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>
        <itunes:summary>Lectures, discussions, talks and other events presented by The National Archives of the United Kingdom.</itunes:summary>
        <itunes:author>The National Archives</itunes:author>
        <itunes:explicit>no</itunes:explicit>
        <itunes:keywords>history, archives, family history, genealogy, teaching, medieval, domesday, military, army, navy, air force, medals, records, information</itunes:keywords>
        <itunes:owner>
            <itunes:name>The National Archives</itunes:name>
            <itunes:email>webmaster@nationalarchives.gov.uk</itunes:email>
        </itunes:owner>
        <itunes:category text="Society &amp; Culture">
            <itunes:category text="History"/>
        </itunes:category>
        <itunes:category text="Education"/>
        <itunes:category text="Arts"/>
        <image>
            <title>The National Archives Podcast Series</title>
            <url>http://www.nationalarchives.gov.uk/images/global/sound-mirror-itunes-tna-podcast-series.jpg</url>
            <link>http://www.nationalarchives.gov.uk/rss/podcasts.xml</link>
        </image>

        <?php
        do_action('rss2_head');
        foreach ($the_query as $post){ ?>
            <item>
                <title><?php the_title_rss(); ?></title>
                <description><![CDATA[
                    <?php
                    $content = $post->post_content;
                    $content_clean = strip_tags($content);
                    echo $content_clean;
                    ?>]]>
                </description>
                <itunes:author><?php echo $post->post_author ?></itunes:author>
                <pubDate><?php echo $post->post_date ?></pubDate>
                <enclosure><?php echo get_post_meta( $post->ID, $key = 'enclosure',true) ?></enclosure>
                <guid><?php echo $post->guid ?></guid>
                <itunes:explicit>no</itunes:explicit>
                <itunes:duration><?php echo get_post_meta( $post->ID, $key = 'duration',true) ?></itunes:duration>
                <itunes:keywords>
                    <?php
                    $tagArray = array();
                    $tags = get_the_tags($post->ID);
                    foreach($tags as $tag){
                        array_push($tagArray, $tag->name);
                    }
                    echo implode(', ', $tagArray);
                    ?>
                </itunes:keywords>
                <?php
                $categories = get_the_category($post->ID);
                foreach($categories as $index){ ?>
                    <category><?php print_r($index->cat_name)?></category>
                <?php } ?>
                <?php do_action('rss2_item'); ?>
            </item>
        <?php } ?>
    </channel>
</rss>
