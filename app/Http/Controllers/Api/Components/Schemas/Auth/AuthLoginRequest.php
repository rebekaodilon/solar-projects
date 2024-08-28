<?php

namespace App\Http\Controllers\Api\Components\Schemas\Auth;

/**
 * @OA\Schema(
 *     schema="AuthLoginRequest",
 *     title="AuthLoginRequest",
 *     description="Authentication Login Request",
 *     required={"email", "password"},
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Email of the User",
 *         example="john.doe@example.com"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         format="password",
 *         description="Password of the User",
 *         example="P@ssw0rd"
 *     )
 * )
 */
class AuthLoginRequest {}
