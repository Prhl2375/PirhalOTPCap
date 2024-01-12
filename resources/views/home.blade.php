<!doctype html>
<html lang="en">
<head>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <link rel="stylesheet" href="css/classic.css">
    <link rel="stylesheet" href="css/classic.date.css">

    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
<h1>{{$name}}</h1>
<div class="container text-left">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <form action="#" onsubmit="benchmarkDates()" class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="input_from">From</label>
                        <input type="text" class="form-control" id="input_from" placeholder="Start Date">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="input_to">To</label>
                        <input type="text" class="form-control" id="input_to" placeholder="End Date">
                    </div>
                </div>
                <button class="go_date_button">Show benchmarks</button>
            </form>
        </div>
    </div>
</div>

<section class="main_section">
    <table class="table instruments_table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">type</th>
            <th scope="col">exposure</th>
        </tr>
        </thead>
        <tbody>
        @php
        $i = 1;
        @endphp
        @foreach($instruments as $instrument)
            <tr>
                <th scope="row">{{$i}}</th>
                <td>{{$instrument['type']}}</td>
                <td>{{$instrument['exposure']}}</td>
            </tr>
            @php
            $i++;
            @endphp
        @endforeach
        </tbody>
    </table>

    <table class="table benchmarks_table">
        <thead>
            <tr>
                <th>Index</th>
            </tr>
        </thead>
        <thead>
        <tr>
            <th scope="col">date</th>
            <th scope="col">benchmark index</th>
            <th scope="col">daily growth</th>
        </tr>
        </thead>
        <tbody>
        @foreach($benchmarks as $benchmark)
            <tr>
                <td>{{$benchmark['date']}}</td>
                <td>{{$benchmark['benchmark_index']}}</td>
                @if($benchmark['daily_growth']>0)
                    <td class="text-success">{{$benchmark['daily_growth']}}</td>
                @else
                    <td class="text-danger">{{$benchmark['daily_growth']}}</td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</section>


<div class="pagination_bar">
    {{ $benchmarks->links('pagination::bootstrap-4') }}
</div>

<script>
    // Get the current URL
    let currentURL = new URL(window.location.href);

    // Create a URLSearchParams object from the current query string
    let params = new URLSearchParams(currentURL.search);

    // Set or update the query parameter
    params.set('benchmarkName', '{{$queryName}}');

    // Update the URL without reloading the page
    currentURL.search = params.toString();
    history.pushState({}, '', currentURL.toString());


</script>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/picker.js"></script>
<script src="js/picker.date.js"></script>

<script src="js/main.js"></script>
</body>
</html>
