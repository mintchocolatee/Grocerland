@extends('components.layout')

@section('content')
    <div class="add-faq-container">
        <form action="{{ route('faq.update', $faq->id) }}" method="POST" id="faq-form">
            @csrf
            @method('PUT')
            <label for="big_title" id="question-text">Title</label><br>
            <input type="text" id="question" name="big_title" value="{{ $faq->big_title }}" class="form-control">
    
            <div id="subquestions-container">
                @foreach($faq->subquestions_answers as $index => $subquestion_answer)
                <div class="subquestion">
                    <input type="text" name="subquestions[]" value="{{ $subquestion_answer['subquestion'] }}" placeholder="Subquestion" class="form-control">
                    <input type="text" name="answers[]" value="{{ $subquestion_answer['answer'] }}" placeholder="Answer" class="form-control">
                </div>
                @endforeach
            </div>

            <button type="button" id="add-subquestion">Add Subquestion</button><br>
            <button type="submit" id="faq-submit" class="btn btn-primary">Update FAQ</button>
        </form>
    </div>

    <script>
        document.getElementById('add-subquestion').addEventListener('click', function () {
            const container = document.getElementById('subquestions-container');
            const subquestion = document.createElement('div');
            subquestion.classList.add('subquestion');
            subquestion.innerHTML = `
                <input type="text" name="subquestions[]" placeholder="Subquestion" class="form-control">
                <input type="text" name="answers[]" placeholder="Answer" class="form-control">
                <button type="button" class="remove-subquestion">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="25" viewBox="0 0 32 32">
                        <path d="M 15 4 C 14.476563 4 13.941406 4.183594 13.5625 4.5625 C 13.183594 4.941406 13 5.476563 13 6 L 13 7 L 7 7 L 7 9 L 8 9 L 8 25 C 8 26.644531 9.355469 28 11 28 L 23 28 C 24.644531 28 26 26.644531 26 25 L 26 9 L 27 9 L 27 7 L 21 7 L 21 6 C 21 5.476563 20.816406 4.941406 20.4375 4.5625 C 20.058594 4.183594 19.523438 4 19 4 Z M 15 6 L 19 6 L 19 7 L 15 7 Z M 10 9 L 24 9 L 24 25 C 24 25.554688 23.554688 26 23 26 L 11 26 C 10.445313 26 10 25.554688 10 25 Z M 12 12 L 12 23 L 14 23 L 14 12 Z M 16 12 L 16 23 L 18 23 L 18 12 Z M 20 12 L 20 23 L 22 23 L 22 12 Z"></path>
                    </svg>
                </button>
            `;
            container.appendChild(subquestion);
        });

        document.addEventListener('click', function (e) {
            if (e.target && e.target.closest('.remove-subquestion')) {
                e.target.closest('.subquestion').remove();
            }
        });

        document.getElementById('faq-form').addEventListener('submit', function (e) {
            const subquestions = document.querySelectorAll('input[name="subquestions[]"]');
            const answers = document.querySelectorAll('input[name="answers[]"]');
            let valid = true;

            subquestions.forEach((subquestion, index) => {
                if (subquestion.value.trim() === '' || answers[index].value.trim() === '') {
                    valid = false;
                    alert('Please fill out all subquestions and answers.');
                }
            });

            if (!valid) {
                e.preventDefault();
            }
        });
    </script>
@endsection
