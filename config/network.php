<?php

return [
    'trusted_proxies' => count($proxies = explode(',', env('TRUSTED_PROXIES', null))) > 1 ?
        $proxies : $proxies[0]
];
