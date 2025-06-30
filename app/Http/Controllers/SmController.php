<?php

namespace App\Http\Controllers;

use App\Actions\Sms\SendSingleSmsAction;
use App\DTOs\SendSingleSmsDTO;
use Illuminate\Http\Request;

class SmController extends Controller
{
    public function send(Request $request, SendSingleSmsAction $action)
    {
        $validated = $request->validate([
            'senderID' => 'required|string',
            'to'       => 'required|string',
            'msg'      => 'required|string',
        ]);

        $dto = new SendSingleSmsDTO(
            senderID: $validated['senderID'],
            to:       $validated['to'],
            msg:      $validated['msg']
        );

        $result = $action->execute($dto);

        return response()->json($result);
    }
}
