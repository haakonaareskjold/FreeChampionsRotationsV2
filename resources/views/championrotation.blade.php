<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body>
<div class="flex justify-between flex-wrap bg-slate-300">
@foreach($champions as $champion)
    <div class="max-w-sm w-full rounded overflow-hidden shadow-lg m-4">
                <img class="w-full" src="{{$champion['imageUrl']}}" alt="{{$champion['title']}}">
                <div class="px-6 py-4 bg-slate-200">
                    <div class="font-bold text-xl mb-2">{{$champion['name']}}</div>
                    <p class="text-gray-700 text-base">
                        {{$champion['blurb']}}
                    </p>
                </div>
    </div>
@endforeach
</div>
</body>
</html>
