@extends('dashboard.layouts.main')

@section('main')
<div class="container">
    <h2>Presensi Pegawai</h2>

    <form action="{{ route('presences.store') }}" method="POST" id="checkin-form">
        @csrf
        <label for="pegawai_id">Pilih Pegawai:</label>
        <select name="pegawai_id" id="pegawai_id" require>
                <option selected disabled>-- Pilih Pegawai --</option>
            @foreach(App\Models\Pegawai::all() as $pegawai)
                <option value="{{ $pegawai->id }}">{{ $pegawai->nip }} - {{ $pegawai->nama }}</option>
            @endforeach
        </select>
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
        <input type="text" name="alamat" id="alamat" placeholder="Alamat Anda" readonly>
        <button type="submit" class="btn btn-primary">Check In</button>
    </form>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>Pegawai</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($presences as $presence)
            <tr>
                <td>{{ $presence->pegawai->nama }}</td>
                <td>{{ \Carbon\Carbon::parse($presence->check_in)->format('d-m-Y H:i:s') }}</td>
                <td>{{ $presence->check_out ? \Carbon\Carbon::parse($presence->check_out)->format('d-m-Y H:i:s') : 'Belum Check Out' }}</td>
                <td>
                    @if(!$presence->check_out)
                    <form action="{{ route('presences.update', $presence->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success btn-sm">Check Out</button>
                    </form>
                    @else
                        Selesai
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection