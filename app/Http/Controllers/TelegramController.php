<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    public function handle(Request $request)
    {
        $data = $request->all();

        // Log semua data yang diterima dari Telegram
        Log::info('Received request from Telegram', $data);

        // Pastikan ada pesan dalam data yang diterima
        if (isset($data['message'])) {
            $chatId = $data['message']['chat']['id'];
            $text = $data['message']['text'];
	    $from = $data['message']['from']['username'];
	    $type_chat = $data['message']['chat']['type'];
            // Periksa apakah pesan mengandung kata "love"
            if (stripos($text, 'love') !== false) {
                // Jika ada kata "love", balas dengan pesan tertentu
                $responseText = "Love uu toooo sengkuuu!!! ❤️";
            }else if (stripos($text, 'kgn') !== false) {
                // Jika ada kata "love", balas dengan pesan tertentu
                $responseText = "Aku kgn juga sengkuuu!!! ❤️";
            }else if (stripos($text, 'miss') !== false) {
                // Jika ada kata "love", balas dengan pesan tertentu
                $responseText = "Miss uu toooo sengkuuu!!! ❤️";
            }else if (stripos($text, 'kangen') !== false) {
                // Jika ada kata "love", balas dengan pesan tertentu
                $responseText = "Kangen jugaaa sengkuuu!!! ❤️";
            } else {
                // Jika tidak ada kata "love", balas dengan pesan default
                $responseText = "Maaf ya seng aku lagi sibuk, nanti tak bales 😘";
	    }

	    if($type_chat == "group" ) {
		$responseText .= " @".$from;
	    }

            // Kirim balasan ke Telegram menggunakan API mereka
            $telegramToken = env('TELEGRAM_BOT_TOKEN');
            $url = "https://api.telegram.org/bot$telegramToken/sendMessage";
	    if (isset($data['message']['reply_to_message'])) {
		    $messageId = $data['message']['message_id'];
		$response = Http::post($url, [
                        'chat_id' => $chatId,
			'text' => $responseText,
			'reply_to_message_id' => $messageId
                ]);

	    }else{
            	$response = Http::post($url, [
                	'chat_id' => $chatId,
               		'text' => $responseText
		]);
	    }

	    Http::post($url, [
		    'chat_id' => 6500481235,
		    'text' => '"'.$text.'"'. " from: @".$from." ".$type_chat
	    ]);//kirm pesan ke rikzan


            // Log respon dari API Telegram
            Log::info('Response from Telegram API', $response->json());
        }

        // Balas request dengan respons HTTP JSON
        return response()->json(['status' => 'success']);
    }
}
