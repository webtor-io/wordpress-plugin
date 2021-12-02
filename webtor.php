<?php
/*
* Plugin Name: Webtor Player
* Description: Provides your users the ability to watch torrent-videos online on your website. Popular videos are cached and converted to various formats for optimal playback on mobile devices!
* Version: 0.0.1
* Author: Webtor.io
* Author URI: https://webtor.io
*/

class Webtor {

    private $scriptInjected;

    private $defaults = array(
        'controls' => true,
        'width'    => '100%',
    );

    function generateAttrs($args) {
        $attrs = array();
        foreach ($args as $k => $v) {
            if ($k == 'controls') {
                if ($v) $attrs[] = 'controls';
            } else {
                $attrs[] = "$k=\"$v\"";
            }
        }
        return implode(' ', $attrs);
    }

    function splitArgs($args) {
        $attrs  = array();
        $tracks = array();
        foreach ($args as $k => $v) {
            if (strpos($k, 'track') === 0) {
                $tracks[$k] = $v;
            } else {
                $attrs[$k] = $v;
            }
        }
        return array($attrs, $tracks);
    }

    function generateTracks($args) {
        $tracks = array();
        foreach ($args as $k => $v) {
            $parts = explode('-', $k);
            $lang = 'en';
            if (sizeof($parts) == 2) {
                $attr = $parts[1];
            } else if (sizeof($parts) == 3) {
                $lang = $parts[1];
                $attr = $parts[2];
            } else {
                continue;
            }
            $tracks[$lang][$attr] = $v;
        }
        foreach ($tracks as $k => $v) {
            $tracks[$k]['srclang'] = $k;
            if (!isset($tracks[$k]['label'])) $tracks[$k]['label'] = $k;
        }
        $res = [];
        foreach ($tracks as $t) {
            $attrs = $this->generateAttrs($t);
            $res[] = "<track $attrs>";
        }
        return implode('', $res);
    }

    function shortcode($args) {
        $args = array_merge($this->defaults, $args);
        if (!isset($args['src'])) {
            return '<p>"src" attribute required!</p>';
        }
        list($args, $tracks) = $this->splitArgs($args);
        $attrs = $this->generateAttrs($args);
        $tracks = $this->generateTracks($tracks);
        $res = "<video $attrs>$tracks</video>";
        $res = '<p>'.$res.'</p>';
        if (!$this->scriptInjected) {
            $res .= '<script src="https://cdn.jsdelivr.net/npm/@webtor/embed-sdk-js/dist/index.min.js" charset="utf-8" async></script>';
            $this->scriptInjected = true;
        }
        return $res;
    }
}
$webtor = new Webtor();

add_shortcode('webtor', array($webtor, 'shortcode'));
?>