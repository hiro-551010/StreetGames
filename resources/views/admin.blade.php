{{-- {{ $entries[0]['join'] }} --}}

{{-- @if ($entries[0]['join'] === 2)
    参加しています
@elseif($entries[0]['join'] === 1)
    応募しています
@else
    抽選に当たりませんでした
@endif --}}

{{-- {{$entries}}
{{ $entries[0]['tournaments'] }} --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    adminページ
    ここではentriesのテーブルのjoinを変更し、playersテーブルに反映させます
    entriesのjoinは0は抽選落ち、1は応募中、2は参加確定


    <h2>応募者のいる大会一覧</h2>
    @foreach ($entries as $entry)
        <div class="card border-primary mb-3" style="max-width: 18rem;">
            <div class="card-header">大会名: {{$entry['tournaments']['explanation']}}</div>
            <div class="card-body text-primary">
            <div class="card-text">
                <form action="{{route('admin_post')}}" method="POST">
                    @csrf
                    <input type="hidden" name="hold_id" value="{{ $entry['hold_id'] }}">
                    <input type="hidden" name="people" value="{{ $entry['people'] }}">
                    <button type="submit">抽選</button>
                </form>
            </div>
            </div>
        </div>
    @endforeach
</div>
</body>
</html>