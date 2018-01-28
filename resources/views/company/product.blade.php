@extends('company.layout')

@section('layout_css')
@endsection

@section('layout_js')
@endsection

@section('content')
    <table class="striped">
        <thead>
        <tr>
            <th>画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>1クリック単価</th>
            <th>編集</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($products as $product)
            <tr>
                <td><img style="height: 50px;" src="{{{$product->image}}}"></td>
                <td>{{$product->name}}</td>
                <td>{{number_format($product->price)}}円</td>
                <td>{{number_format($product->click_price)}}円</td>
                <td data-product="{{$product->id}}"><button data-target="modal1" class="btn modal-trigger">Modal</button></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Modal Structure -->
    <div id="modal1" class="modal row">
        <div class="modal-content">
            <div class="chart-container" class="col s12" style="position: relative;">
                <canvas id="chart"></canvas>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">閉じる</a>
        </div>
    </div>
    <script type="text/javascript" src="{{{'/js/chart/Chart.min.js'}}}"></script>
    <script type="text/javascript"  src="{{{'/js/company/chart.js'}}}"></script>
    {{ $products->links() }}
@endsection