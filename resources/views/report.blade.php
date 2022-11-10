
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
    

        input {
            border: 1px solid black;
            padding: 10px;
        }

        button {
            padding: 10px;
            margin-left: 10px;
        }

    </style>

    {{-- @vite(['resources/css/app.css', 'resource/js/app.js']) --}}

    <link rel="stylesheet" href="{{ asset('csp/style.css') }}">

</head>
<body>

    <div style="margin-left: 50px">
            
    <div style="margin-top: 50px; margin-bottom: 30px">
        <form action="/">

                <input
                    type="text"
                    placeholder="Search Distributor..."
                    required
                />

                <input
                    type="text"
                    name="order_date"
                    placeholder="date...."
                    required
                />


                <button
                    type="submit"
                >
                    Search
                </button>
                
            </div>
        </form>
    </div>

    <div>
        <table class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Invioce</th>
                <th>Purchaser</th>
                <th>Distributor</th>
                <th>Referred Distributor</th>
                <th>Order Date</th>
                <th>Order Total</th>
                <th>Percentage</th>
                <th>Commission</th>
                <th>Display</th>
              </tr>
            </thead>
            <tbody>
              @for($i = 0; $i < count($reports); $i++)
                <tr>
                    <td>{{ $i }}</td>
                    <td class="link_id">{{ $reports[$i]->invoice }}</td>
                    <td>{{ $reports[$i]->purchaser }}</td>
                    <td>{{ $reports[$i]->distributor }}</td>
                    <td>{{ $reports[$i]->num_referred_dist }}</td>
                    <td>{{ $reports[$i]->order_date }}</td>
                    <td>{{ $reports[$i]->order_total }}</td>
                    <td>{{ $reports[$i]->percentage }}</td>
                    <td>{{ $reports[$i]->commission }}</td>
                    <td style="cursor: pointer; color: blue" class="btn-save js-open"> View More </td>
                </tr>
              @endfor
            </tbody>
          </table>
    </div>

    <div class="mt-6 p-4">
        {{$orders->links()}}
    </div>

    </div>


    {{-- modal view of invoice --}}
    @include('partials.help');


    <script src="{{ asset('jp/jquery.js') }}"></script>

    @for ($l = 0; $l < count($reports); $l++)
        <script>
            ok_button = document.getElementsByClassName('btn-save')[{{ $l }}];

            ok_button.addEventListener('click', function(){

                invoice = document.getElementsByClassName('link_id')[{{ $l }}].innerHTML

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: "POST",
                    url: "/",
                    data: {
                        "invoice": invoice,
                        "_token": "{{ csrf_token() }}",
                    },
                    datatype: "json",
                    success: function (data) {

                        if(data) {

                            document.getElementById('load').style.display = "none";

                            for(m = 0; m < data.length; m++) {
                                for(w = 0; w < data[m].length; w++) {
                                    
                                    tr = document.createElement('tr');
                                    // td1 = document.createElement('td');
                                    td2 = document.createElement('td');
                                    td3 = document.createElement('td');
                                    td4 = document.createElement('td');
                                    td5 = document.createElement('td');
                                    td6 = document.createElement('td');


                                    // td1.innerText = m;
                                    td2.innerText = data[m][w].sku;
                                    td3.innerText = data[m][w].name;
                                    td4.innerText = data[m][w].price;
                                    td5.innerText = data[m][w].quantity;
                                    td6.innerText =  Number(data[m][w].price) * Number(data[m][w].quantity);

                                    // tr.appendChild(td1);
                                    tr.appendChild(td2);
                                    tr.appendChild(td3);
                                    tr.appendChild(td4);
                                    tr.appendChild(td5);
                                    tr.appendChild(td6);

                                    document.getElementById('tbody').appendChild(tr);

                                }
                            }

                        }
                    }
                });

            })
        </script>
    @endfor

    @for ($l = 0; $l < count($reports); $l++)
        <script>
           function openClean(){
                openBtn = document.getElementsByClassName("js-open")[{{ $l }}];
                modalBg = document.getElementsByClassName("modal-background")[0];
                modalBox = document.getElementsByClassName("modal-box")[0];


                openBtn.addEventListener('click', function(event) {
                    event.preventDefault()

                    invoice = document.getElementsByClassName('link_id')[{{ $l }}].innerHTML

                    document.getElementById('show-invoice').innerHTML = invoice;

                    modalBg.classList.add("active")
                    modalBox.classList.add("active")
                })

                closeBtns = document.querySelectorAll(".js-close");

                closeBtns.forEach(node => {
                    node.addEventListener('click', function(e) {
                        e.preventDefault()


                        document.getElementById('tbody').removeChild(document.getElementById('tbody').firstElementChild);
                        modalBg.classList.remove("active")
                        modalBox.classList.remove("active")

                        document.getElementById('load').style.display = "block";

                    })
                })
           }
           

           openClean();
        </script>
    @endfor

</body>
</html>