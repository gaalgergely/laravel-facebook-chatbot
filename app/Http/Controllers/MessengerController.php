<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
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
            return $request->get('hub_challenge');
        }

        return response()->json(['Bad verify token.'], Response::HTTP_FORBIDDEN);
    }

    public function webHookPost(Request $request)
    {
        //Log::info('Message received.' . print_r($request->all(), 1));

        $bot = new FbBotApp(env('PAGE_ACCESS_TOKEN'));
        $message = new Message($request->get('entry')[0]['messaging'][0]['sender']['id'], 'Hello beautiful world!');
        $bot->send($message);
    }
}
