@extends('guest_layouts.install')

    @section('content')
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>Updation</strong> Wizard</h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" action="{!! URL::to('/update') !!}" method="post" class="update-app-form" id="update-app-form">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                <input type="text" name="hostname" id="hostname" class="form-control text-input" placeholder="Hostname">
                                </div>
                                <div class="form-group">
                                <input type="text" name="mysql_database" id="mysql_database" class="form-control text-input" placeholder="MySQL Database">
                                </div>
                                <div class="form-group">
                                <input type="text" name="mysql_username" id="mysql_username" class="form-control text-input" placeholder="MySQL Username">
                                </div>
                                <div class="form-group">
                                <input type="text" name="mysql_password" id="mysql_password" class="form-control text-input" placeholder="MySQL Password">
                                </div>
                                <div class="form-group">
                                <input type="text" name="envato_username" id="envato_username" class="form-control text-input" placeholder="Envato Username">
                                </div>
                                <div class="form-group">
                                <input type="text" name="purchase_code" id="purchase_code" class="form-control text-input" placeholder="Purchase Code">
                                </div>
                                <div class="form-group">
                                <input type="email" name="email" id="email" class="form-control text-input" placeholder="Email">
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success btn-block"><i class="fa fa-unlock"></i> Verify</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @stop
