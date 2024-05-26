<a href="{{ route('manga.show', ['id' => $manga->id]) }}" class="card text-decoration-none bg-dark text-light">
    <div class="card-body">
        <h5 class="card-title text-light">{{ $manga->title }}</h5>
        <div class="mb-3">
            <img src="{{ $manga->image_path }}" class="img-fluid rounded" alt="{{ $manga->title }}">
        </div>
        <p class="card-text">Автор: {{ $manga->author_name }}</p>
        <p class="card-text">Дата выпуска: {{ $manga->release_date }}</p>
        <p class="card-text">Жанры: {{ $manga->genre_names }}</p>
        <p class="card-text">{{ mb_substr($manga->description, 0, 55) }}...</p>
    </div>
</a>
