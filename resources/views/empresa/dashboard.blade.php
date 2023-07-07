
@extends('layout.appEmpresa')
@section('title','Dashboard')
@section('content')


<section class="content">
    <Dashboard-component
    :countusers="{{$countusers}}"
    :countclientes="{{$countclientes}}"
    :countarmazens="{{$countarmazens}}"
    :countfornecedores="{{$countfornecedores}}"
    :countfabricantes="{{$countfabricantes}}"
    :countbancos="{{$countbancos}}"
    :countprodutos="{{$countprodutos}}"
    :countvendas="{{$countvendas}}"
    :counttotalvendas="{{$counttotalvendas}}"
    :vendasmensal="{{$vendasmensal}}"
    :auth="{{$auth}}" :guard="{{$guard}}">


</Dashboard-component>
</section>
@endsection
@section('css_dashboard')
    <link rel="stylesheet" href="{{asset('assets/template/dashboard.css')}}">
@endsection


@section('js_dashboard')
    <!-- Scripts para gráficos estatisticos do dashboard -->
    <script src="{{ asset('assets/js/jquery.easypiechart.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.sparkline.index.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.flot.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.flot.pie.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.flot.resize.min.js')}}"></script>
    <!-- Scripts fim para gráficos estatisticos do dashboard -->

      <!-- Scripts para gráficos estatisticos do dashboard -->
      <script>
        (function() {

            var vendas = <?=json_encode($produtoMaisVendido)?>;
            var data = []

            vendas.forEach(venda => {
                const descricao = venda.descricao_produto.toUpperCase();
                data.push(
                    {
                        label:descricao.slice(0,30),
                        data:venda.quantidade
                    })

            });
            //flot chart resize plugin, somehow manipulates default browser resize event to optimize it!
            //but sometimes it brings up errors with normal resize event handlers

            var placeholder = $('#piechart-placeholder').css({
                'width': '90%',
                'min-height': '150px'
            });


            function drawPieChart(placeholder, data, position) {
                $.plot(placeholder, data, {
                    series: {
                        pie: {
                            show: true,
                            tilt: 0.8,
                            highlight: {
                                opacity: 0.25
                            },
                            stroke: {
                                color: '#fff',
                                width: 2
                            },
                            startAngle: 2
                        }
                    },
                    legend: {
                        show: true,
                        position: position || "ne",
                        labelBoxBorderColor: null,
                        margin: [-30, 15]
                    },
                    grid: {
                        hoverable: true,
                        clickable: true
                    }
                })
            }
            drawPieChart(placeholder, data);

            /**
            we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
            so that's not needed actually.
            */
            placeholder.data('chart', data);
            placeholder.data('draw', drawPieChart);



        })();
      </script>
    <!-- Scripts para gráficos estatisticos do dashboard fim -->
@endsection

