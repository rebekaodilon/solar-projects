<?php

namespace App\Http\Controllers\Api\Components\Schemas\Equipment;

/**
 * @OA\Schema(
 *     schema="StoreEquipmentRequest",
 *     title="Store Equipment Request",
 *     description="Request body for storing a new equipment",
 *     required={"type", "quantity"},
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         description="Type of the equipment",
 *         example="Módulo"
 *     ),
 *     @OA\Property(
 *         property="quantity",
 *         type="integer",
 *         description="Quantity of the equipment",
 *         example=10
 *     )
 * )
 */
class StoreEquipmentRequest {}