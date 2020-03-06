<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use pimax\FbBotApp;
use pimax\Messages\Message;
use Symfony\Component\HttpFoundation\Response;
use Thujohn\Twitter\Facades\Twitter;

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
        $bot = new FbBotApp(env('PAGE_ACCESS_TOKEN'));

        /**
         * log the messages sent by the user (collect)
         */
        $input = strtolower($request->get('entry')[0]['messaging'][0]['message']['text']);

        if(in_array($input, ['berlin', 'montreal', 'paris'])) {

            $trends = Twitter::getTrendsPlace(['id' => 638242]);

            $text = 'Trends in ' . ucfirst($input) . ': ';

            foreach ($trends[0]->trends as $index => $trend) {
                if($index > 9) break;
                $text .= "\n" . ++$index . '. ' . $trend->name;
            }

        } else {

            switch ($input) {

                case 'help': $text = 'How can I help?'; break;

                case 'hi':
                case 'hello':
                    $text = 'Hi back!'; break;

                default: $text = 'I can\'t understand';
            }

        }

        $message = new Message($request->get('entry')[0]['messaging'][0]['sender']['id'], $text);
        $bot->send($message);
    }
}
