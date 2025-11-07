@extends('layouts.app')

@section('content')




    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-rounded">
              <div class="card-body">
                <h4 class="card-title">sexo</h4>
                <p class="card-description">Bienvenido al sistema OpcionHelp</p>
                <div class="row grow">
                  <div class="col-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-lg-12 text-center">
                            <h4 class="card-title card-title-dash mb-3">Type By Amount</h4>
                            <div class="chart-container">
                              <canvas id="doughnutChart"></canvas>
                            </div>
                            <div id="doughnutChart-legend" class="mt-3 text-center"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> 
              </div>
            </div>
          </div>
        </div>
      </div>




@endsection
