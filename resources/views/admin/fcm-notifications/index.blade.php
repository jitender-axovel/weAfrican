@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
    <h2>Notification</h2>
    <hr>
    <div class="col-md-7 fcm-section">
        <section class="fcm_users" required>
            <header class="panel-heading"><strong>Select Users to whom you want to send Notification</strong> </header>
            <select class="form-control" id="select_type" name="select_action" required="">
                    <option value="" > Select </option>
                    <option value="1">Business users</option>
                    <option value="2">End Users</option>
                    <option value="3">All Users</option>
            </select>
        </section>
        <?php /*?><table id="users_list" class="display">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>User Name</th>
                    <th>User Role</th>
                    <th>Send Message?</th>
                </tr>
            </thead>
            <tbody>
                @if($fcmUsers)
                    @foreach($fcmUsers as $fcmUser)
                    <tr>
                        <td>{{$fcmUser->id}}</td>
                        <td>{{$fcmUser->full_name}}</td>
                        <td>{{$fcmUser->user_role_id}}</td>   
                        <td>
                            <ul class="list-inline">
                                <li>
                                   <span class="wrapper"><input type="checkbox" name="sendmsg[]" value="{{ $fcmUser->fcm_reg_id}}"/></span>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table><?php */?>
    </div>
    <div class="col-md-5 message-section">
        <p class="header">Type your message</p>
        <textarea cols="15" rows="5" value="txtarea"></textarea>
        <button onclick="sendMsg()">Send Message</button>
    </div>
    <div class="col-md-12 serverresponse hidediv">
        <center><button id="sendmsg">Send Message Again</button></center>
    </div>
    <script type="text/javascript">
        $(document).ready( function () {
            $('#users_list').DataTable();
        } );
    </script>
@endsection
@section('scripts')
<script>

	$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
	
    function sendMsg(){
   

    var msgLength = $.trim($("textarea").val()).length;
    <?php /*?>var checkedCB = $("input[type='checkbox']:checked").length;
    if( checkedCB == 0){
    	alert("You must select atleast one User to send message");
    }else <?php */?>if(msgLength == 0){
    	alert("You left the message field blank, please fill it");
    }else{
         var cus = document.getElementById('select_type');
        var custid = cus.options[cus.selectedIndex].value;
        alert(custid);
    	var formData = $(".wrapper").find("input").serialize() + "&message=" + $("textarea").val() + "&type=" +custid;	
    	$.ajax({type: "POST",data: formData, url: "{{url('admin/send/notification')}}", success:function(res){
    		$(".greetblock").slideUp(1000);
    		$(".serverresponse").prepend(res).hide().fadeIn(2000);
    	}});
    }
    }
    $(function(){
    	$(".serverresponse").hide()
    	$("input[type='checkbox']").click(function(){
    		if($(this).is(':checked')){
    			$(this).parent().css("border","3px solid red");
    		}else{
    			$(this).parent().css("border","0px");
    		}
    	});
    	
    	$("div.leftdiv, div.rightdiv").hover(function(){
    		$(this).css("background","#FAFAFA");
    	},function(){
    		$(this).css("background","#fff");
    	});
    	
    	$("#festival").change(function(){
    		$("img").attr("src",$(this).val());
    	});
    	
    	$("#sendmsg").click(function(){
    		$(".serverresponse").fadeOut(300,function(){
    			$(".greetblock").fadeIn(1000);
    		});		
    	});
    });
</script>
@endsection