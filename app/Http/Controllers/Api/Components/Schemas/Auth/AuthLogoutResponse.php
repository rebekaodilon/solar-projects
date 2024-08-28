<?php

namespace App\Http\Controllers\Api\Components\Schemas\Auth;

/**
 * @OA\Schema(
 *     title="AuthLogoutResponse",
 *     description="Auth Logout Response",
 *     required={"message"},
 *     @OA\Property(property="message", type="string", description="Message", example="User logged out successfully")
 * )
 */
class AuthLogoutResponse {}
