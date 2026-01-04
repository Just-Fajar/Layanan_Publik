<?php

namespace App\Exceptions;

use Exception;

class UnauthorizedException extends Exception
{
    /**
     * Create a new exception for unauthorized access.
     */
    public static function accessDenied(): self
    {
        return new self('Anda tidak memiliki akses untuk melakukan tindakan ini.', 403);
    }

    /**
     * Create a new exception for insufficient permissions.
     */
    public static function insufficientPermissions(string $action = ''): self
    {
        $message = $action
            ? "Anda tidak memiliki izin untuk {$action}."
            : 'Anda tidak memiliki izin yang cukup.';

        return new self($message, 403);
    }

    /**
     * Create a new exception for unauthenticated request.
     */
    public static function unauthenticated(): self
    {
        return new self('Anda harus login terlebih dahulu.', 401);
    }

    /**
     * Create a new exception for token expired.
     */
    public static function tokenExpired(): self
    {
        return new self('Sesi Anda telah berakhir. Silakan login kembali.', 401);
    }

    /**
     * Create a new exception for invalid token.
     */
    public static function invalidToken(): self
    {
        return new self('Token tidak valid.', 401);
    }
}
