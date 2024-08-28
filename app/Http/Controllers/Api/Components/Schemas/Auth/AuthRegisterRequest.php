<?php

namespace App\Http\Controllers\Api\Components\Schemas\Auth;

/**
 * @OA\Schema(
 *     schema="AuthRegisterRequest",
 *     title="AuthRegisterRequest",
 *     description="Authentication Register Request",
 *     required={"name", "email", "password"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the User",
 *         example="John Doe"
 *     ),
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


class AuthRegisterRequest {}