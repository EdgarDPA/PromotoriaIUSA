@extends('promotor.layouts.main')
@section('content')
 <div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <h4 class="page-title"><i class="fa fa-upload"></i><span> Cargar CSV INEGI</span></h4>
                        <ol class="breadcrumb float-right">
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div id="app">
                <subir-csv-component></subir-csv-component>
            </div>
        </div>
    </div>
    <footer class="footer">
        2020 © Grupo IUSA.
    </footer>
 </div>
@endsection