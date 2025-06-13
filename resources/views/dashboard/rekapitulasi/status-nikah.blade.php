@extends('dashboard.layouts.main')

@section('main')

<div class="container-fluid">
    <div class="pagetitle">
        <div class="row justify-content-between">
            <div class="col">
                <h1>Rekapitulasi | <small>Pegawai Bedasarkan Status Nikah</small></h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Status Nikah</li>
                    </ol>
                </nav>
            </div>
            <div class="col">
                <div class="text-end">
                    <a href="" type="" target="_blank">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-printer-fill"></i> Print</button></a>
                </div>
            </div>
        </div>
    </div><!-- End Rekapitulasi Status Nikah Title -->

    {{-- Notifikasi jika ada pegawai tanpa Status Nikah --}}
    @if ($pegawaiTanpaStatusNikah > 0)
        <div class="alert alert-success" role="alert">
            <i class="bi bi-info-circle"></i> 
            <strong>Perhatian.</strong> Terdapat <strong>{{ $pegawaiTanpaStatusNikah }}</strong> data pegawai tidak dilengkapi dengan Status Nikah. 
            <a href="#" class="alert-link" data-bs-toggle="modal" data-bs-target="#modalPegawaiTanpaStatusNikah">Lihat detail</a>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modalPegawaiTanpaStatusNikah" tabindex="-1" aria-labelledby="modalPegawaiTanpaStatusNikahLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPegawaiTanpaStatusNikahLabel">Detail Pegawai Tanpa Status Nikah</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataPegawaiTanpaStatusNikah as $index => $pegawai)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $pegawai->nip }}</td>
                                        <td>{{ $pegawai->nama }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        {{-- Tabel Rekapitulasi StatusNikah --}}
        <div class="col-md-4">
            <table class="table table-responsive table-striped table-bordered table-sm">
                <thead class="table">
                    <tr>
                        <th>No.</th>
                        <th>Status Nikah</th>
                        <th>Jml.<br> Pegawai</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($rekap as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->status_nikah }}</td>
                            <td>{{ $item->jumlah }}</td>
                        </tr>
                        @php $total += $item->jumlah; @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2"><strong>Total</strong></td>
                        <td><strong>{{ $total }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Grafik Statistik Status Nikah --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-body mt-3">
                    <div id="chartStatusNikah"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const categories = {!! json_encode($rekap->pluck('status_nikah')) !!};
        const data = {!! json_encode($rekap->pluck('jumlah')) !!};

        // Array warna untuk membedakan tiap golongan ruang
        const colors = [
            "#FF5733", "#33FF57", "#3357FF", "#F39C12", "#8E44AD", "#16A085", "#E74C3C",
            "#2ECC71", "#3498DB", "#D35400", "#C0392B", "#7D3C98", "#27AE60", "#2980B9"
        ];

        // Format ulang data agar setiap kategori memiliki series sendiri
        const seriesData = categories.map((category, index) => ({
            name: category, // Nama untuk legend
            data: [data[index]], // Data jumlah pegawai
        }));

        new ApexCharts(document.querySelector("#chartStatusNikah"), {
            chart: {
                type: 'bar',
                height: 500,
                stacked: false // Pastikan tidak bertumpuk
            },
            series: seriesData, // Menggunakan multiple series
            xaxis: {
                categories: ['StatusNikah'] // Hanya satu kategori (untuk semua jenis kepegawaian)
            },
            yaxis: {
                title: {
                    text: 'Status Nikah'
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            colors: colors.slice(0, categories.length), // Gunakan warna unik untuk setiap series
            title: {
                text: 'Statistik Status Nikah',
                align: 'center'
            },
            legend: {
                position: 'bottom', // Menampilkan legend di bawah chart
            }
        }).render();
    });
</script>

@endsection