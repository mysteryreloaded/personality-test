<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;

/**
 * App\Models\Question
 *
 * @property int $id
 * @property string $name
 * @property Answer[]|Collection $answers
 */
class Question extends Model
{
    protected $fillable = ['id', 'name', 'answers'];

    public static function getQuestions(): Collection
    {
        $sessionId = session()->getId();
        $questions = Redis::get($sessionId);

        if (empty($questions)) {
            return self::getDefaultQuestions();
        } else {
            return collect(json_decode($questions, true));
        }
    }

    public static function getEmptyQuestionModel(): Question
    {
        $questions = collect(json_decode(Redis::get(session()->getId()), true));
        $id = 1;

        if ($questions->count() > 0) {
            $id = $questions->max('id') + 1;
        }

        return new Question(
            [
                'id' => $id,
                'name' => '',
                'answers' => collect(
                    [
                        new Answer(
                            [
                                'id' => 1,
                                'name' => '',
                                'selected' => false,
                                'introvertScore' => '',
                            ]
                        ),
                        new Answer(
                            [
                                'id' => 2,
                                'name' => '',
                                'selected' => false,
                                'introvertScore' => '',
                            ]
                        ),
                        new Answer(
                            [
                                'id' => 3,
                                'name' => '',
                                'selected' => false,
                                'introvertScore' => '',
                            ]
                        ),
                        new Answer(
                            [
                                'id' => 4,
                                'name' => '',
                                'selected' => false,
                                'introvertScore' => '',
                            ]
                        ),
                    ],
                ),
            ]
        );
    }

    public static function getDefaultQuestions(): Collection
    {
        return collect(
            [
                [
                    "id" => 1,
                    "name" => "You’re really busy at work and a colleague is telling you their life story and personal woes. You:",
                    "answers" => [
                        [
                            "id" => 1,
                            "name" => "Don’t dare to interrupt them",
                            "introvertScore" => 0,
                            "selected" => false,
                        ],
                        [
                            "id" => 2,
                            "name" => "Think it’s more important to give them some of your time; work can wait",
                            "introvertScore" => 1,
                            "selected" => false,
                        ],
                        [
                            "id" => 3,
                            "name" => "Listen, but with only with half an ear",
                            "introvertScore" => 2,
                            "selected" => false,
                        ],
                        [
                            "id" => 4,
                            "name" => "Interrupt and explain that you are really busy at the moment",
                            "introvertScore" => 3,
                            "selected" => false,
                        ],
                    ],
                ],
                [
                    "id" => 2,
                    "name" => "During dinner parties at your home, you have a hard time with people who:",
                    "answers" => [
                        [
                            "id" => 1,
                            "name" => "Ask you to tell a story in front of everyone else",
                            "introvertScore" => 2,
                            "selected" => false,
                        ],
                        [
                            "id" => 2,
                            "name" => "Talk privately between themselves",
                            "introvertScore" => 0,
                            "selected" => false,
                        ],
                        [
                            "id" => 3,
                            "name" => "Hang around you all evening",
                            "introvertScore" => 3,
                            "selected" => false,
                        ],
                        [
                            "id" => 4,
                            "name" => "Always drag the conversation back to themselves",
                            "introvertScore" => 1,
                            "selected" => false,
                        ],
                    ],
                ],
                [
                    "id" => 3,
                    "name" => "You crack a joke at work, but nobody seems to have noticed. You:",
                    "answers" => [
                        [
                            "id" => 1,
                            "name" => "Think it’s for the best — it was a lame joke anyway",
                            "introvertScore" => 3,
                            "selected" => false,
                        ],
                        [
                            "id" => 2,
                            "name" => "Wait to share it with your friends after work",
                            "introvertScore" => 1,
                            "selected" => false,
                        ],
                        [
                            "id" => 3,
                            "name" => "Try again a bit later with one of your colleagues",
                            "introvertScore" => 2,
                            "selected" => false,
                        ],
                        [
                            "id" => 4,
                            "name" => "Keep telling it until they pay attention",
                            "introvertScore" => 0,
                            "selected" => false,
                        ],
                    ],
                ],
                [
                    "id" => 4,
                    "name" => "During dinner, the discussion moves to a subject about which you know nothing at all. You:",
                    "answers" => [
                        [
                            "id" => 1,
                            "name" => "Don’t dare show that you don’t know anything about the subject",
                            "introvertScore" => 0,
                            "selected" => false,
                        ],
                        [
                            "id" => 2,
                            "name" => "Barely follow the discussion",
                            "introvertScore" => 3,
                            "selected" => false,
                        ],
                        [
                            "id" => 3,
                            "name" => "Ask lots of questions to learn more about it",
                            "introvertScore" => 1,
                            "selected" => false,
                        ],
                        [
                            "id" => 4,
                            "name" => "Change the subject of discussion",
                            "introvertScore" => 2,
                            "selected" => false,
                        ],
                    ],
                ],
                [
                    "id" => 5,
                    "name" => "At work, somebody asks for your help for the hundredth time. You:",
                    "answers" => [
                        [
                            "id" => 1,
                            "name" => "Give them a hand, as usual",
                            "introvertScore" => 0,
                            "selected" => false,
                        ],
                        [
                            "id" => 2,
                            "name" => "Accept — you’re known for being helpful",
                            "introvertScore" => 1,
                            "selected" => false,
                        ],
                        [
                            "id" => 3,
                            "name" => "Ask them, please, to find somebody else for a change",
                            "introvertScore" => 2,
                            "selected" => false,
                        ],
                        [
                            "id" => 4,
                            "name" => "Loudly make it known that you’re annoyed",
                            "introvertScore" => 3,
                            "selected" => false,
                        ],
                    ],
                ]
            ]
        );
    }
}
