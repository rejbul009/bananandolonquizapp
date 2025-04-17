<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Builder Pro</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --secondary: #a855f7;
            --bg: #ffffff;
            --text: #1a1a1a;
            --card-bg: #ffffff;
            --border: rgba(0, 0, 0, 0.1);
            --option-bg: #f8f9fa;
        }

        [data-theme="dark"] {
            --bg: #1a1a1a;
            --text: #ffffff;
            --card-bg: #2d2d2d;
            --border: rgba(255, 255, 255, 0.1);
            --option-bg: rgba(0, 0, 0, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
            transition: background 0.3s, border-color 0.3s;
        }

        body {
            min-height: 100vh;
            background: var(--bg);
            color: var(--text);
            display: flex;
            justify-content: center;
            padding: 2rem;
        }

        .theme-toggle {
            position: fixed;
            top: 1rem;
            right: 1rem;
            padding: 0.5rem;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            background: var(--primary);
            color: white;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .quiz-builder {
            width: 100%;
            max-width: 800px;
            background: var(--card-bg);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid var(--border);
        }

        .quiz-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .quiz-title {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--primary);
        }

        .quiz-input {
            width: 100%;
            padding: 1rem;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: var(--option-bg);
            color: var(--text);
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }

        .question-card {
            background: var(--option-bg);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border);
            position: relative;
        }

        .question-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .question-number {
            font-size: 1.2rem;
            color: var(--primary);
            font-weight: 600;
        }

        .delete-question {
            background: none;
            border: none;
            color: #e74c3c;
            cursor: pointer;
            font-size: 1.2rem;
            margin-left: auto;
            padding: 0.5rem;
        }

        .options-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .option-input input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--card-bg);
            color: var(--text);
        }

        .add-option-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            background: var(--primary);
            color: white;
            cursor: pointer;
            margin-bottom: 1rem;
        }

        .correct-option-select {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--card-bg);
            color: var(--text);
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%236366f1'%3e%3cpath d='M7 10l5 5 5-5z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1em;
        }

        .add-question-btn {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 56px;
            height: 56px;
            border: none;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .submit-btn {
            width: 100%;
            padding: 1rem;
            border: none;
            border-radius: 12px;
            background: var(--primary);
            color: white;
            font-weight: 600;
            cursor: pointer;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <button class="theme-toggle" id="theme-toggle">🌓</button>

    <form action="{{ route('admin.storeQuiz') }}" method="POST" class="quiz-builder">
        @csrf
        <div class="quiz-header">
            <h1 class="quiz-title">Create New Quiz</h1>
            <input type="text" class="quiz-input" placeholder="Enter Quiz Title..."
                   name="title" id="title" required>
        </div>

        <div id="questions-section">
            <div class="question-card">
                <div class="question-header">
                    <span class="question-number">Question 1</span>
                    <button type="button" class="delete-question" onclick="deleteQuestion(0)">✕</button>
                </div>
                <input type="text" class="quiz-input" placeholder="Enter question text..."
                       name="questions[0][question_text]" required>

                <div class="options-grid">
                    <div class="option-input">
                        <input type="text" placeholder="Option 1" name="questions[0][options][]" required>
                    </div>
                    <div class="option-input">
                        <input type="text" placeholder="Option 2" name="questions[0][options][]" required>
                    </div>
                    <div class="option-input">
                        <input type="text" placeholder="Option 3" name="questions[0][options][]" required>
                    </div>
                    <div class="option-input">
                        <input type="text" placeholder="Option 4" name="questions[0][options][]" required>
                    </div>
                </div>

                <button type="button" class="add-option-btn" onclick="addOption(0)">
                    <i class="fas fa-plus"></i>
                    Add Option
                </button>

                <select class="correct-option-select" name="questions[0][correct_option]" required>
                    <option value="0">Option 1</option>
                    <option value="1">Option 2</option>
                    <option value="2">Option 3</option>
                    <option value="3">Option 4</option>
                </select>
            </div>
        </div>

        <button type="submit" class="submit-btn">
            <i class="fas fa-save"></i>
            Save Quiz
        </button>
    </form>

    <button type="button" class="add-question-btn" id="add-question-btn">
        <i class="fas fa-plus"></i>
    </button>

    <script>
        // Theme Management
        const themeToggle = document.getElementById('theme-toggle');
        let currentTheme = localStorage.getItem('theme') ||
                         (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

        const setTheme = (theme) => {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            themeToggle.textContent = theme === 'dark' ? '🌙' : '☀️';
        };
        setTheme(currentTheme);

        themeToggle.addEventListener('click', () => {
            currentTheme = currentTheme === 'dark' ? 'light' : 'dark';
            setTheme(currentTheme);
        });

        // Quiz Builder Logic
        let questionCount = 1;

        function deleteQuestion(questionIndex) {
            const questionCard = document.querySelector(`#questions-section .question-card:nth-child(${questionIndex + 1})`);
            if (questionCard) {
                questionCard.remove();
                reindexQuestions();
            }
        }

        function reindexQuestions() {
            const questions = document.querySelectorAll('.question-card');
            questions.forEach((question, newIndex) => {
                // Update question number display
                question.querySelector('.question-number').textContent = `Question ${newIndex + 1}`;

                // Update all input names
                const inputs = question.querySelectorAll('input, select');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) {
                        const newName = name.replace(/\[\d+\]/g, `[${newIndex}]`);
                        input.setAttribute('name', newName);
                    }
                });

                // Update delete button index
                question.querySelector('.delete-question').setAttribute('onclick', `deleteQuestion(${newIndex})`);

                // Update add option button index
                const addOptionBtn = question.querySelector('.add-option-btn');
                addOptionBtn.setAttribute('onclick', `addOption(${newIndex})`);

                // Update correct option dropdown
                const select = question.querySelector('select');
                const options = question.querySelectorAll('.options-grid .option-input input');
                select.innerHTML = '';
                options.forEach((_, i) => {
                    const option = document.createElement('option');
                    option.value = i;
                    option.textContent = `Option ${i + 1}`;
                    select.appendChild(option);
                });
            });
            questionCount = questions.length;
        }

        function addOption(questionIndex) {
            const optionsGrid = document.querySelector(`#questions-section .question-card:nth-child(${questionIndex + 1}) .options-grid`);
            const optionCount = optionsGrid.children.length;

            if(optionCount >= 6) return;

            const newOption = document.createElement('div');
            newOption.className = 'option-input';
            newOption.innerHTML = `
                <input type="text" placeholder="Option ${optionCount + 1}"
                       name="questions[${questionIndex}][options][]" required>
            `;
            optionsGrid.appendChild(newOption);

            const select = document.querySelector(`#questions-section .question-card:nth-child(${questionIndex + 1}) select`);
            const newOptionElement = document.createElement('option');
            newOptionElement.value = optionCount;
            newOptionElement.textContent = `Option ${optionCount + 1}`;
            select.appendChild(newOptionElement);
        }

        document.getElementById('add-question-btn').addEventListener('click', () => {
            const questionIndex = questionCount++;
            const newQuestion = document.createElement('div');
            newQuestion.className = 'question-card';
            newQuestion.innerHTML = `
                <div class="question-header">
                    <span class="question-number">Question ${questionIndex + 1}</span>
                    <button type="button" class="delete-question" onclick="deleteQuestion(${questionIndex})">✕</button>
                </div>
                <input type="text" class="quiz-input" placeholder="Enter question text..."
                       name="questions[${questionIndex}][question_text]" required>

                <div class="options-grid">
                    ${Array.from({length: 4}, (_, i) => `
                        <div class="option-input">
                            <input type="text" placeholder="Option ${i + 1}"
                                   name="questions[${questionIndex}][options][]" required>
                        </div>
                    `).join('')}
                </div>

                <button type="button" class="add-option-btn" onclick="addOption(${questionIndex})">
                    <i class="fas fa-plus"></i>
                    Add Option
                </button>

                <select class="correct-option-select" name="questions[${questionIndex}][correct_option]" required>
                    ${Array.from({length: 4}, (_, i) => `
                        <option value="${i}">Option ${i + 1}</option>
                    `).join('')}
                </select>
            `;
            document.getElementById('questions-section').appendChild(newQuestion);
        });
    </script>
</body>
</html>
