@extends('layouts.admin')

@section('title', 'CMCU | Liste des roles')

@section('content')

    <body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
    @include('partials.header')
    <!--// top-bar -->
        <div class="container">
            <h1 class="text-center">LISTE DES ROLES</h1>
        </div>
        <hr>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <!--  -->
                        <table id="myTable" class="table table-bordered table-striped" width="100%">
                            <thead>
                            <th>
                                ID
                            </th>
                            <th>ROLE</th>
                            <th>EDITER</th>
                            {{--<th>VOIR</th>--}}
                            <th>SUPPRIMER</th>
                            </thead>
                            <tbody>

                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        <p data-bs-placement="top" data-bs-toggle="tooltip" title="Edit">
                                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                                        </p>
                                    </td>
                                    {{--<td>--}}
                                        {{--<p data-bs-placement="top" data-bs-toggle="tooltip" title="Voir">--}}
                                            {{--<a href="{{ route('roles.show', $role->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>--}}
                                        {{--</p>--}}
                                    {{--</td>--}}
                                    <td>
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="post">
                                            @csrf @method('DELETE')
                                            <p data-bs-placement="top" data-bs-toggle="tooltip" title="Delete">
                                                <button type="submit" class="btn btn-danger btn-sm"  onclick="return myFunction()"><i class="fas fa-trash-alt"></i></button>
                                            </p>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="clearfix"></div>
                        {{--{{ $roles->links() }}--}}
                    </div>
                    <br>
                    <div class="table_link_right text-center">
                        <a href="{{ route('roles.create') }}" class="btn btn-primary">Ajouter un role</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        function myFunction() {
            if(!confirm("Veuillez confirmer la suppréssion du role"))
                event.preventDefault();
        }
    </script>
    </body>

@stop

