<?php

namespace App\Enums;

enum EquipmentEnum: string
{
    case MODULE = 'Módulo';
    case INVERTER = 'Inversor';
    case MICROINVERTER = 'Microinversor';
    case STRUCTURE = 'Estrutura';
    case RED_CABLE = 'Cabo vermelho';
    case BLACK_CABLE = 'Cabo preto';
    case STRING_BOX = 'String Box';
    case TRUNK_CABLE = 'Cabo Tronco';
    case END_CAP = 'Endcap';
}
