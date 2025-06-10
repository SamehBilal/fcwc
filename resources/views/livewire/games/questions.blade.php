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
                'question' => 'ما هي الدولة المستضيفة لكأس العالم للأندية 2025؟',
                'optionA' => 'قطر',
                'optionB' => 'الولايات المتحدة',
                'optionC' => 'إسبانيا',
                'optionD' => 'السعودية',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'كم عدد الفرق المشاركة في كأس العالم للأندية 2025؟',
                'optionA' => '24 فريقًا',
                'optionB' => '16 فريقًا',
                'optionC' => '32 فريقًا',
                'optionD' => '12 فريقًا',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'ما هي الهيئة المنظمة لكأس العالم للأندية 2025؟',
                'optionA' => 'الاتحاد الأوروبي (UEFA)',
                'optionB' => 'كونمبول (CONMEBOL)',
                'optionC' => 'الفيفا (FIFA)',
                'optionD' => 'الكاف (CAF)',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'أي نادٍ فاز بدوري أبطال أوروبا 2023–24 وتأهل للمونديال 2025؟',
                'optionA' => 'مانشستر سيتي',
                'optionB' => 'ريال مدريد',
                'optionC' => 'إنتر ميلان',
                'optionD' => 'بايرن ميونخ',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'أي نادٍ يمتلك أكبر عدد من ألقاب كأس العالم للأندية إلى حد 2025؟',
                'optionA' => 'برشلونة',
                'optionB' => 'ريال مدريد',
                'optionC' => 'تشيلسي',
                'optionD' => 'كورينثيانز',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'أي مدينة أمريكية تحتضن إحدى مباريات كأس العالم للأندية 2025؟',
                'optionA' => 'نيويورك',
                'optionB' => 'لوس أنجلوس',
                'optionC' => 'ميامي',
                'optionD' => 'أتلانتا',
                'correctOption' => 'optionD',
            ],
            [
                'question' => 'أي قارة تمثل أكبر عدد من الفرق في مونديال الأندية 2025؟',
                'optionA' => 'إفريقيا',
                'optionB' => 'آسيا',
                'optionC' => 'أوروبا',
                'optionD' => 'أمريكا الجنوبية',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'أي فريق من دوري المحترفين الأمريكي (MLS) تأهل للمشاركة؟',
                'optionA' => 'LA Galaxy',
                'optionB' => 'إنتر ميامي',
                'optionC' => 'Seattle Sounders',
                'optionD' => 'Atlanta United',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'متى تُقام نهائيات كأس العالم للأندية 2025؟',
                'optionA' => 'يونيو–يوليو 2025',
                'optionB' => 'يناير 2025',
                'optionC' => 'أغسطس–سبتمبر 2025',
                'optionD' => 'ديسمبر 2025',
                'correctOption' => 'optionA',
            ],
            [
                'question' => 'كم عدد الفرق الإفريقية المؤهلة للمونديال 2025؟',
                'optionA' => 'فريقٌ واحد',
                'optionB' => 'فريقان',
                'optionC' => 'ثلاثة فرق',
                'optionD' => 'أربعة فرق',
                'correctOption' => 'optionD',
            ],
            [
                'question' => 'أي نادي برازيلي فاز بعدّة ألقاب للمونديال؟',
                'optionA' => 'سانتوس',
                'optionB' => 'فلامنجو',
                'optionC' => 'كورينثيانز',
                'optionD' => 'بالمييراس',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'أي ناد سعودي وصل نهائي مونديال الأندية 2022؟',
                'optionA' => 'الهلال',
                'optionB' => 'النصر',
                'optionC' => 'الأهلي',
                'optionD' => 'الاتحاد',
                'correctOption' => 'optionA',
            ],
            [
                'question' => 'ما هو الحد الأقصى لعدد اللاعبين في كل فريق؟',
                'optionA' => '23 لاعبًا',
                'optionB' => '25 لاعبًا',
                'optionC' => '26 لاعبًا',
                'optionD' => '30 لاعبًا',
                'correctOption' => 'optionD',
            ],
            [
                'question' => 'أي فريق إنجليزي فاز بكأس العالم للأندية عام 2021؟',
                'optionA' => 'مانشستر سيتي',
                'optionB' => 'ليفربول',
                'optionC' => 'تشيلسي',
                'optionD' => 'أرسنال',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'كل كم سنة يُقام مونديال الأندية بنظام 32 فريقًا؟',
                'optionA' => 'كل سنة',
                'optionB' => 'كل عامين',
                'optionC' => 'كل ثلاث سنوات',
                'optionD' => 'كل أربع سنوات',
                'correctOption' => 'optionD',
            ],
            [
                'question' => 'أي نادٍ آسيوي فاز بدوري أبطال آسيا 2022؟',
                'optionA' => 'الهلال',
                'optionB' => 'Urawa Red Diamonds',
                'optionC' => 'النصر',
                'optionD' => 'Kawasaki Frontale',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'أي من الفرق التالية لم يُعلن تأهله بعد للمونديال 2025؟',
                'optionA' => 'ريال مدريد',
                'optionB' => 'تشيلسي',
                'optionC' => 'فلامنجو',
                'optionD' => 'الأهلي',
                'correctOption' => 'optionD',
            ],
            [
                'question' => 'أي بطولة تؤهل الأندية من أمريكا الجنوبية؟',
                'optionA' => 'كوبا ليبرتادوريس',
                'optionB' => 'كوبا أمريكا',
                'optionC' => 'الدوري البرازيلي',
                'optionD' => 'كأس الكونميبول',
                'correctOption' => 'optionA',
            ],
            [
                'question' => 'ما هو نظام البطولة للمونديال 2025؟',
                'optionA' => 'إقصائي مباشر',
                'optionB' => 'مجموعات ثم إقصائي',
                'optionC' => 'مجموعات فقط',
                'optionD' => 'دور واحد',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'في أي سنة أُقيم أول كأس عالم للأندية؟',
                'optionA' => '1999',
                'optionB' => '2005',
                'optionC' => '2000',
                'optionD' => '2010',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'أي نادٍ فاز بأول نسخة من بطولة كأس العالم للأندية؟',
                'optionA' => 'كورينثيانز',
                'optionB' => 'مانشستر يونايتد',
                'optionC' => 'بوكا جونيورز',
                'optionD' => 'ريال مدريد',
                'correctOption' => 'optionA',
            ],
            [
                'question' => 'أي بطولة أوروبية تُؤهل الفرق للأندية الأوروبية؟',
                'optionA' => 'الدوري الأوروبي',
                'optionB' => 'كأس السوبر',
                'optionC' => 'دوري أبطال أوروبا',
                'optionD' => 'دوري الأمم',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'أي اتحاد يضم أندية من المكسيك؟',
                'optionA' => 'CAF',
                'optionB' => 'CONCACAF',
                'optionC' => 'UEFA',
                'optionD' => 'AFC',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'أي نادي يلعب له ليونيل ميسي عام 2025؟',
                'optionA' => 'بي إس جي',
                'optionB' => 'برشلونة',
                'optionC' => 'إنتر ميامي',
                'optionD' => 'الهلال',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'ما اسم الكأس الممنوح للفائز بالبطولة؟',
                'optionA' => 'كأس الفيفا العالمي',
                'optionB' => 'كأس الإنتركونتيننتال',
                'optionC' => 'كأس كأس العالم للأندية',
                'optionD' => 'كأس الاتحاد الدولي',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'كم مرة شارك النادي الأهلي المصري في كأس العالم للأندية قبل نسخة 2025؟',
                'optionA' => '3 مرات',
                'optionB' => '5 مرات',
                'optionC' => '7 مرات',
                'optionD' => '8 مرات',
                'correctOption' => 'optionD',
            ],
            [
                'question' => 'من هو النادي العربي الذي حصل على المركز الثاني في كأس العالم للأندية 2022؟',
                'optionA' => 'الأهلي المصري',
                'optionB' => 'الوداد المغربي',
                'optionC' => 'الهلال السعودي',
                'optionD' => 'الترجي التونسي',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'أي نادٍ عربي يُعد أكثر نادٍ أفريقي حصولاً على الميداليات في مونديال الأندية؟',
                'optionA' => 'الوداد',
                'optionB' => 'الأهلي',
                'optionC' => 'الترجي',
                'optionD' => 'العين',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'في أي عام وصل العين الإماراتي إلى نهائي كأس العالم للأندية؟',
                'optionA' => '2017',
                'optionB' => '2018',
                'optionC' => '2019',
                'optionD' => '2020',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'من هو مدرب نادي الهلال خلال مشاركته في كأس العالم للأندية 2022؟',
                'optionA' => 'رامون دياز',
                'optionB' => 'جيسوس',
                'optionC' => 'رازفان لوشيسكو',
                'optionD' => 'جارديم',
                'correctOption' => 'optionA',
            ],
            [
                'question' => 'ما هو إنجاز نادي الترجي التونسي في مونديال الأندية 2019؟',
                'optionA' => 'خسر جميع مبارياته',
                'optionB' => 'تأهل إلى نصف النهائي',
                'optionC' => 'حقق المركز الخامس',
                'optionD' => 'وصل النهائي',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'أي من هذه الأندية العربية تأهل إلى كأس العالم للأندية 2025 عبر دوري أبطال أفريقيا؟',
                'optionA' => 'الوداد المغربي',
                'optionB' => 'الأهلي المصري',
                'optionC' => 'الرجاء المغربي',
                'optionD' => 'شبيبة القبائل',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'من هو الهداف التاريخي للأهلي المصري في كأس العالم للأندية؟',
                'optionA' => 'محمد أبو تريكة',
                'optionB' => 'عماد متعب',
                'optionC' => 'حسين الشحات',
                'optionD' => 'عبدالله السعيد',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'أي فريق عربي خسر نهائي كأس العالم للأندية أمام ريال مدريد؟',
                'optionA' => 'الترجي',
                'optionB' => 'العين',
                'optionC' => 'الهلال',
                'optionD' => 'الوداد',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'ما هو لون قميص نادي الوداد الرياضي الأساسي؟',
                'optionA' => 'أحمر',
                'optionB' => 'أبيض',
                'optionC' => 'أزرق',
                'optionD' => 'أخضر',
                'correctOption' => 'optionA',
            ],
            [
                'question' => 'كم مرة شارك الترجي التونسي في كأس العالم للأندية؟',
                'optionA' => 'مرة واحدة',
                'optionB' => 'مرتين',
                'optionC' => '3 مرات',
                'optionD' => '4 مرات',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'من سجل هدف الهلال الوحيد في نهائي مونديال الأندية 2022؟',
                'optionA' => 'سالم الدوسري',
                'optionB' => 'موسى ماريغا',
                'optionC' => 'كارييو',
                'optionD' => 'فييتو',
                'correctOption' => 'optionD',
            ],
            [
                'question' => 'ما هي النتيجة التي انتهى بها نهائي كأس العالم للأندية بين الهلال وريال مدريد؟',
                'optionA' => '2-0',
                'optionB' => '5-3',
                'optionC' => '3-1',
                'optionD' => '4-2',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'من هو القائد الحالي لفريق الأهلي المصري؟',
                'optionA' => 'عمرو السولية',
                'optionB' => 'محمد الشناوي',
                'optionC' => 'ياسر إبراهيم',
                'optionD' => 'حسين الشحات',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'أين تُوج الوداد المغربي بلقب دوري أبطال أفريقيا 2022؟',
                'optionA' => 'القاهرة',
                'optionB' => 'الدار البيضاء',
                'optionC' => 'تونس',
                'optionD' => 'الجزائر',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'أي فريق عربي خسر من العين الإماراتي في مونديال الأندية 2018؟',
                'optionA' => 'الترجي',
                'optionB' => 'الوداد',
                'optionC' => 'الأهلي',
                'optionD' => 'الهلال',
                'correctOption' => 'optionA',
            ],
            [
                'question' => 'كم هدفًا سجل الأهلي في بطولة 2020 من كأس العالم للأندية؟',
                'optionA' => 'هدف واحد',
                'optionB' => 'هدفان',
                'optionC' => '3 أهداف',
                'optionD' => '4 أهداف',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'أي مدرب قاد الوداد في كأس العالم للأندية 2022؟',
                'optionA' => 'وليد الركراكي',
                'optionB' => 'الحسين عموتة',
                'optionC' => 'سفين فاندنبروك',
                'optionD' => 'فوزي البنزرتي',
                'correctOption' => 'optionB',
            ],
            [
                'question' => 'أين أُقيمت بطولة كأس العالم للأندية التي شارك فيها الهلال عام 2022؟',
                'optionA' => 'قطر',
                'optionB' => 'الإمارات',
                'optionC' => 'المغرب',
                'optionD' => 'الولايات المتحدة',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'كم مرة حقق الأهلي المصري الميدالية البرونزية في مونديال الأندية؟',
                'optionA' => 'مرة واحدة',
                'optionB' => 'مرتين',
                'optionC' => '3 مرات',
                'optionD' => '4 مرات',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'من هو الفريق الذي أقصى الترجي من مونديال 2019؟',
                'optionA' => 'الهلال',
                'optionB' => 'فلامنغو',
                'optionC' => 'العين',
                'optionD' => 'مونتيري',
                'correctOption' => 'optionA',
            ],
            [
                'question' => 'ما هو اسم ملعب نادي العين الإماراتي؟',
                'optionA' => 'ملعب محمد بن زايد',
                'optionB' => 'ملعب آل نهيان',
                'optionC' => 'استاد هزاع بن زايد',
                'optionD' => 'استاد خليفة الدولي',
                'correctOption' => 'optionC',
            ],
            [
                'question' => 'من هو هداف نادي الهلال السعودي في مشاركاته بمونديال الأندية؟',
                'optionA' => 'بافيتيمبي غوميز',
                'optionB' => 'سالم الدوسري',
                'optionC' => 'ماريغا',
                'optionD' => 'كارييو',
                'correctOption' => 'optionA',
            ],
            [
                'question' => 'ما اسم المدافع المغربي البارز في صفوف الوداد عام 2022؟',
                'optionA' => 'أشرف داري',
                'optionB' => 'بدر بانون',
                'optionC' => 'يحيى عطية الله',
                'optionD' => 'نايف أكرد',
                'correctOption' => 'optionA',
            ],
            [
                'question' => 'من هو الفريق الذي سيُمثل تونس في مونديال 2025؟',
                'optionA' => 'النجم الساحلي',
                'optionB' => 'النادي الصفاقسي',
                'optionC' => 'الترجي الرياضي',
                'optionD' => 'البنزرتي',
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

    <h1 class="title text-right">FIFA Club World Cup 2025 Questions</h1>
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
