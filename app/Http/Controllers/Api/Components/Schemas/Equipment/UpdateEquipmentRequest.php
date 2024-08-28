<?php

namespace App\Http\Controllers\Api\Components\Schemas\Equipment;

/**
 * @OA\Schema(
 *     schema="UpdateEquipmentRequest",
 *     title="Update Equipment Request",
 *     description="Request body for updating an existing equipment",
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
 *         example=20
 *     )
 * )
 */

class UpdateEquipmentRequest {}