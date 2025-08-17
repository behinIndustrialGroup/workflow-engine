<?php

namespace Behin\Ami\Controllers;

use Behin\Ami\Models\AmiSetting;
use Behin\Ami\Services\AmiClient;

class AmiStatusController
{
    public function index()
    {
        $setting = AmiSetting::first();
        $peers = [];
        if ($setting) {
            try {
                $client = new AmiClient($setting->host, $setting->port, $setting->username, $setting->password);
                $peers = $client->getPeers();
            } catch (\Exception $e) {
                $peers = [];
            }
        }
        return view('ami::status', compact('peers'));
    }
}
