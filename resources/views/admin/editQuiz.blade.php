<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Quiz | QuizMaster Pro</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Add to your existing CSS */
        .quiz-editor {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 2rem;
            border: 1px solid var(--border);
            margin-top: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text);
        }

        .quiz-input {
            width: 100%;
            padding: 1rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--option-bg);
            color: var(--text);
            font-size: 1rem;
        }

        .question-card {
            background: var(--option-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .options-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 1rem 0;
        }

        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
        }

        .btn-secondary {
            background: var(--option-bg);
            color: var(--text);
            border: 1px solid var(--border);
        }

        .btn-danger {
            background: var(--error);
            color: white;
            border: none;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <button class="theme-toggle" id="theme-toggle">
        <i class="fas fa-moon"></i>
    </button>

    <div class="dashboard-container">
        <div class="quiz-builder">
            <h1 class="quiz-title">Edit Quiz</h1>

            <form action="{{ route('admin.updateQuiz', $quiz->id) }}" method="POST" class="quiz-editor">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title" class="form-label">Quiz Title</label>
                    <input type="text" class="quiz-input" name="title" id="title"
                           value="{{ $quiz->title }}" required>
                </div>

                <div id="questions-section">
                    @foreach ($quiz->questions as $qIndex => $question)
                        <div class="question-card">
                            <div class="question-header">
                                <h3 class="question-number">Question {{ $qIndex + 1 }}</h3>
                                <a href="{{ route('admin.deleteQuestion', $question->id) }}"
                                   class="btn btn-danger"
                                   onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                    Delete Question
                                </a>
                            </div>
                            <input type="hidden" name="questions[{{ $qIndex }}][id]"
                                   value="{{ $question->id }}">

                            <div class="form-group">
                                <label class="form-label">Question Text</label>
                                <input type="text"
                                       name="questions[{{ $qIndex }}][question_text]"
                                       class="quiz-input"
                                       value="{{ $question->question_text }}"
                                       required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Options</label>
                                <div class="options-grid">
                                    @foreach ($question->options as $oIndex => $option)
                                        <input type="text"
                                               name="questions[{{ $qIndex }}][options][]"
                                               class="quiz-input"
                                               value="{{ $option->option_text }}"
                                               placeholder="Option {{ $oIndex + 1 }}"
                                               required>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-secondary"
                                        onclick="addOption({{ $qIndex }})">
                                    <i class="fas fa-plus"></i>
                                    Add Option
                                </button>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Correct Option</label>
                                <select name="questions[{{ $qIndex }}][correct_option]"
                                        class="quiz-input" required>
                                    @foreach ($question->options as $oIndex => $option)
                                        <option value="{{ $oIndex }}" {{ $option->is_correct ? 'selected' : '' }}>
                                            Option {{ $oIndex + 1 }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="btn-group">
                    <button type="button" class="btn btn-secondary" id="add-question-btn">
                        <i class="fas fa-plus"></i>
                        Add Question
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Update Quiz
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Theme Toggle (same as previous pages)
        const themeToggle = document.getElementById('theme-toggle');
        let currentTheme = localStorage.getItem('theme') || 'light';

        const setTheme = (theme) => {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            themeToggle.innerHTML = theme === 'dark'
                ? '<i class="fas fa-sun"></i>'
                : '<i class="fas fa-moon"></i>';
        };

        themeToggle.addEventListener('click', () => {
            currentTheme = currentTheme === 'dark' ? 'light' : 'dark';
            setTheme(currentTheme);
        });
        setTheme(currentTheme);

        // Quiz Editor Logic
        function addOption(questionIndex) {
            const optionsGrid = document.querySelectorAll('.question-card')[questionIndex]
                                .querySelector('.options-grid');
            const optionCount = optionsGrid.children.length;

            const newOption = document.createElement('input');
            newOption.type = 'text';
            newOption.className = 'quiz-input';
            newOption.name = `questions[${questionIndex}][options][]`;
            newOption.placeholder = `Option ${optionCount + 1}`;
            newOption.required = true;

            optionsGrid.appendChild(newOption);

            // Update select options
            const select = document.querySelectorAll('.question-card')[questionIndex]
                           .querySelector('select');
            const newOptionElement = document.createElement('option');
            newOptionElement.value = optionCount;
            newOptionElement.textContent = `Option ${optionCount + 1}`;
            select.appendChild(newOptionElement);
        }

        document.getElementById('add-question-btn').addEventListener('click', function() {
            const questionIndex = document.querySelectorAll('.question-card').length;
            const newQuestionHTML = `
                <div class="question-card">
                    <div class="form-group">
                        <label class="form-label">Question Text</label>
                        <input type="text"
                               name="questions[${questionIndex}][question_text]"
                               class="quiz-input"
                               required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Options</label>
                        <div class="options-grid">
                            <input type="text"
                                   name="questions[${questionIndex}][options][]"
                                   class="quiz-input"
                                   placeholder="Option 1"
                                   required>
                            <input type="text"
                                   name="questions[${questionIndex}][options][]"
                                   class="quiz-input"
                                   placeholder="Option 2"
                                   required>
                        </div>
                        <button type="button"
                                class="btn btn-secondary"
                                onclick="addOption(${questionIndex})">
                            <i class="fas fa-plus"></i>
                            Add Option
                        </button>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Correct Option</label>
                        <select name="questions[${questionIndex}][correct_option]"
                                class="quiz-input"
                                required>
                            <option value="0">Option 1</option>
                            <option value="1">Option 2</option>
                        </select>
                    </div>
                </div>`;

            document.getElementById('questions-section').insertAdjacentHTML('beforeend', newQuestionHTML);
        });
    </script>
</body>
</html>
