<?php
require_once '../wakusell.php';

$params = [
    'email' => 'silverproductions@live.com',
    'api_key' => 'KGQRF7CQl5CcsksMzm9fBqXPPevKdu5D',
    'domainname' => 'snl.co.mz',
    'regperiod' => '1',
    'nameservers' => [
        'ns1.example.com',
        'ns2.example.com',
    ],
];

$result = wakusell_RegisterDomain($params);
print_r($result);
?>