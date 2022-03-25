<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\TypeEquipment;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class SNCheck
{
    public static function checkSerialMask($serial, $mask)
    {
        if (strlen($serial) != strlen($mask))
            return false;

        $regx = array(
            "N" => "[0-9]",
            "A" => "[A-Z]",
            "a" => "[a-z]",
            "X" => "[A-Z0-9]",
            "Z" => "[-|_|@]"
        );

        $maskChars = str_split($mask);

        $outputRegex = "/^";
        foreach ($maskChars as $char) {
            $outputRegex .= $regx[$char];
        }
        $outputRegex .= "/gu";

        return (preg_match($outputRegex, $serial) > 0 ? true : false);
    }
}

class EquipmentController extends Controller
{
    public function test()
    {
        TypeEquipment::create([
            'name' => 'D-Link DIR-300',
            'mask' => 'NXXAAXZXAA'
        ]);
        TypeEquipment::create([
            'name' => 'TP-Link TL-WR74',
            'mask' => 'XXAAAAAXAA'
        ]);
        TypeEquipment::create([
            'name' => 'D-Link DIR-300 S',
            'mask' => 'NXXAAXZXXX'
        ]);
    }

    public function getEquipment(): JsonResponse
    {
        $equp = Equipment::with('types')->get();
        return response()->json($equp, Response::HTTP_OK);
    }

    public function getEquipmentTypes(): JsonResponse
    {
        $equp_types = TypeEquipment::all();
        return response()->json($equp_types, Response::HTTP_OK);
    }

    public function getEquipmentById(Request $request): JsonResponse
    {
        $equp = Equipment::findOrFail($request->id);
        return response()->json($equp, Response::HTTP_OK);
    }

    public function createEquipment(Request $request): JsonResponse
    {
        //$serial_numb_is_correct = SNCheck::checkSerialMask($request->serial, TypeEquipment::find($request->type_id));
        $serial_numb_is_correct = true;
        if ($serial_numb_is_correct) {
            $equp = Equipment::create([
                'type_id' => $request->type_id,
                'serial' => $request->serial,
                'remark' => $request->remark,
            ]);
            return response()->json(Equipment::with('types')->where('id', '=', $equp->id)->get()[0], Response::HTTP_OK);
        }else{
            return response()->json([$request->serial, TypeEquipment::find($request->type_id)], Response::HTTP_OK);
        }
    }

    public function editEquipment(Request $request): JsonResponse
    {
        $equp = Equipment::findOrFail($request->id);
        $equp->update([
            'type_id' => $request->type_id,
            'serial' => $request->serial,
            'remark' => $request->remark
        ]);
        return response()->json(Equipment::with('types')->where('id', '=', $equp->id)->get()[0], Response::HTTP_OK);
    }

    public function deleteEquipment(Request $request)
    {
        Equipment::findOrFail($request->id)->delete();
        return response()->json("Успех", Response::HTTP_OK);
    }

    public function createEquipmentTypes(Request $request): JsonResponse
    {
        $equp_type = TypeEquipment::create([
            'name' => $request->name,
            'mask' => $request->mask
        ]);

        return response()->json($equp_type, Response::HTTP_OK);
    }
}
