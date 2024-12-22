<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <title>Erajaya - Employee</title>
</head>
<body>
<div class="container">
    <h2 class="text-start mt-5 text-uppercase">Erajaya - Claudio Faria</h2>
    <hr class="border border-dark">
    <div class="row">
        <div class="col-8">
            <canvas id="employeeChart"></canvas>
        </div>
        <div class="col-2">
            <span class="fs-6 fw-medium mb-3">Pilih Period</span>
            <select id="selectPeriod" class="form-select" name="period">
            </select>
        </div>
        <div class="col-2">
            <span class="fs-6 fw-medium mb-3">Pilih Tags</span> <br>
            <input name="selector[]" id="tags1" class="tags" type="checkbox" value="Company" />
            <label for="tags1">Company</label><br>
            <input name="selector[]" id="tags2" class="tags" type="checkbox" value="Level" />
            <label for="tags2">Level</label><br>
            <input name="selector[]" id="tags3" class="tags" type="checkbox" value="Gender" />
            <label for="tags3">Gender</label><br>
            <input name="selector[]" id="tags4" class="tags" type="checkbox" value="Division" />
            <label for="tags4">Division</label><br>
        </div>
    </div>
    <div id="employeeCount" class="mt-3"></div>
    <hr class="border border-dark">
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#selectPeriod').select2({
            minimumResultsForSearch: Infinity,
            placeholder: 'Pilih Periode',
            ajax: {
                url: "{{ route('getPeriod') }}",
                dataType: "json",
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.period,
                                text: item.period
                            };
                        })
                    };
                },
                cache: true
            }
        });

        const ctx = document.getElementById('employeeChart').getContext('2d');
        const employeeChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Jumlah Karyawan',
                    data: [],
                    backgroundColor: 'rgba( 75, 192, 192, 0.2)',
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

        $('#selectPeriod').on('change', function() {
            updateEmployeeCount();
        });

        $('.tags').on('change', function() {
            updateEmployeeCount();
        });

        function updateEmployeeCount() {
            var selectedPeriod = $('#selectPeriod').val();
            var selectedTags = $('.tags:checked').map(function() {
                return $(this).val();
            }).get();

            if (selectedPeriod || selectedTags.length > 0) {
                $.ajax({
                    url: "{{ route('getEmployeeCount') }}",
                    type: 'GET',
                    data: {
                        period: selectedPeriod,
                        tags: selectedTags
                    },
                    dataType: 'json',
                    success: function (data) {
                        $('#employeeCount').html('Number of Employees: ' + data.count);
                        employeeChart.data.labels = [selectedPeriod];
                        employeeChart.data.datasets[0].data = [data.count];
                        employeeChart.update();
                    },
                })
            }
        }
    });
</script>
</body>
</html>
