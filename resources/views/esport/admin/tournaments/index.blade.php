@extends('buku_tamu.admin.dashboard') {{-- jika dashboard ini bukan layout, pakai layouts umum --}}
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4>Esport • Tournaments</h4>
  <a href="{{ route('esport.admin.tournaments.create') }}" class="btn btn-primary btn-sm">Tambah</a>
</div>
<table class="table table-striped align-middle">
  <thead><tr><th>Poster</th><th>Judul</th><th>Game</th><th>Status</th><th>Tanggal</th><th></th></tr></thead>
  <tbody>
    @foreach($rows as $t)
    <tr>
      <td style="width:90px">@if($t->image)<img src="{{ asset('storage/'.$t->image) }}" class="img-fluid">@endif</td>
      <td>{{ $t->title }}</td>
      <td>{{ $t->game }}</td>
      <td>{{ $t->status }}</td>
      <td>{{ $t->date? \Carbon\Carbon::parse($t->date)->format('d M Y') : '-' }}</td>
      <td class="text-end">
        <a href="{{ route('esport.admin.tournaments.edit',$t) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
        <form action="{{ route('esport.admin.tournaments.destroy',$t) }}" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Hapus?')">Hapus</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{ $rows->links() }}
@endsection
