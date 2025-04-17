<h2>Edit Question</h2>

<form action="{{ route('admin.updateQuestion', $question->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Question Text</label>
        <input type="text" name="question_text" class="form-control" value="{{ $question->question_text }}" required>
    </div>

    <div class="form-group">
        <label>Options</label>
        <div class="options">
            @foreach ($question->options as $index => $option)
                <input type="text"
                       name="options[]"
                       class="form-control mb-2"
                       value="{{ $option->option_text }}"
                       placeholder="Option {{ $index + 1 }}"
                       required>
            @endforeach
        </div>
        <button type="button" class="btn btn-secondary" onclick="addOption()">Add Option</button>
    </div>

    <div class="form-group">
        <label>Correct Option</label>
        <select name="correct_option" class="form-control" required id="correct-option-select">
            @foreach ($question->options as $index => $option)
                <option value="{{ $index }}" {{ $option->is_correct ? 'selected' : '' }}>
                    Option {{ $index + 1 }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Update Question</button>
</form>

<script>
    function addOption() {
        const optionsDiv = document.querySelector('.options');
        const index = optionsDiv.children.length;

        // Create new input field
        const newInput = document.createElement('input');
        newInput.type = 'text';
        newInput.name = 'options[]';
        newInput.className = 'form-control mb-2';
        newInput.placeholder = `Option ${index + 1}`;
        newInput.required = true;
        optionsDiv.appendChild(newInput);

        // Add corresponding option to the select dropdown
        const correctSelect = document.getElementById('correct-option-select');
        const newOption = document.createElement('option');
        newOption.value = index;
        newOption.text = `Option ${index + 1}`;
        correctSelect.appendChild(newOption);
    }
</script>
