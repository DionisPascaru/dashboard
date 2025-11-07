<?php

namespace App\Enums\Client;

/**
 * Client status enum.
 */
enum ClientStatusEnum: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Pending = 'pending';
    case Blocked = 'blocked';
}
