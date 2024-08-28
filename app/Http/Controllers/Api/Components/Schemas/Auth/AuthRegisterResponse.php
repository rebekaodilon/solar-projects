<?php

namespace App\Http\Controllers\Api\Components\Schemas\Auth;

/**
 * @OA\Schema(
 *     schema="AuthRegisterResponse",
 *     title="AuthRegisterResponse",
 *     description="Authentication Register Response",
 *     @OA\Property(
 *         property="message",
 *         type="string",
 *         description="Message",
 *         example="User registered successfully"
 *     ),
 *     @OA\Property(
 *         property="token",
 *         type="string",
 *         description="Authentication token",
 *         example="bearer"
 *     )
 * )
 */
class AuthRegisterResponse {}
