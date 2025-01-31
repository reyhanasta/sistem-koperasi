@extends('layouts.template')
@section('title','Home')
@section('content')

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <ul>
        {{-- @foreach ($notifications as $notification)
            <li>
                {{ $notification->data['message'] }}
                dibuat pada {{ $notification->data['peminjaman_created_at'] }}
            </li>
        @endforeach --}}
    </ul>
    </div>
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{ $totalNasabah }}</h3>
            <p>Nasabah Baru</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="{{route('nasabah.index')}}" class="small-box-footer">More info <i
              class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>Rp. {{ number_Format($totalPinjaman) }}
            </h3>

            <p>Total Uang beredar</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>
              Rp. {{ number_Format($totalTabungan) }}
            </h3>
            <p>Total Simpanan</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{ $monthlyAccLoans }}</h3>
            <p>Pinjaman Diterima Bulan ini</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>
    <!-- /.row -->
  </div>

  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="border-0 card-header">
          <div class="d-flex justify-content-between">
            <h3 class="card-title">Grafik Peminjaman</h3>
            <a href="javascript:void(0);">View Report</a>
          </div>
        </div>
        <div class="card-body">
          <div class="d-flex">
            <p class="d-flex flex-column">
              <span class="text-lg text-bold">Rp.{{ number_format($totalPinjamanYTD, 2) }}</span>
              <span>Total Pinjaman Per Tahun</span>
            </p>
            <p class="ml-auto text-right d-flex flex-column">
              @if ($increasePercentage > 0)
              <span class="text-success">
                <i class="fas fa-arrow-up"></i> {{ number_format($increasePercentage, 2) }}%
              </span>
              <span class="text-muted">Since last month</span>
            @elseif ($increasePercentage < 0)
              <span class="text-danger">
                <i class="fas fa-arrow-down"></i> {{ number_format($increasePercentage, 2) }}%
              </span>
              <span class="text-muted">Since last month</span>
            @else
              <span class="text-gray">
                {{ number_format($increasePercentage, 2) }}%
              </span>
              <span class="text-muted">Dari bulan sebelumnya</span>
            @endif
            </p>
          </div>
          <!-- /.d-flex -->

          <div class="mb-4 position-relative">
            <canvas id="monthlyLoansChart" height="115"></canvas>
          </div>

          <div class="flex-row d-flex justify-content-end">
            <span class="mr-2">
              <i class="fas fa-square text-primary"></i> This year
            </span>

            <span>
              <i class="fas fa-square text-gray"></i> Last year
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card">
        <div class="border-0 card-header">
          <div class="d-flex justify-content-between">
            <h3 class="card-title">Grafik Nasabah</h3>
            <a href="javascript:void(0);">View Report</a>
          </div>
        </div>
        <div class="card-body">
          <div class="d-flex">
            <p class="d-flex flex-column">
              <span class="text-lg text-bold">{{ number_format($averageNasabahPerMonth) }} Orang</span>
              <span>Rata-rata Nasabah Per Bulan</span>
           
          
            </p>
            <p class="ml-auto text-right d-flex flex-column">
              @if ($increasePercentageNasabah > 0)
              <span class="text-success">
                <i class="fas fa-arrow-up"></i> {{ number_format($increasePercentageNasabah, 2) }}%
              </span>
              <span class="text-muted">Dari bulan sebelumnya</span>
            @elseif ($increasePercentageNasabah < 0)
              <span class="text-danger">
                <i class="fas fa-arrow-down"></i> {{ number_format($increasePercentageNasabah, 2) }}%
              </span>
              <span class="text-muted">Dari bulan sebelumnya</span>
            @else
              <span class="text-gray">
                {{ number_format($increasePercentageNasabah, 2) }}%
              </span>
              <span class="text-muted">Dari bulan sebelumnya</span>
            @endif
            </p>
          </div>
          <!-- /.d-flex -->

          <div class="mb-4 position-relative">
            <canvas id="monthlyNasabahChart" height="115"></canvas>
          </div>

          <div class="flex-row d-flex justify-content-end">
            <span class="mr-2">
              <i class="fas fa-square text-primary"></i> This year
            </span>

            <span>
              <i class="fas fa-square text-gray"></i> Last year
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var ctx = document.getElementById('monthlyLoansChart').getContext('2d');
    var monthlyLoansChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
          label: 'Total Peminjaman Bulanan',
          data: @json(array_values($monthlyLoans)),
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
  });
  document.addEventListener('DOMContentLoaded', function () {
    var ctx = document.getElementById('monthlyNasabahChart').getContext('2d');
    var monhlyNasabahChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
          label: 'Total Nasbah Bulanan',
          data: @json(array_values($monthlyNasabah)),
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
  });
</script>