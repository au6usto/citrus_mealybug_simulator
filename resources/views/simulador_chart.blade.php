@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="alert alert-warning" role="alert">
                Porcentaje invasión frutos después del segundo vuelo: {{ round($simulation->getPropertyPerPeriod('fruitDamaged')[4]) }}%
            </div>
            <div class="alert alert-success" role="alert">
                Porcentaje invasión frutos después del tercer vuelo: {{ round($simulation->getPropertyPerPeriod('fruitDamaged')[5]) }}%
            </div>
            @if (round($simulation->getPropertyPerPeriod('fruitDamaged')[5]) >= 20)
            <h1>Resultado final <span class="badge badge-danger">Deberá iniciar tratamiento químico</span></h1>
            @else
            <h1>Resultado final <span class="badge badge-success">No es necesario que comience un tratamiendo químico</span></h1>
            @endif
        <table class="table table-striped table-bordered table-hover table-sm">
            <thead class="thead-dark">
              <tr>
                <th scope="row">Mes</th>
                  @foreach($simulation->getPropertyPerPeriod('periodMonth') as $key => $month)
                    @if($key !== 2)
                    <th scope="col">{{ $month }}</th>
                    @elseif($key === 1)
                    <th colspan="2" scope="col">{{ $month }}</th>
                    @endif
                  @endforeach
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">Temperatura</th>
                @foreach($simulation->getPropertyPerPeriod('temperature') as $key => $temp)
                @if($key !== 2)
                <td scope="col">{{ $temp }}</td>
                @elseif($key === 1)
                <td colspan="2" scope="col">{{ $temp }}</td>
                @endif
                @endforeach
              </tr>
              <tr class="table-primary">
                  <th scope="row">Vuelo</th>
                @foreach($simulation->getPropertyPerPeriod('periodName') as $key =>  $name)
                @if($key !== 2)
                <td scope="col">{{ $name }}</td>
                @elseif($key === 1)
                <td colspan="2" scope="col">{{ $name }}</td>
                @endif
                @endforeach
              </tr>
              <tr>
                  <th scope="row">Cantidad de Machos</th>
                  @foreach($simulation->getPropertyPerPeriod('maleQty') as $key =>  $amount)
                    @if($key !== 2)
                    <td scope="col">{{ $amount }}</td>
                    @elseif($key === 1)
                    <td colspan="2" scope="col">{{ $amount }}</td>
                    @endif
                  @endforeach
              </tr>
              <tr>
                <th scope="row">Cantidad de Hembras</th>
                @foreach($simulation->getPropertyPerPeriod('femaleQty') as $key =>  $amount)
                  @if($key !== 2)
                  <td scope="col">{{ $amount }}</td>
                  @elseif($key === 1)
                  <td colspan="2" scope="col">{{ $amount }}</td>
                  @endif
                @endforeach
            </tr>
            <tr>
                <th scope="row">Cantidad de Larvas Macho</th>
                @foreach($simulation->getPropertyPerPeriod('maleLarvaeQty') as $key =>  $amount)
                  @if($key !== 2)
                  <td scope="col">{{ $amount }}</td>
                  @elseif($key === 1)
                  <td colspan="2" scope="col">{{ $amount }}</td>
                  @endif
                @endforeach
            </tr>
            <tr>
                <th scope="row">Cantidad de Larvas Hembra</th>
                @foreach($simulation->getPropertyPerPeriod('femaleLarvaeQty') as $key =>  $amount)
                  @if($key !== 2)
                  <td scope="col">{{ $amount }}</td>
                  @elseif($key === 1)
                  <td colspan="2" scope="col">{{ $amount }}</td>
                  @endif
                @endforeach
            </tr>
            <tr>
                <th scope="row">Total Larvas</th>
                @foreach($simulation->getPropertyPerPeriod('totalLarvae') as $key =>  $amount)
                  @if($key !== 2)
                  <td scope="col">{{ $amount }}</td>
                  @elseif($key === 1)
                  <td colspan="2" scope="col">{{ $amount }}</td>
                  @endif
                @endforeach
            </tr>
            <tr>
                <th scope="row">Cantidad de insectos en Cáliz</th>
                @foreach($simulation->getPropertyPerPeriod('insectsInCalyx') as $key =>  $amount)
                  @if($key !== 2)
                  <td scope="col">{{ $amount }}</td>
                  @elseif($key === 1)
                  <td colspan="2" scope="col">{{ $amount }}</td>
                  @endif
                @endforeach
            </tr>
            <tr>
                <th scope="row">Cantidad de Huevos</th>
                @foreach($simulation->getPropertyPerPeriod('eggsTotal') as $key =>  $amount)
                  @if($key !== 2)
                  <td scope="col">{{ $amount }}</td>
                  @elseif($key === 1)
                  <td colspan="2" scope="col">{{ $amount }}</td>
                  @endif
                @endforeach
            </tr>
            <tr>
                <th scope="row">Porcentaje de Insectos en fruto</th>
                @foreach($simulation->getPropertyPerPeriod('occupiedfruitPercentage') as $key =>  $amount)
                  @if($key !== 2)
                  <td scope="col">{{ $amount }}</td>
                  @elseif($key === 1)
                  <td colspan="2" scope="col">{{ $amount }}</td>
                  @endif
                @endforeach
            </tr>
            <tr class="table-danger">
                <th scope="row">Porcentaje de Fruta Dañada</th>
                @foreach($simulation->getPropertyPerPeriod('fruitDamaged') as $key =>  $amount)
                  @if($key !== 2)
                  <td scope="col">{{ $amount }}</td>
                  @elseif($key === 1)
                  <td colspan="2" scope="col">{{ $amount }}</td>
                  @endif
                @endforeach
            </tr>
            </tbody>
          </table>
          <canvas id="canvasQty"></canvas>
                        <canvas id="canvasLQty"></canvas>
                        <canvas id="canvasCQty"></canvas>
                        <canvas id="canvasIC"></canvas>
                        <canvas id="canvasEQty"></canvas>
        </div>
    </div>
</div>
<script>
    var MONTHS = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    var config = {
        type: 'line',
        data: {
            labels: ['Octubre', 'Noviembre', 'Diciembre', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
            datasets: [{
                label: 'Cantidad de Machos',
                backgroundColor: window.chartColors.blue,
                borderColor: window.chartColors.blue,
                data: {!! $simulation->getPropertyPerPeriod('maleQty') !!},
                fill: false,
            },
            {
                label: 'Cantidad de Hembras',
                backgroundColor: window.chartColors.red,
                borderColor: window.chartColors.red,
                data: {!! $simulation->getPropertyPerPeriod('femaleQty') !!},
                fill: false,
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Cochinillas'
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Mes'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Cantidad Cochinillas'
                    }
                }]
            }
        }
    };
    var config2 = {
        type: 'line',
        data: {
            labels: ['Octubre', 'Noviembre', 'Diciembre', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
            datasets: [{
                label: 'Larvas Macho',
                backgroundColor: window.chartColors.blue,
                borderColor: window.chartColors.blue,
                data: {!! $simulation->getPropertyPerPeriod('maleLarvaeQty') !!},
                fill: false,
            },
            {
                label: 'Larvas Hembra',
                backgroundColor: window.chartColors.red,
                borderColor: window.chartColors.red,
                data: {!! $simulation->getPropertyPerPeriod('femaleLarvaeQty') !!},
                fill: false,
            },
            {
                label: 'Total',
                backgroundColor: window.chartColors.green,
                borderColor: window.chartColors.green,
                data: {!! $simulation->getPropertyPerPeriod('totalLarvae') !!},
                fill: false,
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Cantidad de Larvas'
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Mes'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Cantidad de Larvas'
                    }
                }]
            }
        }
    };

    var config3 = {
        type: 'line',
        data: {
            labels: ['Octubre', 'Noviembre', 'Diciembre', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
            datasets: [{
                label: 'Cochinillas en Cáliz',
                backgroundColor: window.chartColors.green,
                borderColor: window.chartColors.green,
                data: {!! $simulation->getPropertyPerPeriod('insectsInCalyx') !!},
                fill: false,
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Insectos en Cáliz'
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Month'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Cantidad en Cáliz'
                    }
                }]
            }
        }
    };

    var config4 = {
        type: 'line',
        data: {
            labels: ['Octubre', 'Noviembre', 'Diciembre', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
            datasets: [{
                label: 'Cantidad de Huevos',
                backgroundColor: window.chartColors.green,
                borderColor: window.chartColors.green,
                data: {!! $simulation->getPropertyPerPeriod('eggsTotal') !!},
                fill: false,
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Huevos'
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Mes'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Cantidad Huevos'
                    }
                }]
            }
        }
    };

    var config5 = {
        type: 'line',
        data: {
            labels: ['Octubre', 'Noviembre', 'Diciembre', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
            datasets: [{
                label: 'Porcentaje de Fruta Ocupado',
                backgroundColor: window.chartColors.green,
                borderColor: window.chartColors.green,
                data: {!! $simulation->getPropertyPerPeriod('occupiedfruitPercentage') !!},
                fill: false,
            },
            {
                label: 'Porcentaje de Fruta Dañada',
                backgroundColor: window.chartColors.red,
                borderColor: window.chartColors.red,
                data: {!! $simulation->getPropertyPerPeriod('fruitDamaged') !!},
                fill: false,
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Insectos en Cáliz'
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Month'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Cantidad en Fruta'
                    }
                }]
            }
        }
    };

    window.onload = function() {
        var ctx = document.getElementById('canvasQty').getContext('2d');
        window.myLine = new Chart(ctx, config);

        var ctx = document.getElementById('canvasLQty').getContext('2d');
        window.myLine = new Chart(ctx, config2);

        var ctx = document.getElementById('canvasCQty').getContext('2d');
        window.myLine = new Chart(ctx, config3);

        var ctx = document.getElementById('canvasEQty').getContext('2d');
        window.myLine = new Chart(ctx, config4);

        var ctx = document.getElementById('canvasIC').getContext('2d');
        window.myLine = new Chart(ctx, config5);

    };

    var colorNames = Object.keys(window.chartColors);
</script>
@endsection