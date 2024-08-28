<?php

namespace App\Http\Controllers\Api\Components\Schemas\Auth;

/**
 * @OA\Schema(
 *     schema="AuthLoginResponse",
 *     title="AuthLoginResponse",
 *     description="Authentication Login Response",
 *     @OA\Property(
 *         property="status",
 *         type="boolean",
 *         description="Request status",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="message",
 *         type="string",
 *         description="Response message",
 *         example="User logged in successfully"
 *     ),
 *     @OA\Property(
 *         property="token",
 *         type="string",
 *         description="Authentication token",
 *         example="bearer"
 *     )
 * )
 */
class AuthLoginResponse {}
