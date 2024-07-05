<tr class="{{isset($type) ? ($type==config('constants.permissionType.url.id')?'table-secondary':'table-primary') : ''}}">
    <td>
        @include('components.select',[
            'id' => 'type_'.$id,
            'name' => "data[".$id."][type]",
            'class' => '',
            'mandatory' => true,
            'multiple' => false,
            'disabled' => false,
            'default' => '',
            'options' => config('constants.permissionType'),
            'selected' => isset($type) ? $type : ''
        ])
    </td>
    <td>
        <input type="text" name="data[{{$id}}][category]" class="form-control validate" placeholder="Category" value="{{$category ?? ''}}">
    </td>
    <td>
        @include('components.select',[
            'id' => 'type_'.$id,
            'name' => "data[".$id."][name]",
            'class' => '',
            'mandatory' => true,
            'multiple' => false,
            'disabled' => false,
            'default' => 'Select',
            'options' => $routes ?? [],
            'selected' => $name ?? ''
        ])
    </td>
    <td class="text-center">
        <a href="javascript:void(0)" class="btn btn-danger btn-circle deleteRecord" url="{{isset($new) && $new ? '' : route('permissions.destroy',urlencode(base64_encode($id)))}}">
            <i class="fas fa-trash"></i>
        </a>
    </td>
</tr>
