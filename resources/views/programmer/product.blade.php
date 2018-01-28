@extends('programmer.layout')

@section('js')
    <script>
        $('.modal').modal({
                dismissible: true, // Modal can be dismissed by clicking outside of the modal
                opacity: .5, // Opacity of modal background
                inDuration: 300, // Transition in duration
                outDuration: 200, // Transition out duration
                startingTop: '4%', // Starting top style attribute
                endingTop: '10%', // Ending top style attribute
                ready: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.
                    alert("Ready");
                    console.log(modal, trigger);
                },
                complete: function() { alert('Closed'); } // Callback for Modal close
            }
        );
        {{$}}
        $(document).ready(function(){
            // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
            $('.modal').modal();
        });

        $('#modal1').modal('open');
        $('#modal1').modal('close');

        $(function(){
            $('#img').cropper(options);

            $("#profile-image").change(function(){
                // ファイル選択変更時に、選択した画像をCropperに設定する
                $('#img').cropper('replace', URL.createObjectURL(this.files[0]));
            });
        });
    </script>
@endsection

@section('css')
    <style>
        .text_area textarea{
            resize:none;
        }
    </style>

@endsection

@section('content')
    <table class="striped">
        <thead>
            <tr>
                <th>画像</th>
                <th>商品名</th>
                <th>販売会社</th>　
                <th>価格</th>
                <th>1クリック単価</th>
                <th>編集</th>
            </tr>
        </thead>
        <tbody>
        {{Debugbar::addMessage($products)}}
            @foreach ($products as $product)
                <tr>
                    <td><img style="height: 50px;" src="{{{$product->image}}}"></td>
                    <td>{{$product->pname}}</td>
                    <td>{{$product->cname}}</td>
                    <td>{{$product->price}}</td>
                    <td>{{$product->click_price}}</td>
                    <td><a class="waves-effect waves-light btn modal-trigger" href="/programmer/product/{{$product->pid}}">Modal</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $products->links() }}
@endsection