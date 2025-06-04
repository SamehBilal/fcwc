<?php

use Livewire\Volt\Component;
use App\Models\GameUser;

new class extends Component {
    public $questions = [];
    public $shuffledQuestions = [];
    public $currentQuestion = [];
    public $selectedAnswer = '';
    public $questionNumber = 1;
    public $playerScore = 0;
    public $wrongAttempt = 0;
    public $indexNumber = 0;
    public $showScoreModal = false;
    public $showOptionModal = false;
    public $gameEnded = false;
    public $totalQuestions = 2;
    public $answerSubmitted = false;
    public $correctOption = '';
    public $selectedOptionId = '';
    public $hasPlayedBefore = false;
    public $previousScore = null;

    public function mount()
    {
        $this->checkIfUserHasPlayed();

        //dd(GameUser::all());

        if (!$this->hasPlayedBefore) {
            $this->initializeQuestions();
            $this->startQuiz();
        }
    }

    public function checkIfUserHasPlayed()
    {
        $existingRecord = GameUser::where('player_id', 1)->where('game_id', 1)->first();

        if ($existingRecord) {
            $this->hasPlayedBefore = true;
            $this->previousScore = $existingRecord->score;
            $this->showScoreModal = true;
        }
    }

    public function initializeQuestions()
    {
        $this->questions = [
            [
                'question' => 'How many days makes a week?',
                'optionA' => '10 days',
                'optionB' => '14 days',
                'optionC' => '5 days',
                'optionD' => '7 days',
                'correctOption' => 'optionD',
            ],
            [
                'question' => 'How many players are allowed on a soccer pitch?',
                'optionA' => '10 players',
                'optionB' => '11 players',
                'optionC' => '9 players',
                'optionD' => '12 players',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'Who was the first President of USA?',
                'optionA' => 'Donald Trump',
                'optionB' => 'Barack Obama',
                'optionC' => 'Abraham Lincoln',
                'optionD' => 'George Washington',
                'correctOption' => 'optionD',
            ],
            [
                'question' => '30 days has ______?',
                'optionA' => 'January',
                'optionB' => 'December',
                'optionC' => 'June',
                'optionD' => 'August',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'How many hours can be found in a day?',
                'optionA' => '30 hours',
                'optionB' => '38 hours',
                'optionC' => '48 hours',
                'optionD' => '24 hours',
                'correctOption' => 'optionD',
            ],
            [
                'question' => 'Which is the longest river in the world?',
                'optionA' => 'River Nile',
                'optionB' => 'Long River',
                'optionC' => 'River Niger',
                'optionD' => 'Lake Chad',
                'correctOption' => 'optionA',
            ],
            [
                'question' => '_____ is the hottest Continent on Earth?',
                'optionA' => 'Oceania',
                'optionB' => 'Antarctica',
                'optionC' => 'Africa',
                'optionD' => 'North America',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'Which country is the largest in the world?',
                'optionA' => 'Russia',
                'optionB' => 'Canada',
                'optionC' => 'Africa',
                'optionD' => 'Egypt',
                'correctOption' => 'optionA',
            ],
            [
                'question' => 'Which of these numbers is an odd number?',
                'optionA' => 'Ten',
                'optionB' => 'Twelve',
                'optionC' => 'Eight',
                'optionD' => 'Eleven',
                'correctOption' => 'optionD',
            ],
            [
                'question' => '"You Can\'t see me" is a popular saying by',
                'optionA' => 'Eminem',
                'optionB' => 'Bill Gates',
                'optionC' => 'Chris Brown',
                'optionD' => 'John Cena',
                'correctOption' => 'optionD',
            ],
            [
                'question' => 'Where is the world tallest building located?',
                'optionA' => 'Africa',
                'optionB' => 'California',
                'optionC' => 'Dubai',
                'optionD' => 'Italy',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'The longest river in the United Kingdom is?',
                'optionA' => 'River Severn',
                'optionB' => 'River Mersey',
                'optionC' => 'River Trent',
                'optionD' => 'River Tweed',
                'correctOption' => 'optionA',
            ],
            [
                'question' => 'How many permanent teeth does a dog have?',
                'optionA' => '38',
                'optionB' => '42',
                'optionC' => '40',
                'optionD' => '36',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'Which national team won the football World cup in 2018?',
                'optionA' => 'England',
                'optionB' => 'Brazil',
                'optionC' => 'Germany',
                'optionD' => 'France',
                'correctOption' => 'optionD',
            ],
            [
                'question' => 'Which US state was Donald Trump Born?',
                'optionA' => 'New York',
                'optionB' => 'California',
                'optionC' => 'New Jersey',
                'optionD' => 'Los Angeles',
                'correctOption' => 'optionA',
            ],
            [
                'question' => 'How many states does Nigeria have?',
                'optionA' => '24',
                'optionB' => '30',
                'optionC' => '36',
                'optionD' => '37',
                'correctOption' => 'optionC',
            ],
            [
                'question' => '____ is the capital of Nigeria?',
                'optionA' => 'Abuja',
                'optionB' => 'Lagos',
                'optionC' => 'Calabar',
                'optionD' => 'Kano',
                'correctOption' => 'optionA',
            ],
            [
                'question' => 'Los Angeles is also known as?',
                'optionA' => 'Angels City',
                'optionB' => 'Shining city',
                'optionC' => 'City of Angels',
                'optionD' => 'Lost Angels',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'What is the capital of Germany?',
                'optionA' => 'Georgia',
                'optionB' => 'Missouri',
                'optionC' => 'Oklahoma',
                'optionD' => 'Berlin',
                'correctOption' => 'optionD',
            ],
            [
                'question' => 'How many sides does a hexagon have?',
                'optionA' => 'Six',
                'optionB' => 'Seven',
                'optionC' => 'Four',
                'optionD' => 'Five',
                'correctOption' => 'optionA',
            ],
            [
                'question' => 'How many planets are currently in the solar system?',
                'optionA' => 'Eleven',
                'optionB' => 'Seven',
                'optionC' => 'Nine',
                'optionD' => 'Eight',
                'correctOption' => 'optionD',
            ],
            [
                'question' => 'Which Planet is the hottest?',
                'optionA' => 'Jupiter',
                'optionB' => 'Mercury',
                'optionC' => 'Earth',
                'optionD' => 'Venus',
                'correctOption' => 'optionD',
            ],
            [
                'question' => 'Where is the smallest bone in human body located?',
                'optionA' => 'Toes',
                'optionB' => 'Ears',
                'optionC' => 'Fingers',
                'optionD' => 'Nose',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'How many hearts does an Octopus have?',
                'optionA' => 'One',
                'optionB' => 'Two',
                'optionC' => 'Three',
                'optionD' => 'Four',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'How many teeth does an adult human have?',
                'optionA' => '28',
                'optionB' => '30',
                'optionC' => '32',
                'optionD' => '36',
                'correctOption' => 'optionC',
            ],
        ];
    }

    public function startQuiz()
    {
        $this->shuffleQuestions();
        $this->loadCurrentQuestion();
    }

    public function shuffleQuestions()
    {
        $shuffled = collect($this->questions)->shuffle();
        $this->shuffledQuestions = $shuffled->take($this->totalQuestions)->toArray();
    }

    public function loadCurrentQuestion()
    {
        if ($this->indexNumber < count($this->shuffledQuestions)) {
            $this->currentQuestion = $this->shuffledQuestions[$this->indexNumber];
            $this->selectedAnswer = '';
            $this->answerSubmitted = false;
            $this->correctOption = '';
            $this->selectedOptionId = '';
        }
    }

    public function submitAnswer()
    {
        if (empty($this->selectedAnswer)) {
            $this->showOptionModal = true;
            return;
        }

        $this->answerSubmitted = true;
        $this->correctOption = $this->currentQuestion['correctOption'];
        $this->selectedOptionId = $this->selectedAnswer;

        if ($this->selectedAnswer === $this->correctOption) {
            $this->playerScore++;
        } else {
            $this->wrongAttempt++;
        }
    }

    public function nextQuestion()
    {
        if (!$this->answerSubmitted) {
            $this->submitAnswer();
            return;
        }

        $this->indexNumber++;
        $this->questionNumber++;

        if ($this->indexNumber >= $this->totalQuestions) {
            $this->endGame();
        } else {
            $this->loadCurrentQuestion();
        }
    }

    public function endGame()
    {
        $this->gameEnded = true;
        $this->saveQuizResult();
        $this->showScoreModal = true;
    }

    public function saveQuizResult()
    {
        try {
            GameUser::create([
                'player_id' => 1,
                'game_id' => 1,
                'score' => $this->playerScore,
            ]);
        } catch (\Exception $e) {
            // Handle any database errors silently or log them
            \Log::error('Failed to save quiz result: ' . $e->getMessage());
        }
    }

    public function getGradePercentage()
    {
        $score = $this->hasPlayedBefore ? $this->previousScore : $this->playerScore;
        return round(($score / $this->totalQuestions) * 100);
    }

    public function getRemark()
    {
        $percentage = $this->getGradePercentage();

        if ($percentage <= 25) {
            return ['text' => 'Bad Grades, Keep Practicing.', 'color' => 'text-red-600'];
        } elseif ($percentage >= 26 && $percentage < 58) {
            return ['text' => 'Average Grades, You can do better.', 'color' => 'text-orange-600'];
        } else {
            return ['text' => 'Excellent, Keep the good work going.', 'color' => 'text-green-600'];
        }
    }

    public function resetQuiz()
    {
        // Prevent reset if user has already played
        if ($this->hasPlayedBefore) {
            return;
        }

        $this->questionNumber = 1;
        $this->playerScore = 0;
        $this->wrongAttempt = 0;
        $this->indexNumber = 0;
        $this->shuffledQuestions = [];
        $this->currentQuestion = [];
        $this->selectedAnswer = '';
        $this->showScoreModal = false;
        $this->gameEnded = false;
        $this->answerSubmitted = false;
        $this->correctOption = '';
        $this->selectedOptionId = '';

        $this->startQuiz();
    }

    public function closeOptionModal()
    {
        $this->showOptionModal = false;
    }
}; ?>

<div class="min-h-screen">
    @include('partials.settings-heading')

    <!-- Score Modal -->
    @if ($showScoreModal)
        <div class="fixed inset-0 custom-bg backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div class="custom-bg border border-gray-700 rounded-xl shadow-2xl p-6 max-w-sm w-full mx-4 transform transition-all duration-300 scale-100">
                <div class="text-center">
                    <div class="mx-auto w-12 h-12 bg-green-500/10 border border-green-500/20 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>

                    <h1 class="text-lg font-semibold text-white mb-6">
                        @if ($hasPlayedBefore)
                            Quiz Already Completed!
                        @else
                            Quiz Completed!
                        @endif
                    </h1>

                    <div class="grid grid-cols-2 gap-3 mb-6">
                        <div class="bg-gray-700/50 border border-gray-600 rounded-lg p-3">
                            <div class="text-lg font-semibold text-white">{{ $totalQuestions }}</div>
                            <div class="text-sm text-gray-400">Total Questions</div>
                        </div>
                        <div class="bg-green-500/10 border border-green-500/20 rounded-lg p-3">
                            <div class="text-lg font-semibold text-green-400">
                                {{ $hasPlayedBefore ? $previousScore : $playerScore }}</div>
                            <div class="text-sm text-green-400/70">Correct</div>
                        </div>
                        <div class="bg-red-500/10 border border-red-500/20 rounded-lg p-3">
                            <div class="text-lg font-semibold text-red-400">
                                {{ $hasPlayedBefore ? $totalQuestions - $previousScore : $wrongAttempt }}</div>
                            <div class="text-sm text-red-400/70">Incorrect</div>
                        </div>
                        <div class="bg-white/10 border border-white/20 rounded-lg p-3">
                            <div class="text-lg font-semibold text-white">{{ $this->getGradePercentage() }}%</div>
                            <div class="text-sm text-gray-300">Score</div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <p class="text-sm font-medium text-gray-300 bg-gray-700/50 rounded-lg p-3 border border-gray-600">
                            {{ $this->getRemark()['text'] }}
                        </p>

                        @if ($hasPlayedBefore)
                            <p class="text-sm text-gray-400 mt-3">
                                You have already completed this quiz. Each player can only take the quiz once.
                            </p>
                        @endif
                    </div>

                    @if (!$hasPlayedBefore)
                        <button wire:click="resetQuiz"
                            class="w-full bg-white hover:bg-gray-100 text-gray-900 px-4 py-2 rounded-lg font-medium transition-colors">
                            Start New Quiz
                        </button>
                    @else
                        <button onclick="window.history.back()"
                            class="w-full bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            Go Back
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Option Warning Modal -->
    @if ($showOptionModal)
        <div class="fixed inset-0 custom-bg backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div class="custom-bg border border-gray-700 rounded-xl shadow-2xl p-6 max-w-sm w-full mx-4 transform transition-all duration-300 scale-100">
                <div class="text-center">
                    <div class="mx-auto w-12 h-12 bg-amber-500/10 border border-amber-500/20 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z">
                            </path>
                        </svg>
                    </div>

                    <h1 class="text-lg font-semibold text-white mb-3">
                        Please Select an Answer
                    </h1>

                    <p class="text-gray-300 mb-4">You need to choose an option before proceeding.</p>

                    <button wire:click="closeOptionModal"
                        class="w-full custom-bg hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Got it
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Quiz Container -->
    @if (!$hasPlayedBefore)
        <div class="max-w-2xl mx-auto mt-10 p-10">
            <div class="custom-bg border border-gold-700 rounded-lg shadow-xl overflow-hidden">
                <!-- Quiz Header -->
                <div class="custom-bg border-b border-gray-700 p-4">
                    <div class="flex justify-between items-center gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-lg font-semibold text-white">{{ $playerScore }}</div>
                                <div class="text-xs text-gray-400">Score</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gray-700 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-lg font-semibold text-white">{{ $questionNumber }} / {{ $totalQuestions }}</div>
                                <div class="text-xs text-gray-400">Progress</div>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mt-3">
                        <div class="w-full bg-gray-700 rounded-full h-1.5">
                            <div class="bg-white h-1.5 rounded-full transition-all duration-300"
                                style="width: {{ ($questionNumber / $totalQuestions) * 100 }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Question Container -->
                <div class="p-4">
                    @if (!empty($currentQuestion))
                        <div class="mb-6">
                            <div class="custom-bg rounded-lg p-4 border border-gray-600 mb-4">
                                <h2 class="text-base font-medium text-white leading-relaxed">
                                    {{ $currentQuestion['question'] }}
                                </h2>
                            </div>

                            <!-- Options - 2 per row -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach (['A', 'B', 'C', 'D'] as $option)
                                    @php
                                        $optionKey = 'option' . $option;
                                        $isCorrect = $answerSubmitted && $correctOption === $optionKey;
                                        $isSelected = $answerSubmitted && $selectedOptionId === $optionKey;
                                        $isWrong =
                                            $answerSubmitted &&
                                            $selectedOptionId === $optionKey &&
                                            $correctOption !== $optionKey;
                                    @endphp

                                    <label class="block cursor-pointer" for="option-{{ strtolower($option) }}">
                                                                                    <div class="flex items-center p-3 rounded-lg border-2 transition-all duration-200
                                            {{ $isCorrect ? 'border-green-500/50 bg-green-500/10' : '' }}
                                            {{ $isWrong ? 'border-red-500/50 bg-red-500/10' : '' }}
                                            {{ !$answerSubmitted && $selectedAnswer === $optionKey ? 'border-white/70 bg-white/10' : '' }}
                                            {{ !$answerSubmitted && $selectedAnswer !== $optionKey ? 'border-gray-600 custom-bg hover:border-white/50 hover:bg-white/5' : '' }}">

                                            <div class="flex items-center flex-1">
                                                <div class="flex items-center justify-center w-6 h-6 rounded-full mr-3 font-medium text-xs
                                                    {{ $isCorrect ? 'bg-green-500 text-white' : '' }}
                                                    {{ $isWrong ? 'bg-red-500 text-white' : '' }}
                                                    {{ !$answerSubmitted && $selectedAnswer === $optionKey ? 'bg-white text-gray-900' : '' }}
                                                    {{ !$answerSubmitted && $selectedAnswer !== $optionKey ? 'bg-gray-600 text-gray-300' : '' }}">
                                                    {{ $option }}
                                                </div>

                                                <input type="radio" id="option-{{ strtolower($option) }}"
                                                    wire:model="selectedAnswer" value="{{ $optionKey }}"
                                                    class="sr-only" {{ $answerSubmitted ? 'disabled' : '' }}>

                                                <span class="text-sm font-medium flex-1
                                                    {{ $isCorrect ? 'text-green-400' : '' }}
                                                    {{ $isWrong ? 'text-red-400' : '' }}
                                                    {{ !$answerSubmitted && $selectedAnswer === $optionKey ? 'text-white' : '' }}
                                                    {{ !$answerSubmitted && $selectedAnswer !== $optionKey ? 'text-gray-200' : '' }}">
                                                    {{ $currentQuestion[$optionKey] }}
                                                </span>
                                            </div>

                                            <div class="ml-2">
                                                @if ($isCorrect)
                                                    <div class="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center">
                                                        <svg class="w-3 h-3 text-white" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </div>
                                                @elseif($isWrong)
                                                    <div class="w-5 h-5 bg-red-500 rounded-full flex items-center justify-center">
                                                        <svg class="w-3 h-3 text-white" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </div>
                                                @elseif(!$answerSubmitted && $selectedAnswer === $optionKey)
                                                    <div class="w-5 h-5 bg-white rounded-full flex items-center justify-center">
                                                        <div class="w-2 h-2 bg-gray-900 rounded-full"></div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Next Button -->
                        <div class="text-center">
                            <button wire:click="nextQuestion"
                                class="inline-flex items-center gap-2 bg-white hover:bg-gray-100 text-gray-900 px-5 py-2.5 rounded-lg font-medium transition-colors">
                                <span>{{ $answerSubmitted ? ($indexNumber + 1 >= $totalQuestions ? 'Finish Quiz' : 'Next Question') : 'Submit Answer' }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
