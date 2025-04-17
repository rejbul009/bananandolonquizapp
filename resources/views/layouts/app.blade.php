<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="shortcut icon" href="{{ asset("/Assets/./images/logo.png") }}">
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset("/Assets/style.css") }}">
</head>
<body class="min-h-screen flex flex-col">
    {{-- Header --}}
    <header class="sticky top-0 z-40 flex w-full h-[80px] bg-white border-b border-b-[#ECEFF3] shadow-md">
        <div class="flex items-center justify-between w-full px-6">
            <a href="/" class="logo flex items-center" title="University Management System">
                <img src="{{ asset("/Assets/./images/logo.png") }}" alt="Banan Andolon" class="size-14">
                <h2 class="text-xl font-bold">
                    <span style="color: green; margin-right: 2px;">বানান</span>
                    <span style="color: red;">আন্দোলন</span>
                </h2>
            </a>

            <div class="flex items-center sm:gap-6 gap-4">
                <span id="profile-btn" class="material-icons-sharp">person</span>

                <div class="theme-toggler">
                    <span class="material-icons-sharp active">light_mode</span>
                    <span class="material-icons-sharp">dark_mode</span>
                </div>
            </div>
        </div>
    </header>

    <div class="flex flex-1 overflow-hidden">
        <!-- Sidebar -->
        <aside class="absolute left-0 top-0 lg:z-0 z-50 lg:h-[calc(100vh-80px)] h-full w-72 overflow-y-auto bg-gray-800 lg:duration-0 duration-300 ease-linear lg:static lg:translate-x-0 -translate-x-full">
            <div class="p-6">
                <div class="profile">
                    <div class="top">
                        <div class="profile-photo border-[3px] border-white/35">
                            <form action="{{ route('profile.update.picture') }}" method="POST" enctype="multipart/form-data" id="profile-pic-form">
                                @csrf
                                <label for="profile_picture_input">
                                    <img
                                        src="https://i.ibb.co.com/VWh4jWw1/default-avatar-profile-icon-social-600nw-1677509740.jpg"
                                        alt="Profile Picture"
                                    >
                                </label>
                                <input type="file" name="profile_picture" id="profile_picture_input" style="display: none;" onchange="document.getElementById('profile-pic-form').submit();">
                            </form>
                        </div>

                        <div class="info">
                            <p class="!text-white">Hey, <b class="!text-white/75">{{ $user->name }}</b></p>
                            <small class="!text-white">ID: {{ $user->id }}</small>
                        </div>
                    </div>
                    <div class="py-3 text-center">
                        <a href="mailto:{{ $user->email }}" class="text-center text-white/80">{{ $user->email }}</a>
                    </div>
                </div>

                <div class="flex flex-col gap-5 mt-8">
                    <a href="{{ url("/") }}" class="active flex items-center gap-4 group">
                        <span class="material-icons-sharp !text-white/75 !text-2xl">home</span>
                        <h3 class="!text-white md:text-lg group-hover:!text-red-600 !transition-all !duration-300">Home</h3>
                    </a>
                    <a href="{{ url("timetable.html") }}" onclick="timeTableAll()" class="active flex items-center gap-4 group">
                        <span class="material-icons-sharp !text-white/75 !text-2xl">video_library</span>
                        <h3 class="!text-white md:text-lg group-hover:!text-red-600 !transition-all !duration-300">Premium Class</h3>
                    </a>
                    <a href="{{ route('user.quizzes') }}" class="active flex items-center gap-4 group">
                        <span class="material-icons-sharp !text-white/75 !text-2xl">assignment_turned_in</span>
                        <h3 class="!text-white md:text-lg group-hover:!text-red-600 !transition-all !duration-300">Mock Test</h3>
                    </a>
                    <a href="{{ route("change.password") }}" class="active flex items-center gap-4 group">
                        <span class="material-icons-sharp !text-white/75 !text-2xl">password</span>
                        <h3 class="!text-white md:text-lg group-hover:!text-red-600 !transition-all !duration-300">Change Password</h3>
                    </a>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="active flex items-center gap-4 group">
                        <span class="material-icons-sharp !text-white/75 !text-2xl">logout</span>
                        <h3 class="!text-white md:text-lg group-hover:!text-red-600 !transition-all !duration-300">Logout</h3>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </aside>
        <div class="relative flex flex-1 flex-col ooverflow-hidden">
            <!-- Main content -->
            <div id="content" class="lg:p-10 p-5 h-[calc(100vh-140px)] overflow-y-auto">
                @yield('content')
            </div>
            {{-- Footer --}}
            <footer class="bg-gray-800 text-white p-6 lg:h-[60px]">
                <div class="mx-auto flex md:flex-row flex-col items-center justify-between text-center md:space-y-0 space-y-4">
                    <p class="text-white">
                        &copy; <span id="current-year" class="text-white"></span>
                        <a href="https://bananandolon.com/" class="text-green-500 hover:text-green-300">বানান আন্দোলন</a>.
                        All Rights Reserved.
                    </p>
                    <p class="text-sm text-gray-400 !mt-0">
                        Built with  by
                        <a href="https://github.com/rejbul009" target="_blank" class="text-blue-500 hover:text-blue-300">Rejbul Islam</a>
                    </p>
                </div>
            </footer>
        </div>
    </div>

    <script>
        // Update the year dynamically
        document.getElementById('current-year').textContent = new Date().getFullYear();
    </script>
    <script src="{{ asset('/Assets/timeTable.js') }}"></script>
    <script src="{{ asset('/Assets/app.js') }}"></script>
    <script>
        window.onload = function() {
          const toast = document.getElementById('profileToast');
          toast.style.opacity = 1;

          setTimeout(() => {
            toast.style.opacity = 0;
          }, 10000); // hides after 5 seconds
        };
      </script>
</body>
</html>



























