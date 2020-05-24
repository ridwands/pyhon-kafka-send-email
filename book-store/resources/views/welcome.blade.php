<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include ('sniphets.css')
    <title>Home</title>
</head>

<body>
    <div style="margin-top:20px;" class="container">
        @include ('sniphets.navbar')
        @if (session('status'))
        <div class="alert alert-info">
            {{ session('status') }}
        </div>
        @endif
        <div class="row">
            @foreach ($product as $item)
            <div style="margin-bottom: 20px" class="col-sm-4">
                <div class="card" style="width: 18rem;">
                    <img style="height:300px" src="/images/{{$item->product_image}}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h4>{{$item->book_name}}</h4>
                        <p>Rp. {{number_format ($item->book_price,0,',','.')}}</p>
                        @if(session()->has('email'))
                        <button class="edit-modal btn btn-primary" data-name="{{$item->book_name}}"
                            data-price="{{$item->book_price}}">Beli</button>
                        @else
                        <a href="/login" class="btn btn-primary">Beli</a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach

            <div id="editModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Payment Detail</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="/payment" method="POST">
                                {{ csrf_field() }}
                                <label>Book Name</label>
                                <input type="text" name="book_name" id="book_name" class="form-control" readonly />
                                <label>Price</label>
                                <input type="text" name="price" id="book_price" class="form-control" readonly />
                                <label>purchase amount</label>
                                <input type="text" name="amount" id="#" class="form-control" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Buy</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>


            @include ('sniphets.js')
</body>

</html>
