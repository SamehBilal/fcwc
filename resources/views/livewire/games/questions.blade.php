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
    public $totalQuestions = 10;
    public $answerSubmitted = false;
    public $correctOption = '';
    public $selectedOptionId = '';
    public $hasPlayedBefore = false;
    public $previousScore = null;

    // Updated mount method
    public function mount()
    {
        $this->checkIfUserHasPlayed();

        if (!$this->hasPlayedBefore) {
            $this->initializeQuestions();
            $this->startQuiz();
        }
    }

    public function checkIfUserHasPlayed()
    {
        $existingRecord = GameUser::where('user_id', auth()->user()->id)->where('game_id', 1)->first();

        if ($existingRecord) {
            $this->hasPlayedBefore = true;
            $this->previousScore = $existingRecord->score;
            $this->showScoreModal = true;
            $this->gameEnded = true; // Add this line to prevent quiz UI from showing
        }
    }

    public function initializeQuestions()
    {
        $this->questions = [
            [
                'question' => 'كم عدد الدول المستضيفة لكأس العالم 2026؟',
                'optionA' => 'دولة واحدة',
                'optionB' => 'دولتان',
                'optionC' => 'ثلاث دول',
                'optionD' => 'أربع دول',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'ما هي الدول المستضيفة لكأس العالم 2026؟',
                'optionA' => 'الولايات المتحدة وكندا والمكسيك',
                'optionB' => 'الولايات المتحدة فقط',
                'optionC' => 'المكسيك والبرازيل',
                'optionD' => 'كندا والولايات المتحدة',
                'correctOption' => 'optionA',
            ],
            [
                'question' => 'كم عدد المنتخبات المشاركة في كأس العالم 2026؟',
                'optionA' => '32 منتخبًا',
                'optionB' => '40 منتخبًا',
                'optionC' => '48 منتخبًا',
                'optionD' => '64 منتخبًا',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'كم عدد المباريات في كأس العالم 2026؟',
                'optionA' => '64 مباراة',
                'optionB' => '80 مباراة',
                'optionC' => '104 مباراة',
                'optionD' => '128 مباراة',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'متى تنطلق بطولة كأس العالم 2026؟',
                'optionA' => '11 يونيو 2026',
                'optionB' => '1 يوليو 2026',
                'optionC' => '20 مايو 2026',
                'optionD' => '11 يوليو 2026',
                'correctOption' => 'optionA',
            ],
            [
                'question' => 'متى تُقام المباراة النهائية لكأس العالم 2026؟',
                'optionA' => '1 يوليو 2026',
                'optionB' => '19 يوليو 2026',
                'optionC' => '30 يونيو 2026',
                'optionD' => '19 يونيو 2026',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'كم عدد المدن المستضيفة للبطولة؟',
                'optionA' => '12 مدينة',
                'optionB' => '14 مدينة',
                'optionC' => '16 مدينة',
                'optionD' => '18 مدينة',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'كم عدد المدن الأمريكية المستضيفة للبطولة؟',
                'optionA' => '9 مدن',
                'optionB' => '10 مدن',
                'optionC' => '11 مدينة',
                'optionD' => '12 مدينة',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'كم عدد المدن المكسيكية المستضيفة للبطولة؟',
                'optionA' => 'مدينتان',
                'optionB' => '3 مدن',
                'optionC' => '4 مدن',
                'optionD' => '5 مدن',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'كم عدد المدن الكندية المستضيفة للبطولة؟',
                'optionA' => 'مدينة واحدة',
                'optionB' => 'مدينتان',
                'optionC' => '3 مدن',
                'optionD' => '4 مدن',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'أين تُقام المباراة الافتتاحية لكأس العالم 2026؟',
                'optionA' => 'ملعب ميت لايف',
                'optionB' => 'استاد أزتيكا في مكسيكو سيتي',
                'optionC' => 'ملعب سوفي في لوس أنجلوس',
                'optionD' => 'ملعب AT&T في دالاس',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'أين تُقام المباراة النهائية لكأس العالم 2026؟',
                'optionA' => 'استاد أزتيكا',
                'optionB' => 'ملعب سوفي',
                'optionC' => 'ملعب ميت لايف في نيويورك/نيوجيرسي',
                'optionD' => 'ملعب جيليت',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'كم عدد المجموعات في كأس العالم 2026؟',
                'optionA' => '8 مجموعات',
                'optionB' => '10 مجموعات',
                'optionC' => '12 مجموعة',
                'optionD' => '16 مجموعة',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'كم عدد الفرق في كل مجموعة؟',
                'optionA' => '3 فرق',
                'optionB' => '4 فرق',
                'optionC' => '5 فرق',
                'optionD' => '6 فرق',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'كم عدد المنتخبات التي تتأهل من دور المجموعات؟',
                'optionA' => '16 منتخبًا',
                'optionB' => '24 منتخبًا',
                'optionC' => '32 منتخبًا',
                'optionD' => '48 منتخبًا',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'ما هو الدور الجديد الذي استُحدث في كأس العالم 2026؟',
                'optionA' => 'دور الـ32',
                'optionB' => 'دور الـ24',
                'optionC' => 'الدور التمهيدي',
                'optionD' => 'دور الـ12',
                'correctOption' => 'optionA',
            ],
            [
                'question' => 'كم مباراة يحتاج المنتخب للفوز باللقب من دور المجموعات حتى النهائي؟',
                'optionA' => '6 مباريات',
                'optionB' => '7 مباريات',
                'optionC' => '8 مباريات',
                'optionD' => '9 مباريات',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'كم عدد مباريات دور المجموعات في كأس العالم 2026؟',
                'optionA' => '48 مباراة',
                'optionB' => '64 مباراة',
                'optionC' => '72 مباراة',
                'optionD' => '80 مباراة',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'كم يومًا تستمر بطولة كأس العالم 2026؟',
                'optionA' => '30 يومًا',
                'optionB' => '32 يومًا',
                'optionC' => '39 يومًا',
                'optionD' => '45 يومًا',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'أين أُجريت القرعة النهائية لكأس العالم 2026؟',
                'optionA' => 'زيورخ',
                'optionB' => 'واشنطن العاصمة',
                'optionC' => 'نيويورك',
                'optionD' => 'مكسيكو سيتي',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'متى أُجريت القرعة النهائية لكأس العالم 2026؟',
                'optionA' => 'ديسمبر 2025',
                'optionB' => 'يناير 2026',
                'optionC' => 'مارس 2026',
                'optionD' => 'أكتوبر 2025',
                'correctOption' => 'optionA',
            ],
            [
                'question' => 'متى استضافت الولايات المتحدة كأس العالم لآخر مرة قبل 2026؟',
                'optionA' => '1986',
                'optionB' => '1990',
                'optionC' => '1994',
                'optionD' => '1998',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'من فاز بكأس العالم 1994 التي أقيمت في الولايات المتحدة؟',
                'optionA' => 'البرازيل',
                'optionB' => 'إيطاليا',
                'optionC' => 'ألمانيا',
                'optionD' => 'الأرجنتين',
                'correctOption' => 'optionA',
            ],
            [
                'question' => 'أي المنتخبات تتأهل تلقائيًا لكأس العالم 2026 لكونها مستضيفة؟',
                'optionA' => 'البرازيل والأرجنتين',
                'optionB' => 'الولايات المتحدة وكندا والمكسيك',
                'optionC' => 'إنجلترا وفرنسا',
                'optionD' => 'المكسيك فقط',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'من هو حامل لقب كأس العالم الحالي (2022)؟',
                'optionA' => 'فرنسا',
                'optionB' => 'البرازيل',
                'optionC' => 'الأرجنتين',
                'optionD' => 'ألمانيا',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'أي اتحاد قاري لديه أكبر عدد من المقاعد في كأس العالم 2026؟',
                'optionA' => 'الكاف (أفريقيا)',
                'optionB' => 'اليويفا (أوروبا)',
                'optionC' => 'كونمبول (أمريكا الجنوبية)',
                'optionD' => 'الاتحاد الآسيوي',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'كم عدد المقاعد المخصصة لأفريقيا (الكاف) في كأس العالم 2026؟',
                'optionA' => '5 مقاعد',
                'optionB' => '7 مقاعد',
                'optionC' => '9 مقاعد',
                'optionD' => '12 مقعدًا',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'كم عدد المقاعد المخصصة لأوروبا (اليويفا)؟',
                'optionA' => '13 مقعدًا',
                'optionB' => '14 مقعدًا',
                'optionC' => '16 مقعدًا',
                'optionD' => '18 مقعدًا',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'كم عدد المقاعد المخصصة لآسيا (AFC)؟',
                'optionA' => '4 مقاعد',
                'optionB' => '6 مقاعد',
                'optionC' => '8 مقاعد',
                'optionD' => '10 مقاعد',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'كم عدد المنتخبات العربية المتأهلة لكأس العالم 2026؟',
                'optionA' => '4 منتخبات',
                'optionB' => '5 منتخبات',
                'optionC' => '6 منتخبات',
                'optionD' => '7 منتخبات',
                'correctOption' => 'optionD',
            ],
            [
                'question' => 'أي منتخب عربي يشارك في نهائيات كأس العالم لأول مرة في تاريخه عام 2026؟',
                'optionA' => 'الأردن',
                'optionB' => 'قطر',
                'optionC' => 'السعودية',
                'optionD' => 'المغرب',
                'correctOption' => 'optionA',
            ],
            [
                'question' => 'أي منتخب عربي وصل إلى نصف نهائي كأس العالم 2022؟',
                'optionA' => 'السعودية',
                'optionB' => 'المغرب',
                'optionC' => 'تونس',
                'optionD' => 'قطر',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'أي منتخب عربي استضاف كأس العالم 2022؟',
                'optionA' => 'السعودية',
                'optionB' => 'الإمارات',
                'optionC' => 'قطر',
                'optionD' => 'مصر',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'في أي مجموعة وُضع منتخب المكسيك في قرعة كأس العالم 2026؟',
                'optionA' => 'المجموعة A',
                'optionB' => 'المجموعة B',
                'optionC' => 'المجموعة C',
                'optionD' => 'المجموعة D',
                'correctOption' => 'optionA',
            ],
            [
                'question' => 'في أي مجموعة وُضع منتخب الولايات المتحدة في قرعة كأس العالم 2026؟',
                'optionA' => 'المجموعة A',
                'optionB' => 'المجموعة B',
                'optionC' => 'المجموعة C',
                'optionD' => 'المجموعة D',
                'correctOption' => 'optionD',
            ],
            [
                'question' => 'منتخب نيوزيلندا تأهل لكأس العالم 2026 من أي اتحاد قاري؟',
                'optionA' => 'الاتحاد الآسيوي',
                'optionB' => 'اتحاد أوقيانوسيا (OFC)',
                'optionC' => 'الكاف',
                'optionD' => 'كونمبول',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'كم كان عدد المنتخبات المشاركة في النسخ السابقة قبل توسعة 2026؟',
                'optionA' => '24 منتخبًا',
                'optionB' => '28 منتخبًا',
                'optionC' => '32 منتخبًا',
                'optionD' => '40 منتخبًا',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'أي مدينة أمريكية تستضيف إحدى مباراتي نصف النهائي؟',
                'optionA' => 'دالاس',
                'optionB' => 'ميامي',
                'optionC' => 'سياتل',
                'optionD' => 'بوسطن',
                'correctOption' => 'optionA',
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

        // Mark user as having played to prevent future attempts
        $this->hasPlayedBefore = true;
        $this->previousScore = $this->playerScore;
    }

    public function saveQuizResult()
    {
        /* dd($this->playerScore); */
        try {
            // Check if record already exists to prevent duplicates
            $existingRecord = GameUser::where('user_id', auth()->user()->id)->where('game_id', 1)->first();

            if (!$existingRecord) {
                GameUser::create([
                    'user_id' => auth()->user()->id,
                    'game_id' => 1,
                    'score' => $this->playerScore,
                    'completed_at' => now(), // Add timestamp if you have this column
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Failed to save quiz result: ' . $e->getMessage());
            // You might want to show an error message to the user
            session()->flash('error', 'Failed to save your score. Please try again.');
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
            return ['text' => 'درجات سيئة، واصل التدريب.', 'color' => 'text-red-600'];
        } elseif ($percentage >= 26 && $percentage < 58) {
            return ['text' => 'درجات متوسطة، يمكنك أن تقدم أداءً أفضل.', 'color' => 'text-orange-600'];
        } else {
            return ['text' => 'ممتاز، استمر في العمل الجيد.', 'color' => 'text-green-600'];
        }
    }

    public function resetQuiz()
    {
        // Prevent reset if user has already played
        if ($this->hasPlayedBefore) {
            return;
        }

        // Only allow reset if game hasn't been completed and saved
        $existingRecord = GameUser::where('user_id', auth()->user()->id)->where('game_id', 1)->first();
        if ($existingRecord) {
            $this->hasPlayedBefore = true;
            $this->previousScore = $existingRecord->score;
            $this->showScoreModal = true;
            return;
        }

        // Reset quiz state
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

    public function hydrate()
    {
        // This runs after every request, including page refreshes
        $this->checkIfUserHasPlayed();
    }

    public function redirectToStandings()
    {
        return $this->redirect(route('dashboard'), navigate: true);
    }
}; ?>

<div dir="rtl">

    <h1 class="title text-right">FIFA World Cup 2026 Questions</h1>
    
    <!-- Score Modal -->
    @if ($showScoreModal)
        <div class="fixed inset-0 custom-bg backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div
                class="custom-bg border border-gray-700 rounded-xl shadow-2xl p-6 max-w-sm w-full mx-4 transform transition-all duration-300 scale-100">
                <div class="text-center">
                    <div
                        class="mx-auto w-12 h-12 bg-green-500/10 border border-green-500/20 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>

                    <h1 class="text-lg font-semibold text-white mb-6">
                        @if ($hasPlayedBefore)
                            تم إكمال الاختبار بالفعل!
                        @else
                            تم إكمال الاختبار!
                        @endif
                    </h1>

                    <div class="grid grid-cols-2 gap-3 mb-6">
                        <div class="bg-gray-700/50 border border-gray-600 rounded-lg p-3">
                            <div class="text-lg font-semibold text-white">{{ $totalQuestions }}</div>
                            <div class="text-sm text-gray-400">الأسئلة</div>
                        </div>
                        <div class="bg-green-500/10 border border-green-500/20 rounded-lg p-3">
                            <div class="text-lg font-semibold text-green-400">
                                {{ $hasPlayedBefore ? $previousScore : $playerScore }}</div>
                            <div class="text-sm text-green-400/70">صحيح</div>
                        </div>
                        <div class="bg-red-500/10 border border-red-500/20 rounded-lg p-3">
                            <div class="text-lg font-semibold text-red-400">
                                {{ $hasPlayedBefore ? $totalQuestions - $previousScore : $wrongAttempt }}</div>
                            <div class="text-sm text-red-400/70">خطأ</div>
                        </div>
                        <div class="bg-white/10 border border-white/20 rounded-lg p-3">
                            <div class="text-lg font-semibold text-white">{{ $this->getGradePercentage() }}%</div>
                            <div class="text-sm text-gray-300">النقاط</div>
                        </div>
                    </div>

                    <div class="mb-6">
                        {{-- <p
                            class="text-sm font-medium text-gray-300 bg-gray-700/50 rounded-lg p-3 border border-gray-600 text-right">
                            {{ $this->getRemark()['text'] }}
                        </p> --}}

                        @if ($hasPlayedBefore)
                            <p class="text-sm text-gray-400 mt-3 text-right">
                                لقد أكملت هذا الاختبار بالفعل. يمكن لكل لاعب أن يأخذ الاختبار مرة واحدة فقط.
                            </p>
                        @endif
                    </div>

                    <!-- Updated button logic -->
                    <div class="flex gap-3">
                        @if (!$hasPlayedBefore && !$gameEnded)
                            <button wire:click="resetQuiz"
                                class="flex-1 bg-white cursor-pointer hover:bg-gray-100 text-gray-900 px-4 py-2 rounded-lg font-medium transition-colors">
                                أعد المحاولة
                            </button>
                        @endif

                        <button wire:click="redirectToStandings"
                            class="flex-1 bg-gray-700 cursor-pointer hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            ترتيب اللاعبين
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Option Warning Modal -->
    @if ($showOptionModal)
        <div class="fixed inset-0 custom-bg backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div
                class="custom-bg border border-gray-700 rounded-xl shadow-2xl p-6 max-w-sm w-full mx-4 transform transition-all duration-300 scale-100">
                <div class="text-center">
                    <div
                        class="mx-auto w-12 h-12 bg-amber-500/10 border border-amber-500/20 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z">
                            </path>
                        </svg>
                    </div>

                    <h1 class="text-lg font-semibold text-white mb-3 ">
                        يرجى اختيار إجابة
                    </h1>

                    <p class="text-gray-300 mb-4">تحتاج إلى اختيار خيار قبل المتابعة.</p>

                    <button wire:click="closeOptionModal"
                        class="w-full custom-bg hover:bg-gray-600 cursor-pointer text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        المتابعة
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Quiz Container -->
    @if (!$hasPlayedBefore && !$gameEnded)
        <div class="max-w-2xl mx-auto mt-10 p-10">
            <div class="custom-bg border border-gold-700 rounded-lg shadow-xl overflow-hidden">
                <!-- Quiz Header -->
                <div class="custom-bg border-b border-gray-700 p-4">
                    <div class="flex justify-between items-center gap-4 flex-row-reverse">
                        <!-- Score section (now on the right) -->
                        <div class="flex items-center gap-3 flex-row-reverse">
                            <div>
                                <div class="text-lg font-semibold text-white text-right">{{ $playerScore }}</div>
                                <div class="text-xs text-gray-400 text-right">النقاط</div>
                            </div>
                            <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                            </div>
                        </div>

                        <!-- Progress section (now on the left) -->
                        <div class="flex items-center gap-3 flex-row-reverse">
                            <div>
                                <div class="text-lg font-semibold text-white text-right">{{ $questionNumber }} /
                                    {{ $totalQuestions }}</div>
                                <div class="text-xs text-gray-400 text-right">التقدم</div>
                            </div>
                            <div class="w-8 h-8 bg-gray-700 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mt-3">
                        <div class="w-full bg-gray-700 rounded-full h-1.5">
                            <div class="bg-white h-1.5 rounded-full transition-all duration-300"
                                style="width: {{ ($questionNumber / $totalQuestions) * 100 }}%; margin-right: auto; margin-left: 0;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Question Container -->
                <div class="p-4 text-center">
                    @if (!empty($currentQuestion))
                        <div class="mb-6">
                            <div class="custom-bg rounded-lg p-4 border border-gray-600 mb-4">
                                <h2 class="text-base font-medium text-white leading-relaxed text-right">
                                    {{ $currentQuestion['question'] }}
                                </h2>
                            </div>

                            <!-- Options - 2 per row with enhanced selection styling -->
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
                                        $isSelectedBeforeSubmit = !$answerSubmitted && $selectedAnswer === $optionKey;
                                    @endphp

                                    <label
                                        class="block cursor-pointer transform transition-all duration-200 hover:scale-[1.02]"
                                        for="option-{{ strtolower($option) }}">
                                        <div
                                            class="flex items-center p-3 rounded-lg border-2 transition-all duration-300 shadow-sm flex-row-reverse
    @if ($isCorrect) border-green-500 bg-green-500/20 shadow-green-500/20
    @elseif($isWrong) border-red-500 bg-red-500/20 shadow-red-500/20
    @elseif($isSelectedBeforeSubmit) border-blue-500 bg-blue-500/20 shadow-blue-500/30 shadow-lg transform scale-[1.02]
    @else border-gray-600 custom-bg hover:border-gray-500 hover:bg-gray-700/30 @endif">

                                            <!-- Move status icons to the left -->
                                            <div class="mr-2 ml-0">
                                                @if ($isCorrect)
                                                    <div
                                                        class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center shadow-md animate-pulse">
                                                        <svg class="w-4 h-4 text-white" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </div>
                                                @elseif($isWrong)
                                                    <div
                                                        class="w-6 h-6 bg-red-500 rounded-full flex items-center justify-center shadow-md animate-pulse">
                                                        <svg class="w-4 h-4 text-white" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </div>
                                                @elseif($isSelectedBeforeSubmit)
                                                    <div
                                                        class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center shadow-md border-2 border-blue-300">
                                                        <div class="w-2.5 h-2.5 bg-white rounded-full animate-pulse">
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="flex items-center flex-1 flex-row-reverse">
                                                <span
                                                    class="text-sm font-medium flex-1 transition-all duration-300 text-right mr-3 mr-0
            @if ($isCorrect) text-green-300 font-semibold
            @elseif($isWrong) text-red-300 font-semibold
            @elseif($isSelectedBeforeSubmit) text-blue-200 font-semibold
            @else text-gray-200 @endif">
                                                    {{ $currentQuestion[$optionKey] }}
                                                </span>

                                                <div
                                                    class="flex items-center justify-center w-7 h-7 rounded-full ml-0 mr-3 font-bold text-sm transition-all duration-300
            @if ($isCorrect) bg-green-500 text-white shadow-md
            @elseif($isWrong) bg-red-500 text-white shadow-md
            @elseif($isSelectedBeforeSubmit) bg-blue-500 text-white shadow-md
            @else bg-gray-600 text-gray-300 @endif">
                                                    {{ $option }}
                                                </div>

                                                <input type="radio" id="option-{{ strtolower($option) }}"
                                                    wire:model.live="selectedAnswer" value="{{ $optionKey }}"
                                                    class="sr-only" {{ $answerSubmitted ? 'disabled' : '' }}>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Next Button -->
                        <button wire:click="nextQuestion"
                            class="inline-flex items-center gap-2 cursor-pointer bg-white hover:bg-gray-100 text-gray-900 px-6 py-3 rounded-lg font-medium transition-all duration-200 transform hover:scale-105 shadow-lg flex-row-reverse">
                            <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                            <span>{{ $answerSubmitted ? ($indexNumber + 1 >= $totalQuestions ? 'إنهاء الاختبار' : 'السؤال التالي') : 'إرسال الإجابة' }}</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @elseif($hasPlayedBefore)
        <!-- Show message for users who have already completed -->
        <div class="max-w-2xl mx-auto mt-10 p-10">
            <div class="custom-bg border border-gray-700 rounded-lg shadow-xl p-8 text-center">
                <div
                    class="mx-auto w-16 h-16 bg-blue-500/10 border border-blue-500/20 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-white mb-2 text-right">تم إكمال الاختبار بالفعل</h2>
                <p class="text-gray-400 mb-4 text-right">لقد أكملت هذا الاختبار بالفعل وحصلت على نقاط
                    {{ $previousScore }}/{{ $totalQuestions }}.</p>
                <button onclick="window.history.back()"
                    class="bg-white hover:bg-gray-100 text-gray-900 px-6 py-2 rounded-lg font-medium transition-colors">
                    العودة
                </button>
            </div>
        </div>
    @endif
</div>
