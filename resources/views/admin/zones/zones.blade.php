
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="table-responsive">
        	<table id="geniustable" class="main_light_table table table-hover dt-responsive" cellspacing="0" width="100%">
        		<thead>
        			<tr>
                        <th>@lang("lang_v1.city")</th>
                        <th>@lang("lang_v1.options")</th>
        			</tr>
        		</thead>
        		 <tbody>
        		     @forelse($city->cities as $p)
            		     <tr>
            		      <td>{{$p->name}}</td>
            		        <td> <a href="{{route('admin-zones-delete-city',$p->id)}}"  class="btn btn-danger delete"><i class="fas fa-trash-alt"></i></a></td>   
            		     </tr>
            		     
            		     @empty
            		      <tr>
            		        <td>@lang("lang_v1.no_cities")</td>
            		     </tr> 
        		     @endforelse
        		</tbody>
        	</table>
        </div>
        
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->


