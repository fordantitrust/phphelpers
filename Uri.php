<?php
/**
 * Sanity check, is it really an URL?
 */
function isUri($url){
    $url = substr($url,-1) == "/" ? substr($url,0,-1) : $url;
    if ( !$url || $url=="" ) return false;
    if ( !( $parts = @parse_url( $url ) ) ) return false;
    else {
        if ( $parts[scheme] != "http" && $parts[scheme] != "https" && $parts[scheme] != "ftp" && $parts[scheme] != "gopher" ) return false;
        else if ( !eregi( "^[0-9a-z]([-.]?[0-9a-z])*.[a-z]{2,4}$", $parts[host], $regs ) ) return false;
        else if ( !eregi( "^([0-9a-z-]|[_])*$", $parts[user], $regs ) ) return false;
        else if ( !eregi( "^([0-9a-z-]|[_])*$", $parts[pass], $regs ) ) return false;
        else if ( !eregi( "^[0-9a-z/_.@~-]*$", $parts[path], $regs ) ) return false;
        else if ( !eregi( "^[0-9a-z?&=#,]*$", $parts[query], $regs ) ) return false;
    }
    return true;
}

function selfUri() {
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")).$s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
    return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
}