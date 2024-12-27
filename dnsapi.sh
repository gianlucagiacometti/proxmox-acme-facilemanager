#!/bin/bash

if [ -z "'$*'" ]; then
        echo -e "API Parameters missing"
else
        /usr/bin/php /path/to/facileManager/client/fmDNS/client.php "$@"
fi
