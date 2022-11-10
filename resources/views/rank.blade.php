<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        .table, thead, tbody, tr, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        td, th {
            text-align: center;
            padding: 5px;
        }

    </style>

    {{-- @vite(['resources/css/app.css', 'resource/js/app.js']) --}}
</head>
<body>

    <div style="margin-left: 50px">
            
    <div>
        <table class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Distributor</th>
                <th>Total Sales</th>
              </tr>
            </thead>
            <tbody>
              @for($i = 0; $i < count($longs); $i++)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $longs[$i]->distributor }}</td>
                    <td>&#36;{{ $longs[$i]->total_sales }}</td>
                </tr>
              @endfor
            </tbody>
          </table>
    </div>

    <div class="mt-6 p-4">
        {{$orders->links()}}
    </div>

    </div>


</body>
</html>