<?php

namespace App\Libraries\Registrar\Providers;

use App\Libraries\Registrar\RegistrarInterface;

class Wakusell implements RegistrarInterface {
    private $config;
    private $lang;
    private $error;
    private $whidden;
    private $order;
    private $api;

    public function __construct() {
        $this->config = Modules::Config("Registrars", __CLASS__);
        $this->lang = Modules::Lang("Registrars", __CLASS__);

        if (!class_exists("Wakusell_API")) {
            include __DIR__ . DS . "api.php";
        }

        $this->api = new Wakusell_API($this->config);
    }

    public function getSettingsPage() {
        // Pass $config and $lang to the settings page
        $config = $this->config;
        $lang = $this->lang;

        // Include the settings.php file
        include __DIR__ . DS . "pages" . DS . "settings.php";
    }

    public function questioning($sld, $tlds) {
        $domain = $sld . '.' . $tlds[0];
        return $this->api->checkDomainAvailability($domain);
    }

    public function register($domain, $sld, $tld, $year, $dns, $whois, $wprivacy) {
        $params = [
            "domain" => $domain,
            "regperiod" => $year,
            "nameservers" => $dns,
            "contacts" => $whois,
            "idprotection" => $wprivacy ? 1 : 0
        ];
        return $this->api->registerDomain($params);
    }

    public function renew($params, $domain, $sld, $tld, $year, $oduedate, $nduedate) {
        $params = [
            "domain" => $domain,
            "regperiod" => $year
        ];
        return $this->api->renewDomain($params);
    }

    public function transfer($domain, $sld, $tld, $year, $dns, $whois, $wprivacy, $eppCode) {
        $params = [
            "domain" => $domain,
            "eppcode" => $eppCode,
            "regperiod" => $year,
            "nameservers" => $dns,
            "contacts" => $whois,
            "idprotection" => $wprivacy ? 1 : 0
        ];
        return $this->api->transferDomain($params);
    }

    public function NsDetails($params) {
        $domain = $params["domain"];
        return $this->api->getNameservers($domain);
    }

    public function ModifyDns($params, $dns) {
        $domain = $params["domain"];
        return $this->api->updateNameservers($domain, $dns);
    }

    public function getWhoisPrivacy($params) {
        $domain = $params["domain"];
        $response = $this->api->getWhoisPrivacy($domain);
        return $response["status"] ?? "unknown";
    }

    public function purchasePrivacyProtection($params) {
        $domain = $params["domain"];
        return $this->api->purchasePrivacyProtection($domain);
    }

    public function modifyPrivacyProtection($params, $status) {
        $domain = $params["domain"];
        return $this->api->modifyPrivacyProtection($domain, $status);
    }

    public function getTransferLock($params) {
        $domain = $params["domain"];
        $response = $this->api->getTransferLock($domain);
        return $response["status"] ?? false;
    }

    public function ModifyTransferLock($params, $status) {
        $domain = $params["domain"];
        return $this->api->modifyTransferLock($domain, $status);
    }

    public function isInactive($params) {
        $domain = $params["domain"];
        $response = $this->api->isInactive($domain);
        return $response["status"] ?? false;
    }

    public function getAuthCode($params) {
        $domain = $params["domain"];
        $response = $this->api->getAuthCode($domain);
        return $response["authcode"] ?? "";
    }

    public function modifyAuthCode($params, $authCode) {
        $domain = $params["domain"];
        return $this->api->modifyAuthCode($domain, $authCode);
    }

    public function sync($params) {
        $domain = $params["domain"];
        $response = $this->api->sync($domain);
        return [
            "creationtime" => $response["creation_date"] ?? "",
            "endtime" => $response["expiration_date"] ?? "",
            "status" => $response["status"] ?? "unknown"
        ];
    }

    public function transfer_sync($params) {
        $domain = $params["domain"];
        $response = $this->api->transfer_sync($domain);
        return [
            "creationtime" => $response["creation_date"] ?? "",
            "endtime" => $response["expiration_date"] ?? "",
            "status" => $response["status"] ?? "unknown"
        ];
    }

    public function get_info($params) {
        $domain = $params["domain"];
        return $this->api->get_info($domain);
    }

    public function domains() {
        return $this->api->domains();
    }

    public function import_domain($data) {
        return $this->api->import_domain($data);
    }

    public function apply_import_tlds() {
        return $this->api->apply_import_tlds();
    }
}