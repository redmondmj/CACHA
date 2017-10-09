<?php

function smarty_function_css_files($params)
{
    $html = "";
    $root_url = $params["root_url"];
    $module_folder = $params["module_folder"];
    foreach ($params["files"] as $file) {
        $html .= "<link type=\"text/css\" rel=\"stylesheet\" href=\"$root_url/modules/$module_folder/$file\">\n";
    }
    return $html;
}
