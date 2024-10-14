<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="<?= base_url('assets') ?>/img/favicon.png">
    <title><?= $title ?? 'CI4' ?></title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="<?= base_url('assets') ?>/css/nucleo-icons.css" rel="stylesheet" />
    <link href="<?= base_url('assets') ?>/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="<?= base_url('assets') ?>/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="<?= base_url('assets') ?>/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('assets') ?>/css/custom.css?v=3">
    <link rel="stylesheet" href="<?= base_url('assets') ?>/css/custom-select2.css?v=3">

    <!-- <link type="text/css" href="<?= base_url('assets') ?>/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link type="text/css" href="<?= base_url('assets') ?>/plugins/select2-develop/dist/css/select2.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    </head>

    <body class="g-sidenav-show   bg-gray-100">
    <div class="min-height-300 bg-primary-blue position-fixed w-100" style="top: 0"></div>

    <!-- sidebar -->
    <?= $this->include('layouts/components/sidebar') ?>

    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        <?= $this->include('layouts/components/header') ?>

        <!-- End Navbar -->
        <div class="container-fluid pb-4">
             <!-- content -->
            <?= $this->renderSection('content') ?>
            
            <?= $this->include('layouts/components/footer') ?>
        </div>
    </main>
    <!-- @include('layouts.component.argon_configuration') -->
    <?php if (session()->has('alert.config')): ?>
        <script>
            Swal.fire(<?= session()->get('alert.config') ?>);
        </script>
        <?php session()->remove('alert.config'); ?>
    <?php endif; ?>
    <!--   Core JS Files   -->
    <script src="<?= base_url('assets') ?>/js/core/popper.min.js"></script>
    <script src="<?= base_url('assets') ?>/js/core/bootstrap.min.js"></script>
    <script src="<?= base_url('assets') ?>/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="<?= base_url('assets') ?>/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="<?= base_url('assets') ?>/js/plugins/chartjs.min.js"></script>
    <script>
        var ctx1 = document.getElementById("chart-line").getContext("2d");

        var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

        gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
        gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
        new Chart(ctx1, {
        type: "line",
        data: {
            labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
            label: "Mobile apps",
            tension: 0.4,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#5e72e4",
            backgroundColor: gradientStroke1,
            borderWidth: 3,
            fill: true,
            data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
            maxBarThickness: 6

            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
            legend: {
                display: false,
            }
            },
            interaction: {
            intersect: false,
            mode: 'index',
            },
            scales: {
            y: {
                grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [5, 5]
                },
                ticks: {
                display: true,
                padding: 10,
                color: '#fbfbfb',
                font: {
                    size: 11,
                    family: "Open Sans",
                    style: 'normal',
                    lineHeight: 2
                },
                }
            },
            x: {
                grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
                borderDash: [5, 5]
                },
                ticks: {
                display: true,
                color: '#ccc',
                padding: 20,
                font: {
                    size: 11,
                    family: "Open Sans",
                    style: 'normal',
                    lineHeight: 2
                },
                }
            },
            },
        },
        });
    </script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="<?= base_url('assets') ?>/js/argon-dashboard.min.js?v=2.0.4"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="<?= base_url('assets') ?>/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets') ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script> -->
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script src="<?= base_url('assets') ?>/plugins/select2-develop/dist/js/select2.full.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="<?= base_url('assets') ?>/js/basic-select2.js"></script>
    <script src="<?= base_url('assets') ?>/js/basic-flatpickr.js"></script>
    <?= $this->renderSection('js') ?>
</body>

</html>