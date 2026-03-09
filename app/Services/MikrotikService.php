<?php

namespace App\Services;

use RouterOS\Client;
use RouterOS\Query;
use RouterOS\Config;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * MikroTikService - Handling all RouterOS API interactions.
 * Built for Rombo Village WiFi (MobileX Aesthetic Integration)
 */
class MikrotikService
{
    protected ?Client $client = null;

    public function __construct($router = null)
    {
        $this->connect($router);
    }

    /**
     * Establishment of connection to the MikroTik Router
     */
    protected function connect($router = null): void
    {
        try {
            $ip = $router ? $router->ip : env('MIKROTIK_IP', '192.168.1.100');
            $user = $router ? $router->username : env('MIKROTIK_USER', 'admin');
            $pass = $router ? $router->password : env('MIKROTIK_PASS', '12345');
            $port = $router ? $router->port : (int) env('MIKROTIK_PORT', 8728);

            $config = (new Config())
                ->set('host', $ip)
                ->set('user', $user)
                ->set('pass', $pass)
                ->set('port', (int) $port)
                ->set('ssl', (bool) env('MIKROTIK_SSL', false))
                ->set('timeout', 5);

            $this->client = new Client($config);
        } catch (Exception $e) {
            Log::error('MikroTik Connection Failed: ' . $e->getMessage());
            $this->client = null;
        }
    }

    /**
     * Check if client is connected
     */
    public function isConnected(): bool
    {
        return $this->client !== null;
    }

    /**
     * Add a user to MikroTik Hotspot
     * 
     * @param string $code (Used for both Name and Password)
     * @param string|null $macAddress
     * @param string $limitUptime (e.g. 01:00:00)
     * @param int|null $limitBytes
     * @param string $profile
     */
    public function addHotspotUser(string $code, ?string $macAddress, string $limitUptime, ?int $limitBytes = null, string $profile = 'default')
    {
        if (!$this->isConnected()) return false;

        $query = (new Query('/ip/hotspot/user/add'))
            ->equal('name', $code)
            ->equal('password', $code)
            ->equal('profile', $profile)
            ->equal('limit-uptime', $limitUptime);

        if ($macAddress) {
            $query->equal('mac-address', $macAddress);
        }

        if ($limitBytes) {
            $query->equal('limit-bytes-total', (string) $limitBytes);
        }

        try {
            return $this->client->query($query)->read();
        } catch (Exception $e) {
            Log::error('MikroTik Add User Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Remove or disable user
     */
    public function disconnectUser(string $username): bool
    {
        if (!$this->isConnected()) return false;

        try {
            // Find user ID first
            $queryPrint = (new Query('/ip/hotspot/user/print'))
                ->where('name', $username);
            $user = $this->client->query($queryPrint)->read();

            if (!empty($user) && isset($user[0]['.id'])) {
                $queryRemove = (new Query('/ip/hotspot/user/remove'))
                    ->equal('.id', $user[0]['.id']);
                $this->client->query($queryRemove)->read();
                return true;
            }
            return false;
        } catch (Exception $e) {
            Log::error('MikroTik Remove User Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Force disconnect from active sessions
     */
    public function forceDisconnect(string $username): bool
    {
        if (!$this->isConnected()) return false;

        try {
            $queryPrint = (new Query('/ip/hotspot/active/print'))
                ->where('user', $username);
            $active = $this->client->query($queryPrint)->read();

            if (!empty($active) && isset($active[0]['.id'])) {
                $queryRemove = (new Query('/ip/hotspot/active/remove'))
                    ->equal('.id', $active[0]['.id']);
                $this->client->query($queryRemove)->read();
                return true;
            }
            return false;
        } catch (Exception $e) {
            Log::error('MikroTik Force Disconnect Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all connected users
     */
    public function getConnectedUsers(): array
    {
        if (!$this->isConnected()) return [];

        try {
            $query = new Query('/ip/hotspot/active/print');
            return $this->client->query($query)->read();
        } catch (Exception $e) {
            Log::error('MikroTik Get Active Users Error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Test Connection for Admin Settings
     */
    public function testConnection(): bool
    {
        return $this->isConnected();
    }

    /**
     * Helper: Convert minutes to MikroTik time format (00:00:00)
     */
    public static function formatUptime(int $minutes): string
    {
        $h = floor($minutes / 60);
        $m = $minutes % 60;
        return sprintf('%02d:%02d:00', $h, $m);
    }
}
