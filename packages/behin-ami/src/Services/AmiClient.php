<?php

namespace Behin\Ami\Services;

class AmiClient
{
    protected string $host;
    protected int $port;
    protected string $username;
    protected string $password;

    public function __construct(string $host, int $port, string $username, string $password)
    {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
    }

    public function getPeers(): array
    {
        $socket = @fsockopen($this->host, $this->port, $errno, $errstr, 5);
        if (! $socket) {
            return [];
        }

        stream_set_timeout($socket, 5);
        fputs($socket, "Action: Login\r\nUsername: {$this->username}\r\nSecret: {$this->password}\r\nEvents: off\r\n\r\n");
        fgets($socket, 4096);

        fputs($socket, "Action: SIPPeers\r\n\r\n");
        $response = '';
        while (!feof($socket)) {
            $line = fgets($socket, 4096);
            if ($line === false) {
                break;
            }
            $response .= $line;
            if (str_contains($line, 'Event: PeerlistComplete')) {
                break;
            }
        }
        fputs($socket, "Action: Logoff\r\n\r\n");
        fclose($socket);

        $peers = [];
        $entry = [];
        foreach (explode("\n", $response) as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }
            if (str_starts_with($line, 'Event: PeerEntry')) {
                if (!empty($entry)) {
                    $peers[] = $entry;
                    $entry = [];
                }
                continue;
            }
            if (str_contains($line, ':')) {
                [$key, $value] = array_map('trim', explode(':', $line, 2));
                $entry[strtolower($key)] = $value;
            }
        }
        if (!empty($entry)) {
            $peers[] = $entry;
        }

        return array_map(fn($p) => [
            'objectname' => $p['objectname'] ?? '',
            'status' => $p['status'] ?? '',
        ], $peers);
    }
}
