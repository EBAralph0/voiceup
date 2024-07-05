@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $questionnaire->intitule }}</h2>
    <p>{{ $questionnaire->description }}</p>

    @foreach($data as $questionData)
        <div class="card mb-5">
            <div class="card-header">
                {{ $questionData['question'] }}
            </div>
            <div class="card-body">
                <blockquote class="blockquote mb-0 d-flex" style="justify-content: space-between">
                    <div style="width: 256px;height: 256px;">
                        <canvas id="bar-chart-{{ Str::slug($questionData['question']) }}"></canvas>
                    </div>
                    <div style="width: 256px;height: 256px;">
                        <canvas id="doughnut-chart-{{ Str::slug($questionData['question']) }}"></canvas>
                    </div>
                    <div style="width: 256px;height: 256px;">
                        <canvas id="pie-chart-{{ Str::slug($questionData['question']) }}"></canvas>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    @foreach($data as $questionData)
        const barCtx{{ Str::slug($questionData['question']) }} = document.getElementById('bar-chart-{{ Str::slug($questionData['question']) }}').getContext('2d');
        new Chart(barCtx{{ Str::slug($questionData['question']) }}, {
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
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const doughnutCtx{{ Str::slug($questionData['question']) }} = document.getElementById('doughnut-chart-{{ Str::slug($questionData['question']) }}').getContext('2d');
        new Chart(doughnutCtx{{ Str::slug($questionData['question']) }}, {
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
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });

        const pieCtx{{ Str::slug($questionData['question']) }} = document.getElementById('pie-chart-{{ Str::slug($questionData['question']) }}').getContext('2d');
        new Chart(pieCtx{{ Str::slug($questionData['question']) }}, {
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
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            }
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
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endsection