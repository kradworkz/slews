<?php

namespace App\Http\Controllers;

use App\Models\DeviceData;
use Illuminate\Http\Request;
use App\Events\PacketReceiver;

class PacketController extends Controller
{
    public function index(){
        header("Content-type: application/json");
        $json = file_get_contents("php://input");

        $obj = json_decode($json);
        $binary = base64_decode($obj->devEUI);
        $devicename = $obj->deviceName;
        $tracker_id = bin2hex($binary);
        $decoded = json_encode($obj->objectJSON);
        $a = \json_decode($decoded);
        $aa = \json_decode($a);

        $wew = new DeviceData;
        $wew->code = $tracker_id;
        $wew->accelerometer = $aa->Accelerometer;
        $wew->gyro = $aa->Gyro;
        $wew->soilmoisture = $aa->SoilMoisture;
        $wew->temperature = $aa->Temperature;
        $wew->save();

        if($wew->save()){
            broadcast(new PacketReceiver($wew));

            return 'success';
        }


    }
}
