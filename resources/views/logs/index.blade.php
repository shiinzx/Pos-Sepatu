@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold">
                <i class="fas fa-history"></i> Riwayat Aktivitas
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">Waktu</th>
                                <th class="px-4 py-3">Aksi</th>
                                <th class="px-4 py-3">Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                            <tr>
                                <td class="px-4 py-3 text-muted">{{ $log->created_at->format('d M Y H:i:s') }}</td>
                                <td class="px-4 py-3 fw-bold">{{ $log->action }}</td>
                                <td class="px-4 py-3">{{ $log->description }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">Belum ada riwayat aktivitas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
