@extends('layouts.app')

@section('content')
<h1 class="text-center md:text-4xl text-2xl font-bold mb-6 z-10">{{ $quiz->title }}</h1>

<div class="max-w-4xl mx-auto mt-20 px-6">
    <form method="POST" action="{{ route('quiz.submit', $quiz) }}">
        @csrf
        @foreach($quiz->questions as $index => $question)
        <div class="mb-8">
            <p class="text-xl font-semibold mb-6">{{ $index + 1 }}. {{ $question->question_text }}</p>
            <div class="space-y-4">
                @foreach($question->options as $optionIndex => $option)
                <div class="option-container border rounded-lg p-4 transition-colors cursor-pointer hover:border-[#288E72]">
                    <label class="flex items-center w-full cursor-pointer">
                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" class="hidden">
                        <div class="flex items-center w-full justify-between">
                            <div class="flex items-center">
                                <div class="option-letter bg-[#EEF2F3] w-10 h-10 rounded-full flex items-center justify-center font-bold">
                                    {{ chr(65 + $optionIndex) }}
                                </div>
                                <span class="option-text flex-grow">{{ $option->option_text }}</span>
                            </div>
                            <svg class="check-icon hidden w-6 h-6 text-[#288E72]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </label>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

        <button type="submit" class="w-full bg-[#288E72] text-white py-4 rounded-lg hover:bg-[#1F6D56] transition-colors">
            Submit Answer
        </button>
    </form>
</div>

<style>
    .option-container.selected {
        border-color: #288E72;
        background-color: #F8FAFB;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .option-container.selected .option-letter {
        background-color: #288E72;
        color: white;
    }

    .option-container.selected .check-icon {
        display: block;
    }

    .option-letter {
        border-radius: 50%;
        background-color: #E1E8EB;
        color: #288E72;
        font-weight: bold;
        transition: background-color 0.2s, color 0.2s;
    }

    .check-icon {
        display: none;
        color: #288E72;
        font-size: 20px;
    }

    .option-container:hover {
        border-color: #288E72;
        background-color: #F1F8F7;
    }

    .option-container {
        display: flex;
        align-items: center;
        padding: 12px;
        border: 2px solid #D1D8D8;
        border-radius: 8px;
        cursor: pointer;
        position: relative;
        transition: border 0.3s ease, background-color 0.3s ease;
    }

    .option-container .option-letter {
        margin-right: 12px;
        font-size: 18px;
    }

    #paymentPopup {
            display: block; /* Initially show the popup */
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            justify-content: center;
            align-items: center;
            display: flex;
        }
        .popup-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            width: 300px;
            text-align: center;
        }
        .popup-btn {
            margin-top: 20px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .popup-btn:hover {
            background-color: #45a049;
        }
        #premiumContent {
            display: none; /* Initially hide the premium content */
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
</style>

<script>
    document.querySelectorAll('.option-container').forEach(container => {
        container.addEventListener('click', function () {
            const input = this.querySelector('input[type="radio"]');
            const name = input.name;

            document.querySelectorAll(`input[name="${name}"]`).forEach(radio => {
                radio.closest('.option-container').classList.remove('selected');
                radio.closest('.option-container').querySelector('.check-icon').classList.add('hidden');
            });

            input.checked = true;
            this.classList.add('selected');
            this.querySelector('.check-icon').classList.remove('hidden');
        });
    });
</script>
<div id="paymentPopup" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
    <div class="bg-white p-8 rounded-lg shadow-lg w-96">
        <div class="flex justify-center mb-6">
            <img src="https://i.ibb.co/qF3Zfvb1/unnamed.png" alt="Logo" class="w-24 h-24">
        </div>
        <h2 class="text-2xl font-semibold mb-4 text-center text-[#FF69B4]">Payment Information</h2>
        <p class="text-gray-600 mb-4">Send money to the number below:</p>
        <p class="text-lg font-semibold text-[#FF69B4] mb-4">Baksh Send Money Number:
            <span id="paymentNumber" class="text-[#FF69B4] cursor-pointer">+1234567890</span>
            <button onclick="copyNumber()" class="text-sm text-[#FF4500] ml-2 hover:text-[#FF6347]">Copy</button>
        </p>

        <script>
          function copyNumber() {
            var paymentNumber = document.getElementById("paymentNumber").textContent;
            navigator.clipboard.writeText(paymentNumber).then(function() {
              alert("Number copied to clipboard!");
            }, function(err) {
              alert("Error copying number: " + err);
            });
          }
        </script>

        <form id="paymentForm" class="mt-6 space-y-4">
            <div>
                <label for="transactionId" class="block text-sm font-medium text-gray-700">Transaction ID:</label>
                <input type="text" id="transactionId" name="transactionId" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#FF69B4]" required>
            </div>
            <div>
                <label for="mobileNumber" class="block text-sm font-medium text-gray-700">Mobile Number:</label>
                <input type="text" id="mobileNumber" name="mobileNumber" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#FF69B4]" required>
            </div>
            <button type="button" class="w-full bg-[#FF69B4] text-white px-4 py-2 rounded-md hover:bg-pink-600 transition mt-4" onclick="unlockContent()">Submit</button>
        </form>
    </div>
</div>



<!-- Your content (locked initially) -->
<div id="premiumContent">
    <h2>Premium Content Available Now!</h2>
    <p>This content is now unlocked after submitting the payment details.</p>
</div>

<script>
    // Function to unlock the content when the user submits the payment form
    function unlockContent() {
        var transactionId = document.getElementById("transactionId").value;
        var mobileNumber = document.getElementById("mobileNumber").value;

        // Validate form fields
        if (transactionId && mobileNumber) {
            // Hide the popup and unlock content
            document.getElementById("paymentPopup").style.display = "none";
            document.getElementById("premiumContent").style.display = "block"; // Show the premium content
            alert('Thank you! Your payment details have been received. Content unlocked.');
        } else {
            alert('Please fill in all fields.');
        }
    }
</script>
<script>
    function copyNumber() {
      var paymentNumber = document.getElementById("paymentNumber").textContent;
      navigator.clipboard.writeText(paymentNumber).then(function() {
        alert("Number copied to clipboard!");
      }, function(err) {
        alert("Error copying number: " + err);
      });
    }
  </script>
@endsection
