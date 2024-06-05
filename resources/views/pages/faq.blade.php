@extends('components.layout')

@section('content')
    <div class="faq-image">
        <div class="faq-search-bar">
            <input type="text" id="faqSearchInput" placeholder="Search...">
            <button type="button" onclick="searchFaq()">Search</button>
        </div>
        <img src="../assets/images/faqheader.svg" alt="Image">
    </div>
    <div class="faq-title-add">
        <span class="faq-title">Frequently Asked Questions</span>
        {{-- only seller --}}
        <span><a href="{{ route('faq.create') }}" class="faq-add-button"><img width="40" height="40" src="https://img.icons8.com/?size=100&id=Xb6BIWuGB9xH&format=png&color=000000" alt="add"/></a></span>
    </div>
    <div class="faq-container">
        @foreach($faqs as $faq)
            <div class="faq-section">
                <div class="faq-header" data-toggle="collapse" data-target="#faq-{{ $loop->index }}">
                    <h4>{{ $faq->big_title }}</h4>
                    {{-- only seller --}}
                    <div class="seller-buttons">
                        <a href="{{ route('faq.edit', $faq->id) }}" class="faq-edit-button">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="25" viewBox="0 0 24 24">
                                <path d="M20.011,3.989c-1.318-1.318-3.455-1.318-4.773,0L4.208,14.998c-0.302,0.302-0.503,0.689-0.576,1.11	l-0.615,3.567c-0.133,0.772,0.538,1.442,1.31,1.308l3.525-0.613c0.418-0.073,0.804-0.273,1.104-0.573L20.011,8.761	C21.33,7.443,21.33,5.307,20.011,3.989z" opacity=".35"></path><polygon points="13.075,6.144 17.848,10.917 19.832,8.94 15.059,4.167"></polygon><path d="M3.392,17.5l-0.375,2.175c-0.133,0.772,0.538,1.442,1.31,1.308l2.171-0.378L3.392,17.5z"></path>
                            </svg>
                        </a>
                        <form action="{{ route('faq.destroy', $faq->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="faq-delete-button">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="25" viewBox="0 0 32 32">
                                    <path d="M 15 4 C 14.476563 4 13.941406 4.183594 13.5625 4.5625 C 13.183594 4.941406 13 5.476563 13 6 L 13 7 L 7 7 L 7 9 L 8 9 L 8 25 C 8 26.644531 9.355469 28 11 28 L 23 28 C 24.644531 28 26 26.644531 26 25 L 26 9 L 27 9 L 27 7 L 21 7 L 21 6 C 21 5.476563 20.816406 4.941406 20.4375 4.5625 C 20.058594 4.183594 19.523438 4 19 4 Z M 15 6 L 19 6 L 19 7 L 15 7 Z M 10 9 L 24 9 L 24 25 C 24 25.554688 23.554688 26 23 26 L 11 26 C 10.445313 26 10 25.554688 10 25 Z M 12 12 L 12 23 L 14 23 L 14 12 Z M 16 12 L 16 23 L 18 23 L 18 12 Z M 20 12 L 20 23 L 22 23 L 22 12 Z"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                    <span class="arrow">&#x25BC;</span>
                </div>
                <div id="faq-{{ $loop->index }}" class="faq-content collapse">
                    @foreach($faq->subquestions_answers as $subqa)
                        <div class="faq-subsection">
                            <div class="faq-subheader" data-toggle="collapse" data-target="#subfaq-{{ $loop->parent->index }}-{{ $loop->index }}">
                                <h4>{{ $subqa['subquestion'] }}</h4>
                                <div class="seller-buttons">
                                    <form action="{{ route('faq.destroySub', ['faqId' => $faq->id, 'subIndex' => $loop->index]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="faq-delete-button">
                                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="25" viewBox="0 0 32 32">
                                                <path d="M 15 4 C 14.476563 4 13.941406 4.183594 13.5625 4.5625 C 13.183594 4.941406 13 5.476563 13 6 L 13 7 L 7 7 L 7 9 L 8 9 L 8 25 C 8 26.644531 9.355469 28 11 28 L 23 28 C 24.644531 28 26 26.644531 26 25 L 26 9 L 27 9 L 27 7 L 21 7 L 21 6 C 21 5.476563 20.816406 4.941406 20.4375 4.5625 C 20.058594 4.183594 19.523438 4 19 4 Z M 15 6 L 19 6 L 19 7 L 15 7 Z M 10 9 L 24 9 L 24 25 C 24 25.554688 23.554688 26 23 26 L 11 26 C 10.445313 26 10 25.554688 10 25 Z M 12 12 L 12 23 L 14 23 L 14 12 Z M 16 12 L 16 23 L 18 23 L 18 12 Z M 20 12 L 20 23 L 22 23 L 22 12 Z"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                <span class="arrow">&#x25BC;</span>
                            </div>
                            <div id="subfaq-{{ $loop->parent->index }}-{{ $loop->index }}" class="faq-subcontent collapse">
                                @if (!empty($subqa['answer']))
                                    <p>{{ $subqa['answer'] }}</p>
                                @else
                                    <p>No answer</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var headers = document.querySelectorAll('[data-toggle="collapse"]');
            
            headers.forEach(function(header) {
                header.addEventListener('click', function() {
                    var target = document.querySelector(header.getAttribute('data-target'));
                    
                    if (target.style.display === "none" || target.style.display === "") {
                        target.style.display = "block";
                        header.querySelector('.arrow').style.transform = 'rotate(0deg)';
                    } else {
                        target.style.display = "none";
                        header.querySelector('.arrow').style.transform = 'rotate(-90deg)';
                    }
                });
            });
        });

        function searchFaq() {
            var input, filter, faqSections, faqHeaders, faqSubheaders, i, txtValue;
            input = document.getElementById('faqSearchInput');
            filter = input.value.toUpperCase();
            faqSections = document.querySelectorAll('.faq-section');

            faqSections.forEach(function(section) {
                faqHeaders = section.querySelectorAll('.faq-header');
                faqSubheaders = section.querySelectorAll('.faq-subheader');

                var found = false;
                faqHeaders.forEach(function(header) {
                    txtValue = header.textContent || header.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        section.style.display = "";
                        found = true;
                    }
                });

                if (!found) {
                    faqSubheaders.forEach(function(subheader) {
                        txtValue = subheader.textContent || subheader.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            section.style.display = "";
                        } else {
                            section.style.display = "none";
                        }
                    });
                }
            });

            if (filter.trim() === '') {
                faqSections.forEach(function(section) {
                    section.style.display = "";
                });
            }
        }
    </script>
@endsection
