@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2>{{ $questionnaire->intitule }}</h2>
            <button id="generatePdfBtn" class="btn btn-danger"><i class="bi bi-file-earmark-arrow-down">Export PDF</i></button>
        </div>
        <p>{{ $questionnaire->description }}</p>

        <!-- Le reste du contenu du dashboard -->
    </div>

    @foreach($data as $questionData)
        <div class="card mb-5">
            <div class="card-header">
                {{ $questionData['question'] }}
            </div>
            <div class="card-body">
                <blockquote class="blockquote mb-0 d-flex" style="justify-content: space-between">
                    <div style="width: 256px;height: 256px;">
                        <canvas id="bar-chart-{{ $questionData['id'] }}"></canvas>
                    </div>
                    <div style="width: 256px;height: 256px;">
                        <canvas id="doughnut-chart-{{ $questionData['id'] }}"></canvas>
                    </div>
                    <div style="width: 256px;height: 256px;">
                        <canvas id="pie-chart-{{ $questionData['id'] }}"></canvas>
                    </div>
                </blockquote>
            </div>
        </div>
    @endforeach

    <div class="mt-5">
        <h3>Frequency of Responses</h3>
        <canvas id="histogram-chart"></canvas>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {
    @foreach($data as $questionData)
        const barCtx{{ $questionData['id'] }} = document.getElementById('bar-chart-{{ $questionData['id'] }}').getContext('2d');
        new Chart(barCtx{{ $questionData['id'] }}, {
            type: 'bar',
            data: {
                labels: @json(array_column($questionData['data'], 'choix')),
                datasets: [{
                    label: 'Responses',
                    data: @json(array_column($questionData['data'], 'count')),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        display: true,
                        color: 'black',
                        align: 'center',
                        anchor: 'center',
                        formatter: function(value) {
                            return value;
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        const doughnutCtx{{ $questionData['id'] }} = document.getElementById('doughnut-chart-{{ $questionData['id'] }}').getContext('2d');
        new Chart(doughnutCtx{{ $questionData['id'] }}, {
            type: 'doughnut',
            data: {
                labels: @json(array_column($questionData['data'], 'choix')),
                datasets: [{
                    label: 'Responses',
                    data: @json(array_column($questionData['data'], 'count')),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(144, 30, 40, 0.2)',
                        'rgba(99, 159, 10, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(144, 30, 40, 1)',
                        'rgba(99, 159, 10, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        display: true,
                        color: 'black',
                        formatter: function(value) {
                            if(value != 0){
                            return value;}
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        const pieCtx{{ $questionData['id'] }} = document.getElementById('pie-chart-{{ $questionData['id'] }}').getContext('2d');
        new Chart(pieCtx{{ $questionData['id'] }}, {
            type: 'pie',
            data: {
                labels: @json(array_column($questionData['data'], 'choix')),
                datasets: [{
                    label: 'Responses',
                    data: @json(array_column($questionData['data'], 'count')),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(144, 30, 40, 0.2)',
                        'rgba(99, 159, 10, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(144, 30, 40, 1)',
                        'rgba(99, 159, 10, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        display: true,
                        color: 'black',
                        formatter: function(value) {
                            if(value != 0){
                            return value;}
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    @endforeach

    const histogramCtx = document.getElementById('histogram-chart').getContext('2d');
    new Chart(histogramCtx, {
        type: 'bar',
        data: {
            labels: @json(array_keys($frequencyData)),
            datasets: [{
                label: 'Responses Frequency',
                data: @json(array_values($frequencyData)),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                datalabels: {
                    display: true,
                    color: 'black',
                    align: 'end',
                    anchor: 'end',
                    formatter: function(value) {
                        if(value != 0){
                        return value;}
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
        plugins: [ChartDataLabels]
    });
});
</script>
<script defer>
    document.addEventListener('DOMContentLoaded', function () {
        function getBase64Image(chart) {
            console.log("Gendsgfgdfgfded");
            return chart.toDataURL('image/png');
        }

        document.getElementById('generatePdfBtn').addEventListener('click', function () {
            console.log("Generate PDF button clicked");
            var charts = [];
            document.querySelectorAll('canvas').forEach(function (canvas) {
                var chartBase64 = getBase64Image(canvas);
                charts.push(chartBase64);
            });

            fetch('/questionnaire/{{ $questionnaire->id }}/generate-pdf', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    charts: charts
                })
            })
            .then(response => response.blob())
            .then(blob => {
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'questionnaire_report.pdf';
                link.click();
            })
            .catch(error => console.error('Error generating PDF:', error));
        });
    });
</script>
@endsection
