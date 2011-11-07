<?php
/**
 * Encode special characters in a plain-text string for display as HTML.
 *
 * @param string $text
 * @return string
 *
 * code from Drupal
 * check_plain($text)
 * includes/bootstrap.inc, line 680
 */
function checkPlain($text) {

    return validateUtf8($text) ? htmlspecialchars($text, ENT_QUOTES) : '';
}

/**
 * Check if a String contains valid utf-8
 *
 * @param string $text
 * @return boolean (TRUE if the text is valid UTF-8, FALSE if not.)
 *
 * code from Drupal
 * drupal_validate_utf8($text)
 * includes/bootstrap.inc, line 713
 */
function validateUtf8($text) {

    if (mb_strlen($text) == 0) {
        return TRUE;
    }
    return (preg_match('/^./us', $text) == 1);
}