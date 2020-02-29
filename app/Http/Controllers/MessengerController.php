<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use pimax\FbBotApp;
use pimax\Messages\Message;
use Symfony\Component\HttpFoundation\Response;

class MessengerController extends Controller
{
    public function webHook(Request $request)
    {
        $localVerifyToken = env('WEBHOOK_VERIFY_TOKEN');
        $hubVerifyToken = $request->get('hub_verify_token');

        if($localVerifyToken === $hubVerifyToken) {
            return response()->json(['Ok.']);
        }

        return response()->json(['Bad verify token.'], Response::HTTP_FORBIDDEN);
    }
}
