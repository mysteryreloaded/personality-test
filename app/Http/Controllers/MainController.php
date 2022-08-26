<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class MainController extends Controller
{
    public const REDIS_KEY_TEMPLATE = 'SESSION_QUESTION';

    public function index(Request $request)
    {
        $questions = Question::getQuestions();

        if ($request->ajax() && $request->wantsJson()) {
            return response()->json(['success' => true, 'questions' => $questions]);
        }

        $isIndex = true;
        $routes = [
            'index' => route('index'),
            'create' => route('create'),
            'destroy' => route('destroy'),
            'store' => route('answer.store', ['id' => '_ID_']),
            'finish' => route('finish'),
        ];

        return view('main', compact('questions', 'routes', 'isIndex'));
    }

    public function create()
    {
        $isIndex = false;
        $routes = [
            'index' => route('index'),
            'create' => route('create'),
            'destroy' => route('destroy'),
            'store' => route('question.store'),
            'finish' => route('finish'),
        ];
        $emptyQuestion = Question::getEmptyQuestionModel();

        return view('main', compact('routes', 'isIndex', 'emptyQuestion'));
    }

    public function destroy(): JsonResponse
    {
        $sessionId = session()->getId();
        Redis::del($sessionId);

        return response()->json(['success' => true]);
    }

    public function questionStore(Request $request): JsonResponse
    {
        $sessionId = session()->getId();
        $questionData = $request->post('questionData');
        $existingData = Redis::get($sessionId);

        if (!is_null($existingData)) {
            $questions = json_decode($existingData, true);
            $questions[] = json_decode($questionData, true);
        } else {
            $questions = json_decode($questionData, true);
            $questions = [$questions];
        }

        Redis::set($sessionId, json_encode($questions));

        return response()->json(['success' => true]);
    }

    public function answerStore(Request $request, int $questionId): JsonResponse
    {
        $sessionId = session()->getId();
        $redisKey = $this->getRedisKey($questionId, $sessionId);
        $answerData = $request->post('answerData');

        Redis::set($redisKey, $answerData);

        return response()->json(['success' => true]);
    }

    public function finish(): JsonResponse
    {
        $sessionId = session()->getId();
        $questions = Question::getQuestions();
        $answerDataArray = [];

        foreach ($questions as $question) {
            $redisKey = $this->getRedisKey($question['id'], $sessionId);
            $answerDataArray[] = json_decode(Redis::get($redisKey), true);
            Redis::del($redisKey);
        }

        $introvertScoreSum = collect($answerDataArray)->sum('introvertScore');
        $introvertPercent = ($introvertScoreSum / (count($questions) * 3) * 100);

        return response()->json(['success' => true, 'introvertPercent' => $this->roundUpToFiveOrZero($introvertPercent) . '%']);
    }

    private function getRedisKey(int $questionId, string $sessionId): string
    {
        return str_replace('QUESTION', $questionId, str_replace('SESSION', $sessionId, self::REDIS_KEY_TEMPLATE));
    }

    private function roundUpToFiveOrZero(float $n): int
    {
        return (round($n) % 5 === 0) ? round($n) : round(($n + 5 / 2) / 5) * 5;
    }
}
