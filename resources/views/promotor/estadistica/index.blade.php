@extends('promotor.layouts.main')
@section('content')
 <div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <h4 class="page-title"><i class="fa fa-chart-area"></i><span> Estadística</span></h4>
                        <ol class="breadcrumb float-right">
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div id="app">
                <div class="col-lg-12">
                    <div class="card-box">
                        <h4 class="text-dark  header-title m-t-0 m-b-20">ESTADISTICA</h4>
                        <div class="widget-chart text-center">
                            <div id="dashboard-chart-1" style="height: 550px;">
                                <div id="app">
                                    <fusion-chart-component></fusion-chart-component>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        2020 © Grupo IUSA.
    </footer>
 </div>
@endsection