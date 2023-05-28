 @if(count($module_permissions) > 0)
  @php
    $module_role_permissions = [];
    if(!empty($role_permissions)) {
      $module_role_permissions = $role_permissions;
    }
  @endphp
  @foreach($module_permissions as $key => $value)
  <hr>
  <div class="mb-10">
        <div class="show-cr-prod-tab">
            <span>{{$key}}</span><i class="fas fa-plus"></i>
        </div>
        <div class="hidden-cr-prod-tab" style="padding:unset">
          <div class="row check_group">
            <div class="col-md-3">
              <h4>{{$key}}</h4>
            </div>
            <div class="col-md-9">
              @foreach($value as $module_permission)
              @php
                if(empty($role_permissions) && $module_permission['default']) {
                  $module_role_permissions[] = $module_permission['value'];
                }
              @endphp
              <div class="col-md-12">
                <div class="checkbox">
                  <label>
                    {!! Form::checkbox('permissions[]', $module_permission['value'], in_array($module_permission['value'], $module_role_permissions), 
                    [ 'class' => 'input-icheck']); !!} {{ $module_permission['label'] }}
                  </label>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
  </div>
  @endforeach
@endif