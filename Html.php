<?php
/**
 * Format an attribute string to insert in a tag.
 *
 * @param array $attributes An associative array of HTML attributes.
 * @return string (An HTML string ready for insertion in a tag.)
 */

function htmlAttributes(array $attributes = array()) {

    if (is_array($attributes)) {
        $txt = null;
        foreach ($attributes as $key => $val) {
            $txt .= " $key=" . '"' . checkPlain($val) . '"';
        }
        return $txt;
    }
    return null;
}

/**
 *
 * Lets you create HTML <a href=""></a> tags.
 *
 * @param string $text Text
 * @param string $path URL
 * @param boolean $html Bypass Text with HTML
 * @param array $attributes HTML attributes
 * @return string
 */
function l($text, $path, $html = false, array $attributes = array()) {

    // Remove all HTML and PHP tags from a tooltip. For best performance, we act only
    // if a quick strpos() pre-check gave a suspicion (because strip_tags() is expensive).
    if (isset($attributes['title']) && strpos($attributes['title'], '<') !== false) {
        $attributes['title'] = strip_tags($attributes['title']);
    }

    return '<a href="' . checkPlain($path) . '"' . htmlAttributes($attributes) . '>' . ($html ? $text : checkPlain($text)) . '</a>';
}

function autoCloseTagHtml($html){

	preg_match_all('#<([a-z]+)( .*)?(?!/)>#iU',$html,$result);
	$openedtags = $result[1];

	$openedtags = array_filter($openedtags, create_function('$val', 'return (!in_array($val, array("br", "img", "hr", "li")));'));

	preg_match_all('#</([a-z]+)>#iU',$html,$result);
	$closedtags = $result[1];
	$len_opened = count($openedtags);

	if (count($closedtags) == $len_opened)
		return $html;

	$openedtags = array_reverse($openedtags);

	for ($i=0;$i<$len_opened;$i++) {
		if (!in_array($openedtags[$i],$closedtags)) {
			$html .= '</'.$openedtags[$i].'>';
		} else {
			unset($closedtags[array_search($openedtags[$i],$closedtags)]);
		}
	}
	return $html;
}