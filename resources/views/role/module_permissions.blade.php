@if(count($module_permissions) > 0)
    @php
        $module_role_permissions = [];
        if(!empty($role_permissions)) {
            $module_role_permissions = $role_permissions;
        }
    @endphp
    @foreach($module_permissions as $key => $value)
        <div class="default-box default-box-dashed">
            <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                <h4><i class="fab fa-buromobelexperte"></i> {{$key}}</h4>
                <i class="fas fa-caret-down main-color-light"></i>
            </div>
            <div class="default-box-body hidden-default-box-body">
                <div class="row">
                    <div class="form-group check_group">
                        <div>
                            <div class="d-flex flex-wrap">
                                @foreach($value as $module_permission)
                                    @php
                                        if(empty($role_permissions) && $module_permission['default']) {
                                            $module_role_permissions[] = $module_permission['value'];
                                        }
                                    @endphp
                                    <div class="checkbox">
                                        <label>
                                            {!! Form::checkbox('permissions[]', $module_permission['value'], in_array($module_permission['value'], $module_role_permissions), 
                                            [ 'class' => 'input-icheck']); !!} {{ $module_permission['label'] }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif