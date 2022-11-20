<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body>
    <div class="flex flex-wrap justify-evenly">
        @foreach($champions as $champion)
        <div class="max-w-sm rounded overflow-hidden shadow-lg m-4">
            <a href="#" data-mdb-ripple="true" data-mdb-ripple-color="light">
                <img class="object-contain h-48 w-full" src="{{$champion['imageUrl']}}" alt="{{$champion['title']}}"/>
            </a>
            <div class="p-6">
                <h5 class="text-gray-900 text- font-medium mb-2">{{$champion['name']}}</h5>
                <p class="text-gray-700 text-base mb-4">
                    {{$champion['blurb']}}
                </p>
            </div>
        </div>
        @endforeach
    </div>
</body>
</html>
