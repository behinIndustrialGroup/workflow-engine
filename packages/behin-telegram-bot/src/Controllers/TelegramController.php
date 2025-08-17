<?php

namespace Behin\TelegramBot\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Behin\TelegramBot\Models\TelegramBot;
use Behin\TelegramBot\Models\TelegramMessage;

class TelegramController extends Controller
{
    public function bots()
    {
        $bots = TelegramBot::all();
        return view('TelegramBotViews::bots.index', compact('bots'));
    }

    public function messagesView(TelegramBot $bot)
    {
        return view('TelegramBotViews::messages.index', compact('bot'));
    }


    public function storeBot(Request $request)
    {
        $bot = TelegramBot::create($request->only('name', 'token'));
        return response()->json($bot);
    }

    public function webhook($token, Request $request)
    {
        $bot = TelegramBot::where('token', $token)->firstOrFail();
        $update = $request->all();
        $chatId = data_get($update, 'message.chat.id');
        $text = data_get($update, 'message.text');

        if ($chatId && $text) {
            TelegramMessage::create([
                'telegram_bot_id' => $bot->id,
                'user_id' => $chatId,
                'message' => $text,
            ]);
        }
        return response()->json(['ok' => true]);
    }

    public function messages(TelegramBot $bot)
    {
        return response()->json($bot->messages()->latest()->get());
    }

    public function reply(TelegramMessage $message, Request $request)
    {
        $bot = $message->bot;
        $text = $request->input('text');

        Http::post("https://api.telegram.org/bot{$bot->token}/sendMessage", [
            'chat_id' => $message->user_id,
            'text' => $text,
        ]);

        $message->response = $text;
        $message->responded_at = now();
        $message->save();

        return response()->json(['status' => 'sent']);
    }
}
