<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class UserLocationUpdated implements ShouldBroadcastNow
{
    use SerializesModels;

    public $userId;
    public $role;
    public $latitude;
    public $longitude;
    public $busId;
    public $timestamp;

    public function __construct($userId, $role, $latitude, $longitude, $busId = null)
    {
        $this->userId = $userId;
        $this->role = $role;
        $this->latitude = (float)$latitude;
        $this->longitude = (float)$longitude;
        $this->busId = $busId;
        $this->timestamp = now()->toISOString();
    }

    public function broadcastOn()
    {
        // Drivers broadcast to "drivers" channel; Passengers to "passengers" channel
        if ($this->role === 'driver') {
            return new Channel('drivers');
        }
        return new Channel('passengers');
    }

    public function broadcastAs()
    {
        return 'location.updated';
    }

    public function broadcastWith()
    {
        return [
            'userId'    => $this->userId,
            'role'      => $this->role,
            'latitude'  => $this->latitude,
            'longitude' => $this->longitude,
            'busId'     => $this->busId,
            'timestamp' => $this->timestamp,
        ];
    }
}
