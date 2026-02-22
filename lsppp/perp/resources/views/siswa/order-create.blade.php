@extends('siswa.layout')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ url('/siswa/dashboard') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-slate-700 transition-colors mb-4">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Dashboard
            </a>
            <h1 class="text-3xl font-bold text-slate-900 mb-2">Borrow a Book</h1>
            <p class="text-slate-500">Select a book from our collection to borrow</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 rounded-xl">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-red-500 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-red-800">There were errors with your submission</h3>
                        <ul class="mt-1 list-disc list-inside text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Book Selection Card -->
        <form action="{{ url('/siswa/order/create') }}" method="POST">
            @csrf
            
            <!-- Available Books Grid -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-slate-50 to-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-900">Available Books</h2>
                            <p class="text-sm text-slate-500">{{ count($books) }} books in stock</p>
                        </div>
                    </div>
                </div>

                @if(count($books) > 0)
                    <div class="p-6">
                        <!-- Search/Filter -->
                        <div class="mb-6">
                            <div class="relative">
                                <input 
                                    type="text" 
                                    id="book-search" 
                                    placeholder="Search books by title or author..." 
                                    class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-slate-400 focus:ring-2 focus:ring-slate-200 outline-none transition-all text-slate-800"
                                >
                                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Books Grid -->
                        <div id="books-container" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($books as $book)
                                <label 
                                    class="book-item relative flex cursor-pointer rounded-xl border-2 border-gray-100 bg-white p-4 shadow-sm transition-all duration-200 hover:border-slate-300 hover:shadow-md peer-checked:border-slate-900 peer-checked:ring-1 peer-checked:ring-slate-900"
                                    data-title="{{ strtolower($book->nama) }}"
                                    data-author="{{ strtolower($book->pengarang) }}"
                                >
                                    <input type="radio" name="book_id" value="{{ $book->id }}" class="peer sr-only" {{ old('book_id') == $book->id ? 'checked' : '' }}>
                                    
                                    <!-- Book Cover Placeholder -->
                                    <div class="flex-shrink-0 w-16 h-20 bg-gradient-to-br from-slate-700 to-slate-900 rounded-lg flex items-center justify-center mr-4 shadow-md">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>

                                    <!-- Book Info -->
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-slate-900 truncate">{{ $book->nama }}</h3>
                                        <p class="text-sm text-slate-500 mb-2">by {{ $book->pengarang }}</p>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-slate-100 text-slate-600">
                                                {{ $book->penerbit }}
                                            </span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium {{ $book->stock > 5 ? 'bg-emerald-100 text-emerald-700' : ($book->stock > 2 ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                                                {{ $book->stock }} available
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Selection Indicator -->
                                    <div class="absolute top-3 right-3 w-6 h-6 rounded-full border-2 border-gray-200 peer-checked:border-slate-900 peer-checked:bg-slate-900 flex items-center justify-center transition-all">
                                        <svg class="w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        <!-- No Results Message (hidden by default) -->
                        <div id="no-results" class="hidden text-center py-12">
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-slate-700 mb-1">No books found</h3>
                            <p class="text-slate-500 text-sm">Try adjusting your search terms</p>
                        </div>
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-700 mb-2">No Books Available</h3>
                        <p class="text-slate-500 text-sm">All books are currently borrowed. Please check back later.</p>
                    </div>
                @endif
            </div>

            <!-- Borrow Information -->
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-xl p-5 mb-6">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-amber-400 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-amber-800 mb-1">Borrowing Information</h3>
                        <ul class="text-sm text-amber-700 space-y-1">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Maximum borrowing period: 14 days
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Please return books in good condition
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Late returns may result in borrowing restrictions
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            @if(count($books) > 0)
                <div class="flex items-center justify-between">
                    <a href="{{ url('/siswa/dashboard') }}" class="px-6 py-3 text-sm font-medium text-slate-600 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-all">
                        Cancel
                    </a>
                    <button type="submit" class="group relative px-8 py-3 text-sm font-semibold text-white bg-gradient-to-r from-slate-800 to-slate-900 rounded-xl hover:from-slate-700 hover:to-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 shadow-lg shadow-slate-900/20 transition-all overflow-hidden">
                        <span class="relative z-10 flex items-center">
                            <svg class="w-5 h-5 mr-2 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            Borrow Selected Book
                        </span>
                    </button>
                </div>
            @endif
        </form>
    </div>

    <script>
        // Book search functionality
        document.getElementById('book-search').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const bookItems = document.querySelectorAll('.book-item');
            const noResults = document.getElementById('no-results');
            let visibleCount = 0;

            bookItems.forEach(function(item) {
                const title = item.getAttribute('data-title');
                const author = item.getAttribute('data-author');
                
                if (title.includes(searchTerm) || author.includes(searchTerm)) {
                    item.style.display = 'flex';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            if (visibleCount === 0 && searchTerm !== '') {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        });

        // Update selection visual
        document.querySelectorAll('input[name="book_id"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.book-item').forEach(function(item) {
                    item.classList.remove('border-slate-900', 'ring-1', 'ring-slate-900');
                });
                
                if (this.checked) {
                    this.closest('.book-item').classList.add('border-slate-900', 'ring-1', 'ring-slate-900');
                    // Also update the checkbox visual
                    document.querySelectorAll('.book-item .absolute > svg').forEach(function(svg) {
                        svg.classList.add('opacity-0');
                    });
                    this.closest('.book-item').querySelector('.absolute > svg').classList.remove('opacity-0');
                }
            });
        });

        // Initialize: highlight selected book if any
        document.addEventListener('DOMContentLoaded', function() {
            const checkedRadio = document.querySelector('input[name="book_id"]:checked');
            if (checkedRadio) {
                checkedRadio.closest('.book-item').classList.add('border-slate-900', 'ring-1', 'ring-slate-900');
                checkedRadio.closest('.book-item').querySelector('.absolute > svg').classList.remove('opacity-0');
            }
        });
    </script>
@endsection
