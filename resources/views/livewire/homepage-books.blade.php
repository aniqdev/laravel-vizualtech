<div>
    {{ $books->links() }}
    <div class="list-group mb-3">
        @foreach($books as $book)
          <a href="#" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ $book->title }}</h5>
              <small>Publisher: {{ $book->publisher->name }}</small>
            </div>
            <p class="mb-1">Authors: {{ $book->authors->implode('name', ', ') }}</p>
            {{-- <small>{{ $book->publisher->name }}</small> --}}
          </a>
        @endforeach
    </div>
    {{ $books->links() }}
</div>