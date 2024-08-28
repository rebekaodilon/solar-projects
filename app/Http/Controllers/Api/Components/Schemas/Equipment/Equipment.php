<?php

namespace App\Http\Controllers\Api\Components\Schemas\Equipment;

/**
 * @OA\Schema(
 *     schema="Equipment",
 *     title="Equipment",
 *     description="Details of a project equipment",
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         description="Type of the equipment",
 *         example="Módulo"
 *     ),
 *     @OA\Property(
 *        property="quantity",
 *        type="integer",
 *        description="Quantity of the equipment",
 *        example=10
 *    )
 * )
 */
class Equipment {}