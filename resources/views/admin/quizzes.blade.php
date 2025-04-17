<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizMaster Pro | Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #4F46E5;
            --secondary: #6366F1;
            --accent: #10B981;
            --bg: #F8FAFC;
            --text: #1E293B;
            --card-bg: #FFFFFF;
            --border: #E2E8F0;
            --success: #10B981;
            --error: #EF4444;
            --warning: #F59E0B;
        }

        [data-theme="dark"] {
            --bg: #0F172A;
            --text: #F8FAFC;
            --card-bg: #1E293B;
            --border: #334155;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
            transition: background 0.3s ease, border-color 0.3s ease;
        }

        body {
            min-height: 100vh;
            background: var(--bg);
            color: var(--text);
            display: flex;
            justify-content: center;
            padding: 2rem;
        }

        .dashboard-container {
            width: 100%;
            max-width: 1200px;
        }

        /* Header Styles */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1rem 0;
            position: relative;
        }

        .header-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--text);
        }

        /* Theme Toggle */
        .theme-toggle {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(var(--primary), 0.1);
            border: 2px solid var(--primary);
            color: var(--primary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .theme-toggle:hover {
            background: var(--primary) !important;
            color: white !important;
            transform: scale(1.05);
        }

        /* Create Quiz Button */
        .create-quiz-container {
            text-align: center;
            margin: 3rem 0;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(79, 70, 229, 0.1);
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                120deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent
            );
            transition: all 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.3);
        }

        /* Quiz Table */
        .quiz-table {
            width: 100%;
            background: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .table-header {
            display: grid;
            grid-template-columns: 3fr 1fr 1fr 0.5fr;
            padding: 1rem 1.5rem;
            background: var(--bg);
            font-weight: 600;
            border-bottom: 1px solid var(--border);
        }

        .table-row {
            display: grid;
            grid-template-columns: 3fr 1fr 1fr 0.5fr;
            padding: 1rem 1.5rem;
            align-items: center;
            border-bottom: 1px solid var(--border);
            transition: background 0.2s ease;
        }

        .table-row:last-child {
            border-bottom: none;
        }

        .quiz-title {
            font-weight: 500;
            color: var(--text);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: none;
            background: transparent;
            color: var(--text);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .btn-icon:hover {
            background: rgba(var(--primary), 0.1);
            color: var(--primary);
        }

        /* Dark Mode Adjustments */
        [data-theme="dark"] .theme-toggle {
            background: rgba(255, 255, 255, 0.1) !important;
            border-color: var(--primary) !important;
        }

        [data-theme="dark"] .btn-primary {
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <h1 class="header-title">Quiz Management</h1>
            <button class="theme-toggle" id="theme-toggle">
                <i class="fas fa-moon"></i>
            </button>
        </header>

        <div class="create-quiz-container">
            <a href="{{ route('admin.createQuiz') }}" class="btn-primary">
                <i class="fas fa-plus"></i>
                Create New Quiz
            </a>
        </div>

        <div class="quiz-table">
            <div class="table-header">
                <span>Quiz Title</span>
                <span>Status</span>
                <span>Last Modified</span>
                <span>Actions</span>
            </div>

            @forelse($quizzes as $quiz)
                <div class="table-row">
                    <a href="{{ route('admin.editQuiz', $quiz->id) }}" class="quiz-title">
                        <i class="fas fa-puzzle-piece"></i>
                        {{ $quiz->title }}
                    </a>
                    <span class="quiz-status">Active</span>
                    <span>2 days ago</span>
                    <div class="action-buttons">
                        <a href="{{ route('admin.editQuiz', $quiz->id) }}" class="btn-icon">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.deleteQuiz', $quiz->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="table-row" style="justify-content: center; padding: 3rem;">
                    <p>No quizzes found. Create your first quiz to get started.</p>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        // Theme Toggle Functionality
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

        // Initialize theme
        setTheme(currentTheme);
    </script>
</body>
</html>
