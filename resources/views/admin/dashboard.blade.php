@extends('admin.layouts.main')
@section('content')




<div class="row">
    <div class="col-12 col-xl-12 mb-4">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-light shadow-sm">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                            <h2 class="h5">Mark Your At</h2>
                            </div>
                            <div class="col text-right">
                                <a href="#" class="btn btn-sm btn-secondary">See all</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Page name</th>
                                <th scope="col">Page Views</th>
                                <th scope="col">Page Value</th>
                                <th scope="col">Bounce rate</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">
                                    /demo/admin/index.html
                                </th>
                                <td>
                                    3,225
                                </td>
                                <td>
                                    $20
                                </td>
                                <td>
                                    <span class="fas fa-arrow-up text-danger mr-3"></span> 42,55%
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    /demo/admin/forms.html
                                </th>
                                <td>
                                    2,987
                                </td>
                                <td>
                                    0
                                </td>
                                <td>
                                    <span class="fas fa-arrow-down text-success mr-3"></span> 43,52%
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    /demo/admin/util.html
                                </th>
                                <td>
                                    2,844
                                </td>
                                <td>
                                294
                                </td>
                                <td>
                                    <span class="fas fa-arrow-down text-success mr-3"></span> 32,35%
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    /demo/admin/validation.html
                                </th>
                                <td>
                                    2,050
                                </td>
                                <td>
                                    $147
                                </td>
                                <td>
                                    <span class="fas fa-arrow-up text-danger mr-3"></span> 50,87%
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    /demo/admin/modals.html
                                </th>
                                <td>
                                    1,483
                                </td>
                                <td>
                                    $19
                                </td>
                                <td>
                                    <span class="fas fa-arrow-down text-success mr-3"></span> 32,24%
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
    
</div>
@endsection
