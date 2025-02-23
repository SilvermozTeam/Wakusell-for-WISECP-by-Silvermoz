<?php

namespace App\Libraries\Registrar;

interface RegistrarInterface {
    public function questioning($sld, $tlds);
    public function register($domain, $sld, $tld, $year, $dns, $whois, $wprivacy);
    public function renew($params, $domain, $sld, $tld, $year, $oduedate, $nduedate);
    public function transfer($domain, $sld, $tld, $year, $dns, $whois, $wprivacy, $eppCode);
    public function NsDetails($params);
    public function ModifyDns($params, $dns);
    public function getWhoisPrivacy($params);
    public function purchasePrivacyProtection($params);
    public function modifyPrivacyProtection($params, $status);
    public function getTransferLock($params);
    public function ModifyTransferLock($params, $status);
    public function isInactive($params);
    public function getAuthCode($params);
    public function modifyAuthCode($params, $authCode);
    public function sync($params);
    public function transfer_sync($params);
    public function get_info($params);
    public function domains();
    public function import_domain($data);
    public function apply_import_tlds();
}