<?php

$postdata = json_decode(file_get_contents("php://input"), true);

if (!isset($postdata['fmAuthToken']) || $postdata['fmAuthToken'] != "mysecretapitoken") {
        return "facimeManager API authentication failed!";
}
unset($postdata['fmAuthToken']);

$parameters = "";
foreach ($postdata as $key => $val) {
        if ($key == "value") {
                $parameters .= " " . $key . "=\"" . htmlspecialchars(strip_tags($val), ENT_NOQUOTES) . "\"";
        }
        elseif ($key == "name") {
                $parameters .= " " . $key . "=" . str_replace(".mydomain.ext", "", htmlspecialchars(strip_tags($val), ENT_NOQUOTES));
        }
        else {
                $parameters .= " " . $key . "=" . htmlspecialchars(strip_tags($val), ENT_NOQUOTES);
        }
}

exec("sudo /path/to/my/scripts/dnsapi.sh api" . $parameters, $output);

print(empty($output) ? "" : $output[0]);

// END OF FILE
