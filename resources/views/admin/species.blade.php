@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">
                        Species
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                      {{ 'Showing '.$species->count(). ' of ' . $species->total() .' species'  }}
                                </div>
                            </div>
                            <div class="col-md-6 pull-right">
                                <div class="mb-2">
                                    <input id="query" name="search" onkeydown="if (event.keyCode == 13) window.location.href = window.location.pathname+'?q=' + document.getElementById('query').value" type="text" class="form-control" placeholder="Search">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive-md ">
                            <table class="table table-hover table-bordered ">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <p class="fw-bolder">ID</p>
                                        </th>
                                        <th scope="col">
                                            <p class="fw-bolder">Name</p>
                                        </th>
                                        <th scope="col">
                                            <p class="fw-bolder">Kingdom</p>
                                        </th>
                                        <th scope="col">
                                            <p class="fw-bolder">Phylum</p>
                                        </th>
                                        <th scope="col">
                                            <p class="fw-bolder">Class</p>
                                        </th>
                                        <th scope="col">
                                            <p class="fw-bolder">Order</p>
                                        </th>
                                        <th scope="col">
                                            <p class="fw-bolder">Family</p>
                                        </th>
                                        <th scope="col">
                                            <p class="fw-bolder">Genus</p>
                                        </th>
                                        <th scope="col">
                                            <p class="fw-bolder">Species</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($species as $sp)
                                        <tr>
                                            <th scope="row">{{ $sp->species_id }}</th>
                                            <th>{{ $sp->name }}</th>
                                            <td>{{ $sp->kingdom }}</td>
                                            <td>{{ $sp->phylum }}</td>
                                            <td>{{ $sp->class }}</td>
                                            <td>{{ $sp->order }}</td>
                                            <td>{{ $sp->family }}</td>
                                            <td>{{ $sp->genus }}</td>
                                            <td>{{ $sp->species }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="pull-right">
                            {{ $species->links() }}
                        </div>


                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
