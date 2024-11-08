@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2>{{ $questionnaire->intitule }} : {{ count($data) }} user(s)</h2>
            <div class="d-flex">
                <button id="generatePdfBtn" class="btn btn-danger"><i class="bi bi-file-earmark-arrow-down">Export PDF</i></button>
                <a href="{{ route('questionnaire.exportExcel', $questionnaire->id) }}" class="btn btn-success ms-2"><i class="bi bi-file-earmark-spreadsheet-fill"> Export Excel</i></a>
            </div>
        </div>
        <p>{{ $questionnaire->description }}</p>
    </div>

    @foreach($data as $questionData)
        <div class="card mb-5">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div> {{ $questionData['question'] }} : <strong>{{ $questionData['responses_count'] }} responses</strong></div>
                <div>
                    <button class="btn btn-outline-primary btn-sm" onclick="toggleView('chart', {{ $questionData['id'] }})">
                        📊 Data
                    </button>
                    <button class="btn btn-outline-secondary btn-sm ms-1" onclick="toggleView('frequency', {{ $questionData['id'] }})">
                        ⌚ Period
                    </button>
                </div>
            </div>

            @if($questionData['type'] === 'numericrange')
                <!-- Graphique pour les questions de type numericrange -->
                <div class="card-body" id="chart-view-{{ $questionData['id'] }}" style="display: block;">
                    <div style="width: 256px;height: 256px;">
                        <canvas id="numericrange-chart-{{ $questionData['id'] }}"></canvas>
                    </div>
                </div>
            @else
                <!-- Default Chart View (Graphs) -->
                <div class="card-body" id="chart-view-{{ $questionData['id'] }}" style="display: block;">
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
            @endif

            <!-- Frequency Chart View -->
            <div class="card-body" id="frequency-view-{{ $questionData['id'] }}" style="display: none;">
                <h6>Daily Responses Frequency</h6>
                <canvas id="frequency-question-chart-{{ $questionData['id'] }}"></canvas>
            </div>
        </div>
    @endforeach

    <div class="mt-5">
        <h3>Overall Frequency of Responses</h3>
        <canvas id="frequency-chart"></canvas>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script>
 function toggleView(view, questionId) {
        document.getElementById(`chart-view-${questionId}`).style.display = view === 'chart' ? 'block' : 'none';
        document.getElementById(`frequency-view-${questionId}`).style.display = view === 'frequency' ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', function () {
    @foreach($data as $questionData)
        (function() {
            const questionId = {{ $questionData['id'] }};

            // Couleurs personnalisées
            const colors = {
                background: [
                    'rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)'
                ],
                border: [
                    'rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'
                ]
            };

            // Données pour les labels et valeurs pour chaque question
            const labels = @json(array_column($questionData['data'], 'choix') ?? []);
            const dataValues = @json(array_column($questionData['data'], 'count') ?? []);

            if ('{{ $questionData['type'] }}' === 'numericrange') {
                // Graphique pour le type numericrange
                const numericrangeCanvas = document.getElementById(`numericrange-chart-${questionId}`);
                if (numericrangeCanvas) {
                    const numericrangeCtx = numericrangeCanvas.getContext('2d');
                    new Chart(numericrangeCtx, {
                        type: 'bar',
                        data: {
                            labels: @json(array_keys($questionData['data']['numeric_values'] ?? [])),
                            datasets: [{
                                label: 'Responses',
                                data: @json(array_values($questionData['data']['numeric_values'] ?? [])),
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            plugins: { datalabels: { display: true, color: 'black' } },
                            scales: { y: { beginAtZero: true } }
                        },
                        plugins: [ChartDataLabels]
                    });
                }
            }

            // Initialiser le graphique en barres
            const barCanvas = document.getElementById(`bar-chart-${questionId}`);
            if (barCanvas) {
                const barCtx = barCanvas.getContext('2d');
                new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Responses',
                            data: dataValues,
                            backgroundColor: colors.background,
                            borderColor: colors.border,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        plugins: { datalabels: { display: true, color: 'black' } },
                        scales: { y: { beginAtZero: true } }
                    },
                    plugins: [ChartDataLabels]
                });
            }

            // Initialiser le graphique en beignet
            const doughnutCanvas = document.getElementById(`doughnut-chart-${questionId}`);
            if (doughnutCanvas) {
                const doughnutCtx = doughnutCanvas.getContext('2d');
                new Chart(doughnutCtx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Responses',
                            data: dataValues,
                            backgroundColor: colors.background,
                            borderColor: colors.border,
                            borderWidth: 1
                        }]
                    },
                    plugins: [ChartDataLabels]
                });
            }

            // Initialiser le graphique en secteurs (pie)
            const pieCanvas = document.getElementById(`pie-chart-${questionId}`);
            if (pieCanvas) {
                const pieCtx = pieCanvas.getContext('2d');
                new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Responses',
                            data: dataValues,
                            backgroundColor: colors.background,
                            borderColor: colors.border,
                            borderWidth: 1
                        }]
                    },
                    plugins: [ChartDataLabels]
                });
            }

            // Initialiser le graphique de fréquence par question (line)
            const frequencyQuestionCanvas = document.getElementById(`frequency-question-chart-${questionId}`);
            if (frequencyQuestionCanvas) {
                const frequencyQuestionCtx = frequencyQuestionCanvas.getContext('2d');
                const frequencyDatasets = [];

                let colorIndex = 0;

                @foreach($frequencyData[$questionData['id']] ?? [] as $choix => $dailyData)
                    frequencyDatasets.push({
                        label: '{{ $choix }}',
                        data: @json(array_values($dailyData)),
                        borderColor: colors.border[colorIndex % colors.border.length],
                        backgroundColor: colors.background[colorIndex % colors.background.length],
                        fill: false,
                        tension: 0.1
                    });
                    colorIndex++;
                @endforeach

                new Chart(frequencyQuestionCtx, {
                    type: 'line',
                    data: {
                        labels: @json(array_keys($frequencyData[$questionData['id']][array_key_first($frequencyData[$questionData['id']])] ?? [])),
                        datasets: frequencyDatasets
                    },
                    options: {
                        plugins: {
                            datalabels: {
                                display: true,
                                color: 'black',
                                anchor: 'end'
                            }
                        },
                        scales: { y: { beginAtZero: true } }
                    }
                });
            }
        })(); // Fin de la fonction auto-invoquée pour chaque question

    @endforeach
});

document.addEventListener('DOMContentLoaded', function () {
    const frequencyCtx = document.getElementById('frequency-chart').getContext('2d');

    if (frequencyCtx) {
        new Chart(frequencyCtx, {
            type: 'line',
            data: {
                labels: @json(array_keys($overallFrequencyData)),
                datasets: [{
                    label: 'Overall Responses Frequency',
                    data: @json(array_values($overallFrequencyData)),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
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
                            return value !== 0 ? value : '';
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            },
            plugins: [ChartDataLabels]
        });
    }
});

</script>
<script defer>
    document.addEventListener('DOMContentLoaded', function () {
        function getBase64Image(chart) {
            return chart.toDataURL('image/png');
        }

        document.getElementById('generatePdfBtn').addEventListener('click', function () {
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
                body: JSON.stringify({ charts: charts })
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
