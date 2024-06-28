@extends('adminlte::page')
@section('title', config('app.name').' - Produk')
@section('content')
<x-alert></x-alert>
<div class="card">
<div class="card-header bg-white">
<h4 class="my-auto d-flex justify-content-between">
Daftar Data Produk
<a href="{{ route('produk.create') }}" class="btn btn-primary">Create Data</a>
</h4>
</div>
<div class="card-body">
<table class="table table-bordered">
<thead>
<tr>
<th scope="col" class="text-center" width="5%">#</th>
<th scope="col" width="15%">Gambar</th>
<th scope="col">Nama Produk</th>
<th scope="col" width="15%">Harga</th>
<th scope="col" width="10%">Stok</th>
<th scope="col" width="15%">Action</th>
</tr>
</thead>
<tbody>
@php $no = 1 @endphp
@foreach ($produks as $prd)
<tr>
<th scope="row" class="text-center">{{ $no++ }}</th>
<td><img src="{{ asset('img/produk/'.$prd->gbr_prd) }}" alt="..." class="img-thumbnail"></td>
<td>
{{ $prd->nm_prd }} <br>
{{-- badge untuk kategori --}}
<span class="badge badge-dark">{{ $prd->kategori->nm_kat }}</span>
</td>
<td class="text-right">Rp. {{ $prd->hrg_prd }}</td>
<td class="text-right">{{ $prd->stok_prd }}</td>
<td class="text-center">
    <a href="{{ route('produk.edit', ['produk'=>$prd->id_prd]) }}" class="btn btn-sm btn-warning">Edit</a>
    <button class="btn btn-sm btn-danger d-inline" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this product?')) document.getElementById('deleteForm{{$prd->id_prd}}').submit();">
        Delete
    </button>
    <form id="deleteForm{{$prd->id_prd}}" action="{{ route('produk.destroy', ['produk'=>$prd->id_prd]) }}" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>
</td>

</tr>
@endforeach
</tbody>
</table>
</div>
</div>
@stop