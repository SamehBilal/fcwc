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
        $existingRecord = GameUser::where('user_id', auth()->user()->id)
            ->where('game_id', 1)
            ->first();

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
                'optionA' => '5 منتخبات',
                'optionB' => '6 منتخبات',
                'optionC' => '7 منتخبات',
                'optionD' => '8 منتخبات',
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
            [
                'question' => 'ما هو المنتخب الأكثر تتويجًا بكأس العالم عبر التاريخ؟',
                'optionA' => 'ألمانيا',
                'optionB' => 'إيطاليا',
                'optionC' => 'البرازيل',
                'optionD' => 'الأرجنتين',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'من هو الهداف التاريخي لنهائيات كأس العالم؟',
                'optionA' => 'ميروسلاف كلوزه',
                'optionB' => 'رونالدو',
                'optionC' => 'بيليه',
                'optionD' => 'ليونيل ميسي',
                'correctOption' => 'optionA',
            ],
            [
                'question' => 'من سجّل أكبر عدد أهداف في نسخة واحدة من كأس العالم (13 هدفًا عام 1958)؟',
                'optionA' => 'غيرد مولر',
                'optionB' => 'جوست فونتين',
                'optionC' => 'بيليه',
                'optionD' => 'رونالدو',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'كم استغرق تسجيل أسرع هدف في تاريخ كأس العالم؟',
                'optionA' => '11 ثانية',
                'optionB' => '30 ثانية',
                'optionC' => 'دقيقة كاملة',
                'optionD' => '5 ثوانٍ',
                'correctOption' => 'optionA',
            ],
            [
                'question' => 'ما هو المنتخب الوحيد الذي شارك في جميع نسخ كأس العالم؟',
                'optionA' => 'ألمانيا',
                'optionB' => 'إيطاليا',
                'optionC' => 'الأرجنتين',
                'optionD' => 'البرازيل',
                'correctOption' => 'optionD',
            ],
            [
                'question' => 'من هو اللاعب صاحب أكبر عدد مباريات في تاريخ كأس العالم؟',
                'optionA' => 'ليونيل ميسي',
                'optionB' => 'لوثار ماتيوس',
                'optionC' => 'باولو مالديني',
                'optionD' => 'كريستيانو رونالدو',
                'correctOption' => 'optionA',
            ],
            [
                'question' => 'أي منتخب فاز بأول نسخة من كأس العالم عام 1930؟',
                'optionA' => 'البرازيل',
                'optionB' => 'الأوروغواي',
                'optionC' => 'إيطاليا',
                'optionD' => 'الأرجنتين',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'من هو أصغر لاعب سجّل هدفًا في تاريخ كأس العالم؟',
                'optionA' => 'كيليان مبابي',
                'optionB' => 'بيليه',
                'optionC' => 'مايكل أوين',
                'optionD' => 'ليونيل ميسي',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'من سجّل خمسة أهداف في مباراة واحدة بكأس العالم (رقم قياسي)؟',
                'optionA' => 'أوليغ سالينكو',
                'optionB' => 'غابرييل باتيستوتا',
                'optionC' => 'رونالدو',
                'optionD' => 'غاري لينيكر',
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
            $existingRecord = GameUser::where('user_id', auth()->user()->id)
                ->where('game_id', 1)
                ->first();

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
        $existingRecord = GameUser::where('user_id', auth()->user()->id)
            ->where('game_id', 1)
            ->first();
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

    <h1 class="title">FIFA World Cup 2026 Questions</h1>

    {{-- ===== Score Modal ===== --}}
    @if ($showScoreModal)
        <div class="qmodal-overlay">
            <div class="qmodal">
                <div class="qmodal__icon" style="background: rgba(34,197,94,0.12); border: 1px solid rgba(34,197,94,0.3);">
                    <svg class="w-6 h-6" style="color:#4ade80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <h1 class="qmodal__title">
                    {{ $hasPlayedBefore ? 'تم إكمال الاختبار بالفعل!' : 'تم إكمال الاختبار!' }}
                </h1>

                <div class="qmodal__grid">
                    <div class="qmodal__tile">
                        <div class="qmodal__tile-num">{{ $totalQuestions }}</div>
                        <div class="qmodal__tile-label">الأسئلة</div>
                    </div>
                    <div class="qmodal__tile qmodal__tile--correct">
                        <div class="qmodal__tile-num">{{ $hasPlayedBefore ? $previousScore : $playerScore }}</div>
                        <div class="qmodal__tile-label">صحيح</div>
                    </div>
                    <div class="qmodal__tile qmodal__tile--wrong">
                        <div class="qmodal__tile-num">{{ $hasPlayedBefore ? $totalQuestions - $previousScore : $wrongAttempt }}</div>
                        <div class="qmodal__tile-label">خطأ</div>
                    </div>
                    <div class="qmodal__tile qmodal__tile--gold">
                        <div class="qmodal__tile-num">{{ $this->getGradePercentage() }}%</div>
                        <div class="qmodal__tile-label">النقاط</div>
                    </div>
                </div>

                @if ($hasPlayedBefore)
                    <p class="text-sm text-gray-400 mb-4 text-center">
                        لقد أكملت هذا الاختبار بالفعل. يمكن لكل لاعب أن يأخذ الاختبار مرة واحدة فقط.
                    </p>
                @endif

                <div class="qmodal__actions">
                    @if (!$hasPlayedBefore && !$gameEnded)
                        <button wire:click="resetQuiz" class="q-btn" style="flex:1; background:var(--wc-tile);">
                            أعد المحاولة
                        </button>
                    @endif
                    <button wire:click="redirectToStandings" class="q-btn" style="flex:1;">
                        ترتيب اللاعبين
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- ===== Option Warning Modal ===== --}}
    @if ($showOptionModal)
        <div class="qmodal-overlay">
            <div class="qmodal">
                <div class="qmodal__icon" style="background: rgba(252,175,64,0.12); border: 1px solid rgba(252,175,64,0.3);">
                    <svg class="w-6 h-6" style="color:var(--wc-gold)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
                <h1 class="qmodal__title">يرجى اختيار إجابة</h1>
                <p class="text-gray-300 mb-4 text-center">تحتاج إلى اختيار خيار قبل المتابعة.</p>
                <button wire:click="closeOptionModal" class="q-btn" style="width:100%; background:var(--wc-tile);">
                    المتابعة
                </button>
            </div>
        </div>
    @endif

    {{-- ===== Quiz ===== --}}
    @if (!$hasPlayedBefore && !$gameEnded)
        <div class="q-wrap">
            <div class="q-card wc-card">

                {{-- Header --}}
                <div class="q-head">
                    <div class="q-head-row">
                        {{-- Progress (right in RTL) --}}
                        <div class="q-stat">
                            <div class="q-stat__icon">
                                <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <div class="q-stat__num">{{ $questionNumber }} / {{ $totalQuestions }}</div>
                                <div class="q-stat__label">التقدم</div>
                            </div>
                        </div>

                        {{-- Score (left in RTL) --}}
                        <div class="q-stat">
                            <div class="q-stat__icon">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                            <div>
                                <div class="q-stat__num">{{ $playerScore }}</div>
                                <div class="q-stat__label">النقاط</div>
                            </div>
                        </div>
                    </div>

                    <div class="q-progress">
                        <div class="q-progress__bar" style="width: {{ ($questionNumber / $totalQuestions) * 100 }}%"></div>
                    </div>
                </div>

                {{-- Body --}}
                @if (!empty($currentQuestion))
                    <div class="q-body">
                        <div class="q-question">{{ $currentQuestion['question'] }}</div>

                        <div class="q-options">
                            @foreach (['A', 'B', 'C', 'D'] as $option)
                                @php
                                    $optionKey = 'option' . $option;
                                    $isCorrect = $answerSubmitted && $correctOption === $optionKey;
                                    $isWrong = $answerSubmitted && $selectedOptionId === $optionKey && $correctOption !== $optionKey;
                                    $isSelectedBeforeSubmit = !$answerSubmitted && $selectedAnswer === $optionKey;
                                @endphp

                                <button type="button"
                                    wire:click="$set('selectedAnswer', '{{ $optionKey }}')"
                                    @disabled($answerSubmitted)
                                    class="q-option
                                        @if ($isCorrect) q-option--correct
                                        @elseif ($isWrong) q-option--wrong
                                        @elseif ($isSelectedBeforeSubmit) q-option--selected @endif">
                                    <span class="q-option__letter">{{ $option }}</span>
                                    <span class="q-option__text">{{ $currentQuestion[$optionKey] }}</span>
                                    <span class="q-option__mark">
                                        @if ($isCorrect) ✓ @elseif ($isWrong) ✕ @endif
                                    </span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="q-foot">
                        <button wire:click="nextQuestion" class="q-btn">
                            <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                            <span>{{ $answerSubmitted ? ($indexNumber + 1 >= $totalQuestions ? 'إنهاء الاختبار' : 'السؤال التالي') : 'إرسال الإجابة' }}</span>
                        </button>
                    </div>
                @endif

            </div>
        </div>

    {{-- ===== Already played ===== --}}
    @elseif ($hasPlayedBefore)
        <div class="q-wrap">
            <div class="q-card wc-card" style="padding: 32px; text-align: center;">
                <div class="qmodal__icon" style="width:64px;height:64px;background:rgba(52,99,255,0.12);border:1px solid rgba(52,99,255,0.3);">
                    <svg class="w-8 h-8" style="color:#7c93ff" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="qmodal__title">تم إكمال الاختبار بالفعل</h2>
                <p class="text-gray-300 mb-5">لقد أكملت هذا الاختبار بالفعل وحصلت على {{ $previousScore }}/{{ $totalQuestions }}.</p>
                <button wire:click="redirectToStandings" class="q-btn">ترتيب اللاعبين</button>
            </div>
        </div>
    @endif
</div>
