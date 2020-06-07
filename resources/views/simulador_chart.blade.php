@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <canvas id="canvasQty"></canvas>
            <canvas id="canvasLQty"></canvas>
            <canvas id="canvasCQty"></canvas>
            <canvas id="canvasO"></canvas>
        </div>
    </div>
</div>
<script>
    var MONTHS = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    var config = {
        type: 'line',
        data: {
            labels: ['Octubre', 'Noviembre', 'Diciembre', 'Enero', 'Febrero', 'Marzo'],
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
            labels: ['Octubre', 'Noviembre', 'Diciembre', 'Enero', 'Febrero', 'Marzo'],
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
            labels: ['Octubre', 'Noviembre', 'Diciembre', 'Enero', 'Febrero', 'Marzo'],
            datasets: [{
                label: 'Cochinillas en Cáliz',
                backgroundColor: window.chartColors.red,
                borderColor: window.chartColors.red,
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
            labels: ['Octubre', 'Noviembre', 'Diciembre', 'Enero', 'Febrero', 'Marzo'],
            datasets: [{
                label: 'Porcentaje de Fruta Ocupado',
                backgroundColor: window.chartColors.blue,
                borderColor: window.chartColors.blue,
                data: {!! $simulation->getPropertyPerPeriod('occupiedfruitPercentage') !!},
                fill: false,
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Fruta Ocupada'
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
                        labelString: 'Porcentaje'
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

        var ctx = document.getElementById('canvasO').getContext('2d');
        window.myLine = new Chart(ctx, config4);
    };

    var colorNames = Object.keys(window.chartColors);
</script>
@endsection